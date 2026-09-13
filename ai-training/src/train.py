"""Fruit YOLO training. Baseline pipeline, not SOTA chase."""
import os
from pathlib import Path
import yaml
from ultralytics import YOLO

PROJECT_ROOT = Path(__file__).resolve().parent.parent


def load_env():
    env = PROJECT_ROOT / ".env"
    if not env.exists():
        return
    for line in env.read_text().splitlines():
        line = line.strip()
        if line and not line.startswith("#") and "=" in line:
            k, v = line.split("=", 1)
            os.environ.setdefault(k.strip(), v.strip())


load_env()
DATASET_CONFIG = PROJECT_ROOT / os.getenv("DATASET_CONFIG", "config/dataset.yaml")
def _parse_batch(raw: str):
    raw = raw.strip()
    # ponytail: int or 'auto' only, upgrade to float fraction when tuning needs it.
    return int(raw) if raw.lstrip("-").isdigit() else raw


BASE_MODEL = os.getenv("BASE_MODEL", "yolov8n.pt")
EPOCHS = int(os.getenv("EPOCHS", "50"))
IMAGE_SIZE = int(os.getenv("IMAGE_SIZE", "640"))
BATCH_SIZE = _parse_batch(os.getenv("BATCH_SIZE", "16"))
DEVICE = os.getenv("DEVICE", "auto")
PROJECT = PROJECT_ROOT / "runs" / "detect"
RUN_NAME = "fruit-training"


def validate_dataset_config() -> dict:
    if not DATASET_CONFIG.exists():
        raise FileNotFoundError(f"dataset config missing: {DATASET_CONFIG}")
    cfg = yaml.safe_load(DATASET_CONFIG.read_text())
    for key in ("train", "val", "names"):
        if key not in cfg:
            raise ValueError(f"dataset.yaml missing key: {key}")
    # ponytail: label range check only, upgrade to full image/label audit when dataset lands.
    names = cfg["names"]
    if not names:
        raise ValueError("dataset.yaml has empty class names")
    return cfg


def resolve_device() -> str:
    if DEVICE != "auto":
        return DEVICE
    try:
        import torch

        if torch.cuda.is_available():
            return "0"
        if getattr(torch.backends, "mps", None) and torch.backends.mps.is_available():
            return "mps"
    except ImportError:
        pass
    return "cpu"


def main() -> None:
    cfg = validate_dataset_config()
    device = resolve_device()
    print(f"dataset classes: {cfg['names']}")
    print(f"device: {device}")
    model = YOLO(BASE_MODEL)
    results = model.train(
        data=str(DATASET_CONFIG),
        epochs=EPOCHS,
        imgsz=IMAGE_SIZE,
        batch=BATCH_SIZE,
        device=device,
        project=str(PROJECT),
        name=RUN_NAME,
    )
    print(f"best weights: {results.save_dir}/weights/best.pt")
    print(f"copy to: {PROJECT_ROOT / 'weights' / 'best.pt'}")


if __name__ == "__main__":
    main()

"""Fruit YOLO inference. Image dir fixed in source, no CLI input needed."""
import os
from pathlib import Path
import sys
import cv2
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
MODEL_PATH = PROJECT_ROOT / os.getenv("MODEL_PATH", "weights/best.pt")
IMAGE_DIRECTORY = PROJECT_ROOT / os.getenv("IMAGE_DIRECTORY", "samples/input")
OUTPUT_DIRECTORY = PROJECT_ROOT / os.getenv("OUTPUT_DIRECTORY", "samples/output")
SUPPORTED_EXTENSIONS = {".jpg", ".jpeg", ".png", ".bmp", ".webp"}
WINDOW_TITLE = "Wrapstation Fruit Detection"


def fail(msg: str) -> "NoReturn":
    from typing import NoReturn  # local import keeps top clean
    print(f"ERROR: {msg}", file=sys.stderr)
    raise SystemExit(1)


def find_images(directory: Path) -> list[Path]:
    return sorted(p for p in directory.iterdir() if p.suffix.lower() in SUPPORTED_EXTENSIONS and p.is_file())


def main() -> None:
    if not MODEL_PATH.exists():
        fail(f"model missing: {MODEL_PATH} (run train.py, copy best.pt to weights/)")
    if not IMAGE_DIRECTORY.is_dir():
        fail(f"input dir missing: {IMAGE_DIRECTORY}")
    images = find_images(IMAGE_DIRECTORY)
    if not images:
        fail(f"no images in {IMAGE_DIRECTORY}")
    OUTPUT_DIRECTORY.mkdir(parents=True, exist_ok=True)
    try:
        model = YOLO(str(MODEL_PATH))
    except Exception as exc:
        fail(f"model load failed: {exc}")
    print(f"model: {MODEL_PATH}")
    print(f"images: {len(images)} | N/Space next, Q/Esc quit")

    for path in images:
        img = cv2.imread(str(path))
        if img is None:
            print(f"skip corrupt/unreadable: {path.name}")
            continue
        try:
            results = model.predict(img, verbose=False)
        except Exception as exc:
            print(f"predict failed {path.name}: {exc}")
            continue
        annotated = results[0].plot()
        boxes = results[0].boxes
        if boxes is not None:
            for box in boxes:
                cls = model.names[int(box.cls[0])]
                conf = float(box.conf[0])
                print(f"  {path.name}: {cls} {conf:.2f}")
        out = OUTPUT_DIRECTORY / f"{path.stem}_detected{path.suffix}"
        cv2.imwrite(str(out), annotated)
        try:
            cv2.imshow(WINDOW_TITLE, annotated)
        except cv2.error as exc:
            fail(f"GUI display failed (headless?): {exc}")
        while True:
            key = cv2.waitKey(0) & 0xFF
            if key in (ord("q"), 27):
                cv2.destroyAllWindows()
                print(f"saved: {out}")
                return
            if key in (ord("n"), ord(" ")):
                break
        print(f"saved: {out}")
    cv2.destroyAllWindows()


if __name__ == "__main__":
    main()

"""Camera config. .env first, fallback defaults."""
import os
from pathlib import Path

SRC_DIR = Path(__file__).resolve().parent


def load_env():
    env = SRC_DIR.parent / ".env"
    if not env.exists():
        return
    for line in env.read_text().splitlines():
        line = line.strip()
        if line and not line.startswith("#") and "=" in line:
            k, v = line.split("=", 1)
            os.environ.setdefault(k.strip(), v.strip())


load_env()


def _int(name, default):
    try:
        return int(os.getenv(name, default))
    except ValueError:
        return default


def _float_or_none(name):
    raw = os.getenv(name, "").strip()
    if not raw:
        return None
    try:
        return float(raw)
    except ValueError:
        return None


CAMERA_INDEX = _int("CAMERA_INDEX", 0)
FRAME_WIDTH = _int("FRAME_WIDTH", 1280)
FRAME_HEIGHT = _int("FRAME_HEIGHT", 720)
FPS = _int("FPS", 30)
SHUTTER_SPEED = _float_or_none("SHUTTER_SPEED")
ISO = _float_or_none("ISO")
BURST_INTERVAL_MS = _int("BURST_INTERVAL_MS", 200)
CAPTURE_DIRECTORY = Path(os.getenv("CAPTURE_DIRECTORY", "captures"))
if not CAPTURE_DIRECTORY.is_absolute():
    CAPTURE_DIRECTORY = SRC_DIR.parent / CAPTURE_DIRECTORY

"""Save frames with timestamp names. Collision-proof."""
from datetime import datetime
from pathlib import Path
import cv2


def save_frame(frame, directory: Path) -> Path:
    directory.mkdir(parents=True, exist_ok=True)
    stamp = datetime.now().strftime("capture_%Y%m%d_%H%M%S_%f")[:-3]
    path = directory / f"{stamp}.jpg"
    i = 1
    while path.exists():
        path = directory / f"{stamp}_{i}.jpg"
        i += 1
    if not cv2.imwrite(str(path), frame):
        raise RuntimeError(f"image write failed: {path}")
    return path

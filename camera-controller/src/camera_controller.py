import sys
from pathlib import Path
sys.path.insert(0, str(Path(__file__).resolve().parent))
import cv2
import config


class CameraController:
    def __init__(self):
        self.cap = None
        self.actual = {}

    def open(self):
        self.cap = cv2.VideoCapture(config.CAMERA_INDEX)
        if not self.cap.isOpened():
            raise RuntimeError(f"cannot open camera index {config.CAMERA_INDEX}")
        self.cap.set(cv2.CAP_PROP_FRAME_WIDTH, config.FRAME_WIDTH)
        self.cap.set(cv2.CAP_PROP_FRAME_HEIGHT, config.FRAME_HEIGHT)
        self.cap.set(cv2.CAP_PROP_FPS, config.FPS)
        self._try_optional("shutter", cv2.CAP_PROP_EXPOSURE, config.SHUTTER_SPEED)
        self._try_optional("iso", cv2.CAP_PROP_ISO_SPEED, config.ISO)
        self.actual = {
            "width": self.cap.get(cv2.CAP_PROP_FRAME_WIDTH),
            "height": self.cap.get(cv2.CAP_PROP_FRAME_HEIGHT),
            "fps": self.cap.get(cv2.CAP_PROP_FPS),
        }
        return self.actual

    def _try_optional(self, name, prop, value):
        if value is None:
            return
        try:
            self.cap.set(prop, value)
            actual = self.cap.get(prop)
            print(f"WARNING: {name} requested {value}, actual {actual} (may be unsupported)")
        except Exception as exc:
            print(f"WARNING: {name} unsupported: {exc}")

    def read(self):
        ok, frame = self.cap.read()
        if not ok or frame is None:
            raise RuntimeError("frame read failed (camera disconnected?)")
        return frame

    def release(self):
        if self.cap:
            self.cap.release()
            self.cap = None

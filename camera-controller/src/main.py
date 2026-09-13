"""Live preview + Space capture + hold-B burst. Timer-driven, no GUI freeze."""
import sys
from pathlib import Path
sys.path.insert(0, str(Path(__file__).resolve().parent))
import cv2
from PyQt6.QtCore import QTimer, Qt
from PyQt6.QtGui import QImage, QPixmap
from PyQt6.QtWidgets import QApplication, QLabel, QMainWindow, QVBoxLayout, QWidget

from camera_controller import CameraController
from capture_service import save_frame
import config


class MainWindow(QMainWindow):
    def __init__(self):
        super().__init__()
        self.setWindowTitle("Wrapstation Camera Controller")
        self.cam = CameraController()
        try:
            actual = self.cam.open()
        except RuntimeError as exc:
            print(f"ERROR: {exc}")
            raise SystemExit(1)
        self.frame = None
        self.bursting = False

        self.view = QLabel()
        self.view.setAlignment(Qt.AlignmentFlag.AlignCenter)
        self.info = QLabel(
            f"Camera {config.CAMERA_INDEX} | "
            f"{int(actual['width'])}x{int(actual['height'])} | {actual['fps']:.0f} FPS"
        )
        self.keys = QLabel("Space Capture | Hold B Burst | Q Quit")
        self.status = QLabel("Status: Ready")
        layout = QVBoxLayout()
        layout.addWidget(self.view)
        layout.addWidget(self.info)
        layout.addWidget(self.keys)
        layout.addWidget(self.status)
        wrap = QWidget()
        wrap.setLayout(layout)
        self.setCentralWidget(wrap)

        self.preview = QTimer(self)
        self.preview.timeout.connect(self.tick)
        self.preview.start(33)
        self.burst = QTimer(self)
        self.burst.timeout.connect(self.do_burst)
        # ponytail: fixed 33ms preview, upgrade to FPS-measured timer when profiling needs it.

    def tick(self):
        try:
            self.frame = self.cam.read()
        except RuntimeError as exc:
            self.status.setText(f"Status: {exc}")
            return
        rgb = cv2.cvtColor(self.frame, cv2.COLOR_BGR2RGB)
        h, w, ch = rgb.shape
        img = QImage(rgb.data, w, h, ch * w, QImage.Format.Format_RGB888)
        self.view.setPixmap(QPixmap.fromImage(img))

    def capture_once(self):
        if self.frame is None:
            return
        try:
            path = save_frame(self.frame.copy(), config.CAPTURE_DIRECTORY)
            self.status.setText(f"Status: saved {path.name}")
        except RuntimeError as exc:
            self.status.setText(f"Status: {exc}")

    def do_burst(self):
        if self.bursting:
            self.capture_once()

    def keyPressEvent(self, event):
        if event.isAutoRepeat():
            return
        key = event.key()
        if key == Qt.Key.Key_Space:
            self.capture_once()
        elif key == Qt.Key.Key_B:
            self.bursting = True
            self.burst.start(config.BURST_INTERVAL_MS)
            self.status.setText("Status: burst...")
        elif key in (Qt.Key.Key_Q, Qt.Key.Key_Escape):
            self.close()

    def keyReleaseEvent(self, event):
        if event.isAutoRepeat():
            return
        if event.key() == Qt.Key.Key_B:
            self.bursting = False
            self.burst.stop()
            self.status.setText("Status: Ready")

    def closeEvent(self, event):
        self.preview.stop()
        self.burst.stop()
        self.cam.release()
        super().closeEvent(event)


def main():
    app = QApplication(sys.argv)
    win = MainWindow()
    win.show()
    sys.exit(app.exec())


if __name__ == "__main__":
    main()

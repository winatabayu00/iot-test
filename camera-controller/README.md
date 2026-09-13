# Camera Controller

Webcam live preview + capture. OpenCV frames, PyQt6 GUI.

Why PyQt6: burst needs hold/release events. `cv2.waitKey()` repeat unreliable.

## Requirements

- Python 3.11, webcam, desktop GUI session
- `pip install -r requirements.txt`

## Install

```bash
cd camera-controller
python3.11 -m venv .venv
source .venv/bin/activate
pip install -r requirements.txt
```

## Run

```bash
python src/main.py
```

## Keyboard

- `Space` single capture
- hold `B` burst, release stops
- `Q` / `Esc` quit

Mapping also in GUI footer.

## Config

`src/config.py`:

- `CAMERA_INDEX`, `FRAME_WIDTH`, `FRAME_HEIGHT`, `FPS`
- `SHUTTER_SPEED`, `ISO` optional (`None` = device default)
- `BURST_INTERVAL_MS`, `CAPTURE_DIRECTORY`

Actual resolution shown in GUI, not just requested.

## Compatibility

Resolution widely supported. Shutter/ISO depend on device/OS/driver. Unsupported → warning only, preview continues. Never fatal.

Linux optional: `v4l2-ctl --list-devices` to inspect controls.

## Output

`captures/capture_YYYYMMDD_HHMMSS_mmm.jpg`. Gitignored, evidence in `docs/evidence/camera/`.

## Troubleshooting

- camera busy → close Zoom/Meet, check OS permission
- black frame → try index 0/1, wait exposure
- `cannot open camera` → check `CAMERA_INDEX`

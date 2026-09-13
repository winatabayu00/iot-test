# AI Fruit Object Detection

YOLO fruit detector. Train + inference with OpenCV popup.

## Requirements

- Python 3.11
- `pip install -r requirements.txt`

## Environment

- macOS MacBook Air M1 8GB
- device auto: CUDA → MPS → CPU
- no hardcode CUDA

## Dataset

Kaggle fruits dataset, YOLO layout:

```text
dataset/train/images + labels
dataset/valid/images + labels
dataset/test/images + labels (if given)
```

`config/dataset.yaml` points there. Class names match dataset, not invented.

## Install

```bash
cd ai-training
python3.11 -m venv .venv
source .venv/bin/activate
pip install -r requirements.txt
```

## Training

```bash
python src/train.py
```

Copy result:

```bash
cp runs/detect/fruit-training/weights/best.pt weights/best.pt
```

Config top of `src/train.py`: base `yolov8n.pt`, epochs 50, imgsz 640, batch 16.

## Inference

Image dir fixed in source, no CLI input needed.

```bash
python src/inference.py
```

- reads `samples/input/`
- popup `Wrapstation Fruit Detection`
- box + label + confidence
- saves annotated copy to `samples/output/`

Keys: `N` / `Space` next, `Q` / `Esc` quit.

## Troubleshooting

- `model missing` → train first, copy `best.pt` to `weights/`
- `no images` → put jpg/png in `samples/input/`
- `skip corrupt` → file unreadable, ignored
- GUI fail headless → popup needs desktop session

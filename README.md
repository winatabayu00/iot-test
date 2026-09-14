# Wrapstation Full Stack Developer Technical Test

Dokumentasi ini adalah blueprint end-to-end untuk pengerjaan **Test Full Stack Developer - Wrapstation**. Repository implementasi nantinya disarankan menggunakan **satu public GitHub repository** dengan tiga project terpisah agar struktur, setup, dan proses evaluasi mudah dipahami.

## 1. Ringkasan Assignment

Assignment terdiri dari tiga bagian:

1. **AI Training**
   - Object detection untuk mendeteksi dan mengklasifikasikan buah.
   - Dataset menggunakan *Fruits by YOLO - Fruits Detection* yang ditentukan pada soal.
   - Library YOLO diperbolehkan menggunakan Ultralytics, Darknet, atau implementasi relevan lainnya.
   - Wajib menyerahkan:
     - model/weights hasil training (`best.pt`);
     - script training;
     - script inference;
     - inference menggunakan path gambar yang ditentukan di script;
     - hasil inference tampil pada pop-up window dengan bounding box dan label kelas.

2. **IoT & Embedded Systems**
   - Mengakses webcam/kamera komputer.
   - Library wajib OpenCV dan/atau V4L2.
   - Menampilkan live preview real-time melalui GUI.
   - Keyboard mapping untuk capture gambar.
   - Nilai tambahan:
     - konfigurasi resolusi;
     - shutter speed;
     - ISO;
     - burst capture selama tombol ditahan.

3. **CodeIgniter CMS**
   - CMS sederhana untuk simulasi pembelian produk.
   - Tidak memerlukan authentication/authorization.
   - Tetap mengimplementasikan dasar CRUD.
   - Framework wajib CodeIgniter 3 atau 4.
   - Database migration atau SQL dump diperbolehkan.
   - Database schema bebas selama logis.
   - Project harus dapat dijalankan pada localhost.

## 2. Keputusan Teknis

Baseline yang digunakan:

| Area | Teknologi |
|---|---|
| AI | Python 3.11, Ultralytics YOLO, PyTorch, OpenCV |
| Camera | Python 3.11, OpenCV, PyQt6; V4L2 opsional pada Linux |
| CMS | PHP 8.2+, CodeIgniter 4 |
| Database | PostgreSQL 16+ |
| Dependency Management Python | `venv` + `pip` |
| Dependency Management PHP | Composer |
| Version Control | Git |
| Submission | Public GitHub Repository |

> Versi minor package sebaiknya dipin setelah implementasi pertama berhasil pada komputer kandidat agar `requirements.txt` dan `composer.lock` merepresentasikan environment yang benar-benar diuji.

## 3. Target Repository

```text
wrapstation-fullstack-test/
├── README.md
├── .gitignore
├── docs/
│   └── evidence/
│       ├── ai/
│       ├── camera/
│       └── cms/
│
├── ai-training/
│   ├── README.md
│   ├── requirements.txt
│   ├── src/
│   │   ├── train.py
│   │   └── inference.py
│   ├── config/
│   │   └── dataset.yaml
│   ├── weights/
│   │   └── best.pt
│   ├── samples/
│   │   ├── input/
│   │   └── output/
│   └── runs/
│
├── camera-controller/
│   ├── README.md
│   ├── requirements.txt
│   ├── src/
│   │   ├── main.py
│   │   ├── camera_controller.py
│   │   ├── capture_service.py
│   │   └── config.py
│   └── captures/
│
└── codeigniter-cms/
    ├── README.md
    ├── app/
    ├── public/
    ├── writable/
    ├── tests/
    ├── composer.json
    ├── composer.lock
    └── env
```

## 4. Prinsip Implementasi

Seluruh solusi diarahkan pada empat prinsip:

- **Requirement-first** — setiap fitur harus dapat dilacak kembali ke requirement assignment.
- **Reproducible** — evaluator dapat menjalankan project mengikuti README.
- **Simple but production-minded** — tidak over-engineered, tetapi tetap memiliki validation, error handling, logging, migration, testing, dan struktur kode yang jelas.
- **Interview-ready** — kandidat harus mampu menjelaskan flow kode, trade-off, keterbatasan hardware, serta alasan desain.

## 5. Urutan Pengerjaan yang Direkomendasikan

```text
M00  Repository + environment baseline
M01  AI dataset validation & training pipeline
M02  AI inference + popup preview
M03  Camera live preview
M04  Camera capture + optional controls + burst
M05  CMS database + migrations
M06  CMS CRUD
M07  CMS transaction flow
M08  Testing + evidence
M09  Final documentation + public GitHub submission
```

Detail setiap milestone ada di README masing-masing project (cara instal, setup, dan run).

## 6. Dokumen Utama

Mulai membaca dari README masing-masing project:

1. [ai-training/README.md](ai-training/README.md)
2. [camera-controller/README.md](camera-controller/README.md)
3. [codeigniter-cms/README.md](codeigniter-cms/README.md)

> Dokumen desain rinci (arsitektur, traceability, runbook, dsb.) dipelihara di vault internal kandidat dan tidak dipublikasikan di repository ini.

## 7. Submission Requirement Penting

Sebelum submission:

- repository harus **public**;
- seluruh hasil kerja harus sudah di-push;
- cantumkan **OS dan spesifikasi komputer** yang digunakan;
- pastikan `best.pt`, script training, dan script inference tersedia;
- camera live preview dan keyboard capture harus dapat didemokan;
- CMS harus dapat dijalankan pada localhost;
- lakukan konfirmasi pengumpulan dengan link repository sesuai instruksi assignment.

Gunakan checklist ini untuk final audit: repository public, hasil kerja ter-push, spesifikasi OS/komputer dicantumkan, `best.pt` + script training/inference tersedia, camera dapat didemokan, CMS jalan di localhost.

## 8. Lingkungan yang Diuji

- Komputer: MacBook Air (M1, 2020, MacBookAir10,1, MGN93ID/A), RAM 8 GB, tanpa GPU diskrit
- OS: macOS 26.6.2 (Build 25G83)
- Python: 3.11.6 (`venv` + `pip`)
- PHP: 8.3.30, Composer 2.6.5, CodeIgniter 4.7.4
- Database: PostgreSQL 18.6 (server) / psql 18.0 (client)
- Repository: public di `https://github.com/winatabayu00/iot-test`

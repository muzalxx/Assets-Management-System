# 🏢 Assets Management System (AMS)

[![License](https://img.shields.io/badge/License-Apache-blue.svg)](LICENSE)
[![GitHub last commit](https://img.shields.io/github/last-commit/muzalxx/Assets-Management-System)](https://github.com/muzalxx/Assets-Management-System/commits/main)
[![Project Status](https://img.shields.io/badge/Status-Active%20Development-green.svg)](https://github.com/muzalxx/Assets-Management-System)

## ✨ Overview

Assets Management System (AMS) adalah solusi *fullstack* yang dirancang untuk membantu perusahaan melacak, mengelola, dan mengaudit aset fisik mereka secara efisien di berbagai lokasi atau cabang kantor. Sistem ini mengintegrasikan fitur-fitur penting seperti manajemen multi-cabang, otorisasi berbasis peran, dan kemampuan pelaporan yang kuat.

## 🚀 Fitur Utama (Core Features)

| Icon | Fitur | Deskripsi |
| :---: | :--- | :--- |
| 📍 | **Multi-Branch Assets Tracking** | Memungkinkan pengelolaan aset dan inventaris yang tersebar di beberapa **cabang kantor** atau lokasi berbeda dalam satu *dashboard* terpusat. |
| 🛡️ | **Role-Based Access Control (RBAC)** | Manajemen **hak akses akun** yang terperinci. Memastikan setiap pengguna (Admin, Auditor, Staf Cabang) hanya dapat mengakses dan memodifikasi data yang relevan dengan peran mereka. |
| 🏷️ | **Barcode Generation & Scanning** | Kemampuan untuk **mencetak barcode unik** untuk setiap aset. Barcode tersebut menyimpan **detail aset** (ID, lokasi, spesifikasi) untuk *tracking* dan audit yang cepat dan akurat. |
| 📄 | **Advanced PDF Reporting** | Menyediakan **report support PDF** yang *customizable*. Laporan dapat mencakup status inventaris, histori pergerakan aset, dan ringkasan audit. |
| 🔍 | **Detailed Asset Log** | Mencatat semua perubahan, pemindahan, dan status aset secara historis untuk tujuan audit dan kepatuhan. |

## ⚙️ Tech Stack

Sistem ini dibangun dengan mempertimbangkan skalabilitas dan kinerja:

### Frontend
* **[Framework Frontend, Bootstrap]**: Untuk *user interface* yang cepat dan responsif.
* **[Library Styling, Material UI]**: Untuk desain yang bersih dan modern.

### Backend
* **[Framework Backend, Codeigniter 3]**: Menyediakan API RESTful yang aman dan efisien.

### Database
* **[Database, MongoDB]**: Dipilih untuk fleksibilitas skema.

### Lainnya (Tools & Deployment)
* **[Library Barcode, cth: Barcode-EAN / JsBarcode]**: Untuk generasi barcode.
* **[Library PDF, mPDF]**: Untuk pembuatan laporan PDF.

## 💾 Instalasi (Quick Start)

Ikuti langkah-langkah sederhana ini untuk menjalankan proyek secara lokal:

### Prasyarat
* PHP (v5.3++)
* [Database Terkait, MongoDB]

### Langkah-langkah
1.  **Clone Repositori:**
    ```bash
    git clone [https://github.com/](https://github.com/)[your-username]/[repo-name].git
    cd [repo-name]
    ```

2.  **Instal Dependensi:**
    ```bash
    npm install  # atau yarn install
    ```

3.  **Konfigurasi Environment:**
    Buat file `.env` di root direktori dan tambahkan variabel konfigurasi Anda (baseURL, database URL, dll.).
    ```
    # Contoh .env
    DB_URL="[your_database_connection_string]"
    ```

## 🖼️ Tampilan Antarmuka (Optional Screenshots)



[Image of Dashboard Interface]

*Dashboard Utama: Ringkasan Status Aset di Semua Cabang.*


*Halaman Detail Aset: Menampilkan data lengkap dan opsi cetak barcode.*

---

## 👥 Kontribusi

Kontribusi dari komunitas sangat dihargai! Jika Anda memiliki saran atau menemukan *bug*, silakan buka **Issue** atau buat **Pull Request**.

1.  *Fork* repositori ini.
2.  Buat *branch* fitur baru (`git checkout -b feature/nama-fitur`).
3.  Lakukan *commit* perubahan Anda (`git commit -m 'feat: menambahkan fitur XYZ'`).
4.  Dorong ke *branch* (`git push origin feature/nama-fitur`).
5.  Buka **Pull Request** ke *branch* `main`.

## 📄 Lisensi

Proyek ini dilisensikan di bawah **Lisensi Apache** - lihat file [LICENSE](LICENSE) untuk detailnya.

---
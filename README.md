# 🛡️ Brute Force Simulation & Rate Limiting Defense

Proyek ini adalah laboratorium simulasi untuk memahami mekanisme serangan **Brute Force** pada sistem autentikasi dan cara mengimplementasikan pertahanan **Rate Limiting** di sisi server menggunakan PHP dan Python.

---

## 🧐 Ringkasan Proyek
Tujuan dari lab ini adalah untuk menunjukkan perbedaan signifikan antara sistem login yang rentan (vulnerable) dan sistem yang terproteksi (secure) terhadap serangan otomatis (automated attacks).

### 🔍 Komponen Utama:
1. **`vulnerable_login.php`**: Halaman login yang memproses permintaan tanpa batasan frekuensi. Sangat rentan terhadap pengujian ribuan kombinasi password dalam waktu singkat.
2. **`secure_login.php`**: Halaman login yang dilengkapi dengan **Atomic Time-Locking**. Sistem akan mendeteksi jika ada permintaan yang masuk dengan jeda kurang dari 0.2 detik dan memblokir akses secara otomatis.
3. **`brute_bot.py`**: Alat audit berbasis Python yang mensimulasikan penyerang dengan mencoba kombinasi PIN 3-digit (`000`-`999`) secara otomatis.

---

## 🚀 Hasil Pengujian (Audit Log)

Berdasarkan hasil pengujian di lingkungan *localhost*, didapatkan data sebagai berikut:

| Target | Mekanisme Pertahanan | Hasil Audit |
| :--- | :--- | :--- |
| **Vulnerable** | Tidak Ada | **Jebol** (PIN 812 ditemukan dalam ~2 detik) |
| **Secure** | Rate Limiting (0.2s) | **Gagal** (Bot terdeteksi & diblokir di percobaan awal) |

---

## 🛠️ Cara Instalasi & Penggunaan

### 1. Setup Server (PHP)
* Pastikan **Laragon** atau **XAMPP** sudah berjalan (Apache Active).
* Letakkan file `vulnerable_login.php` dan `secure_login.php` di dalam direktori `www/brute_sim/`.
* Akses via browser di `http://localhost/brute_sim/vulnerable_login.php`.

### 2. Jalankan Audit (Python)
* Buka Terminal/CMD dan masuk ke folder tempat `brute_bot.py` berada.
* Jalankan perintah:
  ```bash
  python brute_bot.py

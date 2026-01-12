# Aplikasi Web SPK Pemilihan Pemain Esports Terbaik (Metode TOPSIS)

## Deskripsi

Aplikasi Web **SPK Pemilihan Pemain Esports Terbaik** adalah sistem pendukung keputusan berbasis web yang dibangun menggunakan **CodeIgniter 4** dan **MySQL**. Aplikasi ini menerapkan metode **TOPSIS (Technique for Order Preference by Similarity to Ideal Solution)** untuk membantu menentukan pemain esports terbaik berdasarkan sejumlah kriteria penilaian secara objektif dan terukur.

Sistem ini dirancang untuk membantu **manajer tim esports, pelatih, maupun organisasi esports** dalam mengambil keputusan strategis, seperti pemilihan pemain inti, evaluasi performa pemain, atau rekrutmen pemain baru.

---

## Tujuan Sistem

- Membantu pengambilan keputusan pemilihan pemain esports terbaik
- Mengurangi subjektivitas dalam penilaian pemain
- Memberikan hasil perangkingan pemain berdasarkan perhitungan matematis

---

## Kriteria Penilaian (Contoh)

Kriteria dapat disesuaikan dengan kebutuhan tim esports, antara lain:

- Kill/Death/Assits Ratio (K/D)
- Heropool
- Average Damage / Contribution
- Teamwork

Setiap kriteria dapat diklasifikasikan sebagai **Benefit** atau **Cost** serta memiliki bobot sesuai tingkat kepentingannya.

---

## Fitur Utama

- Manajemen data **pemain esports** (alternatif)
- Manajemen **kriteria & bobot penilaian**
- Input nilai performa pemain
- Perhitungan otomatis metode **TOPSIS**:

  - Normalisasi matriks keputusan
  - Normalisasi terbobot
  - Solusi ideal positif & negatif
  - Nilai preferensi

- Perangkingan pemain esports terbaik
- Tampilan hasil perhitungan yang jelas dan informatif

---

## Teknologi yang Digunakan

- **Framework**: CodeIgniter 4
- **Bahasa Pemrograman**: PHP 8.1+
- **Database**: MySQL
- **Web Server**: Apache / Nginx
- **Arsitektur**: MVC (Model–View–Controller)

---

## Konfigurasi Environment

Aplikasi ini menggunakan file `.env` untuk konfigurasi environment.

### Contoh Konfigurasi Database

```env
CI_ENVIRONMENT = development

database.default.hostname = localhost
database.default.database = topsis
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi
database.default.port = 3306
```

Pastikan database dengan nama **topsis** sudah dibuat sebelum menjalankan aplikasi.

---

## Instalasi

1. **Clone repository**

   ```bash
   git clone <https://github.com/lintangbhanu/SPK_Topsis.git>
   cd spk_topsis
   ```

2. **Install dependency**

   ```bash
   composer install
   ```

3. **Konfigurasi environment**

   - Salin file `env` menjadi `.env`
   - Sesuaikan `baseURL` dan konfigurasi database

4. **Migrasi database (jika tersedia)**

   ```bash
   php spark migrate
   ```

5. **Jalankan server**

   ```bash
   php spark serve
   ```

6. Akses aplikasi melalui browser:

   ```
   http://localhost:8080
   ```

---

## Struktur Direktori Utama

```
app/
 ├── Controllers/
 ├── Models/
 ├── Views/
 └── Config/
public/
.env
composer.json
```

---

## Metode TOPSIS (Alur Singkat)

1. Menentukan pemain esports (alternatif)
2. Menentukan kriteria dan bobot penilaian
3. Menyusun matriks keputusan
4. Normalisasi matriks keputusan
5. Normalisasi terbobot
6. Menentukan solusi ideal positif dan negatif
7. Menghitung jarak setiap alternatif
8. Menghitung nilai preferensi
9. Menentukan peringkat pemain esports terbaik

---

## Kebutuhan Server

- PHP **8.1 atau lebih tinggi**
- Ekstensi PHP:

  - intl
  - mbstring
  - json
  - mysqlnd
  - curl

---

## Catatan Penting

- Folder **public/** adalah root aplikasi (document root web server)
- Jangan arahkan web server ke root project secara langsung
- Pastikan hak akses folder `writable/` sudah benar

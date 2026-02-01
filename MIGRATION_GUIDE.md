# Migration Guide - SPK TOPSIS

## Daftar File Migrasi

File migrasi telah dibuat dengan urutan yang benar untuk menghindari konflik foreign key:

1. `2024-01-01-000001_CreateUsersTable.php` - Tabel users
2. `2024-01-01-000002_CreateRoleTable.php` - Tabel role
3. `2024-01-01-000003_CreateKriteriaTable.php` - Tabel kriteria
4. `2024-01-01-000004_CreatePemainTable.php` - Tabel pemain
5. `2024-01-01-000005_CreateBobotTable.php` - Tabel bobot
6. `2024-01-01-000006_CreateScrimTable.php` - Tabel scrim
7. `2024-01-01-000007_CreateHeroPoolTable.php` - Tabel heropool
8. `2024-01-01-000008_CreateNilaiScrimTable.php` - Tabel nilai_scrim

## Cara Menjalankan Migrasi

### 1. Menjalankan Semua Migrasi
```bash
php spark migrate
```

### 2. Menjalankan Migrasi Tertentu
```bash
php spark migrate -g default
```

### 3. Rollback Migrasi
```bash
php spark migrate:rollback
```

### 4. Reset Database (Hapus semua tabel dan jalankan ulang)
```bash
php spark migrate:reset
php spark migrate
```

### 5. Refresh Database (Rollback dan migrate ulang)
```bash
php spark migrate:refresh
```

## Menjalankan Seeder

### 1. Menjalankan Semua Seeder
```bash
php spark db:seed DatabaseSeeder
```

### 2. Menjalankan Seeder Tertentu
```bash
php spark db:seed RoleSeeder
php spark db:seed KriteriaSeeder
php spark db:seed Userseeder
```

## Struktur Database

### Tabel Users
- `id` (Primary Key, Auto Increment)
- `name` (VARCHAR 100)
- `email` (VARCHAR 100, Unique)
- `password` (VARCHAR 255)
- `created_at`, `updated_at` (Timestamps)

### Tabel Role
- `id_role` (Primary Key, VARCHAR 10)
- `role` (VARCHAR 50)

### Tabel Kriteria
- `id_kriteria` (Primary Key, VARCHAR 10)
- `kriteria` (VARCHAR 100)

### Tabel Pemain
- `id_mlbb` (Primary Key, VARCHAR 20)
- `nickname` (VARCHAR 50)
- `nama` (VARCHAR 100)
- `id_role` (Foreign Key ke role)
- `rank` (VARCHAR 50, Nullable)
- `winrate` (DECIMAL 5,2, Nullable)
- `kompetisi_menang` (INT, Default 0)
- `created_at`, `updated_at` (Timestamps)

### Tabel Bobot
- `id_bobot` (Primary Key, VARCHAR 20)
- `id_role` (Foreign Key ke role)
- `id_kriteria` (Foreign Key ke kriteria)
- `skor` (INT, Nullable)
- `bobot` (DECIMAL 5,3, Nullable)
- `atribut` (ENUM: benefit/cost, Default benefit)

### Tabel Scrim
- `id_scrim` (Primary Key, Auto Increment)
- `id_mlbb` (Foreign Key ke pemain)
- `scrim_ke` (INT)
- `tanggal` (DATE)
- `durasi` (TIME, Nullable)
- `total_kill` (INT, Default 0)
- `hero_digunakan` (VARCHAR 50, Nullable)
- `jumlah_kill` (INT, Default 0)
- `jumlah_death` (INT, Default 0)
- `jumlah_assist` (INT, Default 0)
- `damage_hero` (BIGINT, Default 0)
- `damage_turret` (BIGINT, Default 0)
- `damage_diterima` (BIGINT, Default 0)
- `jumlah_gold` (BIGINT, Default 0)
- `kontrol_objektif` (INT, Default 0)
- `komunikasi` (INT, Default 0)
- `created_at`, `updated_at` (Timestamps)

### Tabel HeroPool
- `id_pool` (Primary Key, Auto Increment)
- `id_mlbb` (Foreign Key ke pemain)
- `hero` (VARCHAR 50)
- `created_at`, `updated_at` (Timestamps)

### Tabel Nilai Scrim
- `id_nilai` (Primary Key, Auto Increment)
- `id_scrim` (Foreign Key ke scrim)
- `id_kriteria` (Foreign Key ke kriteria)
- `nilai` (DECIMAL 10,2, Nullable)

## Catatan Penting

1. **Urutan Migrasi**: File migrasi sudah diberi nomor urut untuk memastikan tabel dibuat dalam urutan yang benar
2. **Foreign Key**: Semua foreign key constraint sudah diatur dengan CASCADE untuk update dan delete
3. **Data Types**: Tipe data disesuaikan dengan kebutuhan aplikasi SPK TOPSIS
4. **Seeder**: Data awal untuk role dan kriteria sudah disediakan melalui seeder

## Troubleshooting

### Error Foreign Key
Jika terjadi error foreign key, pastikan:
1. Tabel parent sudah dibuat terlebih dahulu
2. Kolom yang direferensikan memiliki tipe data yang sama
3. Jalankan migrasi sesuai urutan

### Error Duplicate Entry
Jika terjadi error duplicate saat menjalankan seeder:
```bash
php spark migrate:refresh
php spark db:seed DatabaseSeeder
```
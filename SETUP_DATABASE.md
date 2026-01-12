# Setup Database - APK Skripsi

## Langkah-langkah Setup Database:

### 1. Buat Database
Buka phpMyAdmin atau MySQL client, lalu jalankan:
```sql
CREATE DATABASE apk_skripsi;
```

### 2. Jalankan Migrasi
Buka terminal/command prompt di folder project, lalu jalankan:
```bash
php spark migrate
```

Ini akan membuat semua tabel:
- users
- role
- pemain
- heropool
- kriteria
- bobot
- scrim
- nilai_scrim

### 3. Jalankan Seeder (Data Awal)

#### Seeder User Admin:
```bash
php spark db:seed UserSeeder
```
Login: admin@example.com / admin123

#### Seeder Role (5 Role MLBB):
```bash
php spark db:seed RoleSeeder
```
Role yang dibuat:
- EXP Laner
- Gold Laner
- Mid Laner
- Jungler
- Roamer

### 4. Verifikasi
Cek di phpMyAdmin apakah semua tabel sudah ada dan terisi data.

### Troubleshooting:

**Jika migrasi error:**
```bash
php spark migrate:rollback
php spark migrate
```

**Jika ingin reset database:**
```bash
php spark migrate:refresh
php spark db:seed UserSeeder
php spark db:seed RoleSeeder
```

**Cek status migrasi:**
```bash
php spark migrate:status
```

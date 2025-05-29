# 🏗️ Task Management System (Laravel + Filament)

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Filament](https://img.shields.io/badge/Filament-4F46E5?style=for-the-badge)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)

## 🚀 Quick Start

### Prerequisites
- PHP 8.2+
- Composer 2.5+
- Sqlite viewer 

# 1. Clone and setup
- clone
setelah clone repository, copy file `.env.example` ke root project dengan nama `.env`
```bash
git clone https://github.com/your-repo/task-management.git
cd laravel-filament
cp .env.example .env
```

# 2. Install dependencies
Setelah clone dan copy env, jalankan command berikut untuk menginstall dependencies.
```bash
composer install
```

# 3. Konfigurasi Database dan Tabel
Buat file di `/laravel-filament/database` dengan nama `database.sqlite`

- Linux/MacOs/Windows (Git bash/WSL)
```bash
cd database
touch database.sqlite
```

Jalankan command berikut secara berurutan untuk inisialasi Database dan Table
```bash
php artisan key:generate
php artisan migrate:fresh
php artisan shield:generate --all
php artisan db:seed
```
Command db:seed di atas juga akan melakukan seed data super_admin ke database dengan email `admin@email.com` dan password berupa `'password'`.

Selain itu ada juga beberapa akun hasil seed dengan role yg sudah ditentukan by system secara default, yakni:

`amas_dev@email.com`

`budi_dev@email.com`

`aan_pm@email.com`

`cici_pm@email.com`

dengan password yang sama semua yakni `'password'`

# 4. Start server
Jalankan command serve berikut untuk memulai development secara lokal.
```bash
php artisan serve
```

mulai gunakan aplikasi di `http://localhost:8000/admin`

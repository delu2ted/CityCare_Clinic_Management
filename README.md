# CityCare Medical Centre — Clinic Appointment & Patient Management System

A centralized, role-based web application built with **Laravel 12** and **Bootstrap 5**, designed to replace CityCare Medical Centre's manual appointment books, spreadsheets, and WhatsApp-based coordination with a single reliable digital platform.

---

## Tech Stack

| Layer | Technology |
|---|---|
| Backend | Laravel 12 (PHP 8.2+) |
| Frontend | Bootstrap 5, Blade Templating |
| Database | MySQL |
| Authentication | Laravel Breeze (customized, role-aware) |
| PDF Export | barryvdh/laravel-dompdf |
| Excel/CSV Export | maatwebsite/excel |
| Styling | Custom "Cool Grey & Lilac" theme (`resources/css/citystyles.css`) |

---

## Setup Instructions

### 1. Clone the repository
```bash
git clone https://github.com/delu2ted/CityCare_Clinic_Management.git
cd CityCare_Clinic_Management
```

### 2. Install PHP dependencies
```bash
composer install
```

> **Note:** `maatwebsite/excel` requires the PHP `zip` and `gd` extensions. If installation fails, enable both in your `php.ini` (uncomment `extension=zip` and `extension=gd`) and restart your server.

### 3. Install JavaScript dependencies
```bash
npm install
```

### 4. Configure environment
```bash
copy .env.example .env
php artisan key:generate
```

Edit `.env` and set your database and app URL:
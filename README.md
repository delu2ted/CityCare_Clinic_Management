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
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=citycare_db
DB_USERNAME=root
DB_PASSWORD=


Create an empty `citycare_db` database (e.g. via phpMyAdmin) before continuing — Laravel does not create the database itself.

### 5. Run migrations and seed test accounts
```bash
php artisan migrate:fresh --seed
```

### 6. Build frontend assets
```bash
npm run build
```

### 7. Start the server
```bash
php artisan serve
```

Visit **http://127.0.0.1:8000**

---

## Seeded Test Accounts

| Role | Email | Password |
|---|---|---|
| Admin | admin@citycare.com | password |
| Receptionist | reception@citycare.com | password |
| Doctor | doctor@citycare.com | password |
| Cashier | cashier@citycare.com | password |
| Patient | patient@citycare.com | password |

New patients can also self-register via the public homepage's **"Book an Appointment"** button.

---

## User Roles & Access Control

Role-based access is enforced at the route level via custom middleware (`app/Http/Middleware/EnsureUserHasRole.php`), not just hidden UI elements — visiting a restricted URL directly returns a 403.

| Role | Access |
|---|---|
| **Administrator** | Full access: departments, doctors, patients, appointments, payments, reports |
| **Receptionist** | Books/updates/cancels appointments, registers patients, views doctors (read-only) |
| **Doctor** | Views own schedule, patient details for their appointments, doctor-schedule reports |
| **Cashier** | Records and manages payments, views payment reports |
| **Patient** | Views own profile, upcoming appointments, visit history, and payment status; can self-book appointments |

---

## Major Features

### 1. Public Homepage
Unauthenticated visitors see the clinic's mission, departments, doctors, location, and a contact form — before being asked to register or log in. "Book an Appointment" routes new visitors to registration first.

### 2. Authentication & Authorization
- Login, registration (with phone number, auto-linked to a `Patient` record), password reset.
- Custom `role` middleware restricting routes per role (Part C(a)(ii)).

### 3. Appointment Booking with Smart Assignment
- Patients/receptionists select a **department** first; choosing a specific doctor is optional.
- If no doctor is selected, the system automatically assigns the **least busy available doctor** in that department for the requested time.
- A **5-minute buffer** is enforced between any doctor's appointments to prevent unrealistic back-to-back bookings.
- Double-booking is prevented at the application level in `AppointmentController::store()`/`update()`.

### 4. CRUD for All Core Entities
Departments, Doctors, Patients, Appointments, and Payments all have full Create/Read/Update/Delete functionality with form validation, list + detail views, and **Bootstrap modal confirmation** on delete (via the reusable `<x-confirm-delete-modal>` component).

### 5. Search, Filtering & Pagination
Appointments, Doctors, Patients, and Payments list pages support keyword search, status/department filters, and paginated results (10 per page).

### 6. AJAX Features
- **Dynamic appointment slot loading** — the doctor dropdown filters live by selected department (`resources/js/app.js`).
- **Doctor availability check** — `GET /api/doctors/{doctor}/available-slots` returns open time slots for a given date.
- **Instant patient search** — `GET /api/patients/search` powers a live-typing search box on the Patients list.

### 7. Payments
Payments are created automatically (as `pending`) when an appointment is booked, and can be tracked/updated by Cashiers or Admin. Amounts are recorded in **UGX**.

### 8. Reporting (PDF / Excel / CSV)
Available at `/reports` to Admin, Cashier, Receptionist, and Doctor roles:
- **Appointments Report** — filterable by date range, department, status.
- **Doctor Schedule Report** — a single doctor's appointments for a chosen date.
- **Payments Report** — filterable by date range and status, with a total collected summary.
- **Patient Visit Report** — full visit + payment history for one patient.

Each report can be viewed on-screen or downloaded as **PDF**, **Excel (.xlsx)**, or **CSV**.

### 9. Reusable Blade Components
- `<x-alert type="success">` — dismissible, auto-fades after 3 seconds.
- `<x-confirm-delete-modal>` — reusable delete-confirmation modal used across all 5 modules.
- `<x-dashboard-layout>` — shared authenticated layout with role-aware sidebar navigation.
- `<x-guest-layout>` — shared layout for login/register/password pages.

### 10. Responsive Design
Built entirely with Bootstrap 5's grid and components; the sidebar dashboard and public homepage both adapt to mobile and desktop viewports.

---

## Database Design

Core tables: `users` (with `role` enum), `patients`, `doctors`, `departments`, `appointments`, `payments`, all linked via foreign keys with appropriate `onDelete` behavior. `doctors` and `patients` each `belongsTo` a `User` (1:1 for login), while `appointments` connects `patients`, `doctors`, and `departments` (many-to-one each), and `payments` `belongsTo` both `appointments` and `patients`.

See `database/migrations/` for full schema definitions.

---

## Project Structure Highlights
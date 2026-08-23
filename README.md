# CityCare Medical Centre

A clinic appointment and patient management system built with **Laravel 12** and **Bootstrap 5**. It replaces manual booking (notebooks, spreadsheets, WhatsApp) with one centralized, role-based web app.

---

## What This App Does

- Patients book appointments online — no doctor required, the system can auto-assign one
- Receptionists manage bookings without double-booking doctors
- Doctors see their schedule and patient history
- Cashiers track payments
- Admins oversee everything and pull reports

---

## Tech Stack

- **Backend:** Laravel 12, PHP 8.2+
- **Frontend:** Bootstrap 5, Blade
- **Database:** MySQL
- **Auth:** Laravel Breeze (customized)
- **Exports:** DomPDF (PDF), Maatwebsite Excel (Excel/CSV)

---

## Getting Started

### 1. Clone and enter the project
```bash
git clone https://github.com/delu2ted/CityCare_Clinic_Management.git
cd CityCare_Clinic_Management
```

### 2. Install dependencies
```bash
composer install
npm install
```

> If `composer install` fails on `maatwebsite/excel`, your PHP is missing the `zip` or `gd` extension. Open `php.ini`, uncomment `extension=zip` and `extension=gd`, then restart your server and try again.

### 3. Set up your environment file
```bash
copy .env.example .env
php artisan key:generate
```

Open `.env` and set:

APP_URL=http://127.0.0.1:8000
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=citycare_db
DB_USERNAME=root
DB_PASSWORD=



Create an empty database called `citycare_db` (e.g. in phpMyAdmin) — Laravel won't create it for you.

### 4. Build the database
```bash
php artisan migrate:fresh --seed
```

### 5. Build the frontend
```bash
npm run build
```

### 6. Run the app
```bash
php artisan serve
```

Open **http://127.0.0.1:8000**

---

## Test Accounts

| Role | Email | Password |
|---|---|---|
| Admin | admin@citycare.com | password |
| Receptionist | reception@citycare.com | password |
| Doctor | doctor@citycare.com | password |
| Cashier | cashier@citycare.com | password |
| Patient | patient@citycare.com | password |

New patients can also register themselves from the homepage.

---

## Who Can Do What

| Role | Can access |
|---|---|
| Admin | Everything — departments, doctors, patients, appointments, payments, reports |
| Receptionist | Book/edit/cancel appointments, register patients, view doctors |
| Doctor | Own schedule, own patients' info, doctor-schedule reports |
| Cashier | Payments, payment reports |
| Patient | Own profile, own appointments, own payment status, self-booking |

Access is enforced with a custom `role` middleware — visiting a page you're not allowed to see returns a 403, not just a hidden menu link.

---

## Main Features

**Public homepage** — visitors see the clinic's mission, departments, and doctors before logging in, with a contact form and a "Book Appointment" button that leads to registration.

**Smart appointment booking** — pick a department; picking a doctor is optional. If you skip it, the system assigns whichever doctor in that department is least busy that day. A 5-minute gap is always kept between a doctor's appointments so bookings never overlap.

**Full CRUD everywhere** — Departments, Doctors, Patients, Appointments, and Payments all support create, view, edit, and delete, each with form validation and a proper confirmation modal before deleting.

**Search, filters, pagination** — on the Appointments, Doctors, Patients, and Payments lists.

**Live AJAX features:**
- Available time slots load dynamically based on doctor + date
- Patient list has instant search-as-you-type
- Doctor availability is checked in real time when booking

**Payments** — created automatically when an appointment is booked (starts as "pending"), tracked in UGX, managed by Cashiers.

**Reports** — at `/reports`, generate Appointments, Doctor Schedule, Payments, or Patient Visit reports, viewable on-screen or downloadable as PDF, Excel, or CSV.

**Reusable components** — a shared alert banner, delete-confirmation modal, and dashboard/guest layouts used consistently across the app.

---

## Screenshots

**Public Homepage**
![Homepage](docs/screenshots/homepage.png)

**Admin Dashboard**
![Admin Dashboard](docs/screenshots/admin-dashboard.png)

**Booking an Appointment**
![Book Appointment](docs/screenshots/book-appointment.png)

**PDF Report Export**
![PDF Report](docs/screenshots/report-pdf.png)

**Delete Confirmation**
![Delete Modal](docs/screenshots/delete-modal.png)

---

## Notes

- Card/Mobile Money/Insurance payment fields on the booking form are placeholders for UI completeness — no real payment processing happens.
- The contact form logs messages to `storage/logs/laravel.log` instead of sending real email, since no SMTP is configured.
- Marking a "no-show" is a manual action by Receptionist/Admin, not automatic — a missed appointment could mean many things, so a person decides.

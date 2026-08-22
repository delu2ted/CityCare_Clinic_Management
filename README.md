# CityCare Clinic Management System

A centralized digital platform built with **Laravel 11** and **Bootstrap 5** to streamline patient appointments, medical staff schedules, treatment records, and billing for CityCare Medical Centre.

## 🚀 Project Overview
This system replaces manual record-keeping (notebooks, spreadsheets, WhatsApp) with a secure, role-based web application. It solves critical issues like double-booking, lost patient records, and lack of real-time reporting.

## 🛠️ Tech Stack
- **Backend:** Laravel 11 (PHP 8.2+)
- **Frontend:** Bootstrap 5, Blade Templating
- **Database:** MySQL (Port 3307)
- **Authentication:** Laravel Breeze
- **Styling:** Custom Cool Grey & Lilac Theme

## 👥 User Roles & Access Control
The system implements **Role-Based Access Control (RBAC)** to ensure users only see relevant features:
1.  **Administrator:** Manages users, departments, doctors, and views global reports.
2.  **Receptionist:** Books, updates, and cancels appointments. Ensures no double-booking.
3.  **Doctor:** Views schedule, accesses patient history, and adds consultation notes.
4.  **Cashier:** Records payments and tracks billing status.
5.  **Patient:** Views profile, upcoming appointments, visit history, and payment status.

## ✨ Major Features

### 1. Secure Authentication & Authorization
- Implemented using **Laravel Breeze**.
- Secure login, registration, and password management.
- Middleware-based role checking to restrict access to specific pages (e.g., only Admins can delete users).

### 2. Department Management (CRUD)
- Full **Create, Read, Update, Delete** functionality for medical departments.
- Includes **search**, **filtering**, and **pagination** for efficient data management.
- Responsive table layout with Bootstrap.

### 3. Appointment Booking System
- **Real-time Availability:** (If implemented) Dynamic loading of available time slots via AJAX.
- **Double-Booking Prevention:** Database-level unique constraints ensure a doctor cannot be booked for two patients at the same time.
- **Status Tracking:** Appointments can be marked as `Scheduled`, `Completed`, `Cancelled`, or `No-Show`.

### 4. Patient & Doctor Profiles
- **Linked Data:** Doctors and Patients are linked to User accounts for seamless authentication.
- **Medical History:** Patients can store emergency contacts, blood group, and medical history.
- **Doctor Specialization:** Doctors are categorized by department and specialization.

### 5. Payment Tracking
- Cashiers can record payments linked to specific appointments.
- Tracks payment status: `Pending`, `Paid`, `Partially Paid`, `Refunded`.
- Supports multiple payment methods (Cash, Card, Insurance).

### 6. Reporting & Analytics
- **Search & Filter:** Global search across patients, doctors, and appointments.
- **Pagination:** Handles large datasets efficiently (10 records per page).
- *(Optional)* **PDF/Excel Export:** (If you implement the reporting package later).

## 📂 Project Structure
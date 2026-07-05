# Hospital Management System — Secure Software Engineering Case Study

Repository for the **Secure Software Engineering** exam project, academic year **2025–2026**.

This project contains the security and privacy analysis, remediation work, and final delivery material for a PHP/MySQL **Hospital Management System (HMS)** web application.

## Authors

- **Leonardo Moro** — Matricola: 869146
- **Domenico Scalise** — Matricola: 865702

Course: **Secure Software Engineering**  
University: **Università degli Studi di Bari Aldo Moro**

---

## Project Overview

The objective of this project is to evaluate and improve the security and privacy posture of an existing Hospital Management System.

The HMS is a web application developed with a **PHP backend** and a **MySQL database**, intended to run in a local **XAMPP** environment.

The system supports three main user roles:

- **Patients**, who can register, log in, book appointments, access prescriptions, and view personal information.
- **Doctors**, who can manage appointments, schedules, prescriptions, and patient-related workflows.
- **Administrators**, who can manage users, doctors, appointments, messages, and system-level data.

Since the application handles personal and healthcare-related information, the project focuses on both:

- **Secure Software Engineering**
- **Privacy-by-Design**

The work follows a Secure Software Development Lifecycle approach, combining static analysis, dynamic analysis, manual validation, remediation, and privacy-oriented architectural improvement.

---

## Repository Structure

```text
Moro_Scalise-Case-Study-Delivery---HMS-Hospital-Managemement-System/
│
├── Hospital-Management-System/
│   ├── PHP/MySQL application source code
│   ├── myhmsdb.sql
│   ├── TCPDF/
│   └── _scan_excluded/
│
├── docs/
│   ├── HMS_Case_Study_Moro_Scalise.pdf
│   └── Progetto_Moro_Scalise.md
│
├── README.md
└── .gitignore
```

---

## Runtime Project Folder

The application to execute is contained in:

```text
Hospital-Management-System/
```

This is the folder that must be copied under the XAMPP `htdocs/` directory for local execution.

---

## Documentation Folder

The project documentation delivered with the repository is contained in:

```text
docs/
```

Current documentation files:

- `docs/HMS_Case_Study_Moro_Scalise.pdf`
- `docs/Progetto_Moro_Scalise.md`

---

## Database Setup

The database dump included in the repository is:

```text
Hospital-Management-System/myhmsdb.sql
```

The application is configured to use the database name:

```text
myhmsdb
```

Before running the project, create the database in phpMyAdmin (or MySQL) and import the provided SQL dump.

---

## Execution Steps

1. Install and start **XAMPP**.
2. Copy the folder `Hospital-Management-System/` into your XAMPP `htdocs/` directory.
3. Create a MySQL database named **`myhmsdb`**.
4. Import `Hospital-Management-System/myhmsdb.sql` into that database.
5. Open the application in the browser through the local XAMPP path.

Example:

```text
http://localhost/Hospital-Management-System/
```

---

## Delivery Notes

- The folder `_scan_excluded/` is intentionally preserved **for traceability** of the remediation and scan-scope reduction process discussed in the documentation.
- The folder `TCPDF/` is retained because the application still uses `tcpdf.php` for PDF/bill generation.
- Some legacy files such as `error.php`, `error1.php`, and `error2.php` are preserved in the repository for completeness and compatibility, even if the remediated flows rely less on them.

---

## Final Scope of the Delivered Repository

This repository is intended to deliver:

1. the **remediated web application**;
2. the **database dump** needed to run it locally;
3. the **case study documentation** used for the exam;
4. traceable evidence of the applied security hardening and remediation choices.

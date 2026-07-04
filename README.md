# Hospital Management System — Secure Software Engineering Case Study

Repository for the **Secure Software Engineering** exam project, academic year **2025–2026**.

This project presents the security and privacy analysis, remediation, and documentation of a PHP/MySQL **Hospital Management System (HMS)** web application.

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
Moro_Scalise-Case-Study-Delivery---HMS-Hospital-Managemement-System-/
│
├── Hospital-Management-System/
│   └── PHP/MySQL application source code
│
├── docs/
│   ├── MoroScalise_CaseStudy_SSE_2026.pdf
│   └── HMS_Case_Study_Moro_Scalise.pptx
│
├── README.md
└── .gitignore

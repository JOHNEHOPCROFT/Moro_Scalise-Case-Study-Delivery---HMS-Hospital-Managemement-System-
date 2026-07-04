# Hospital Management System — Secure Software Engineering Case Study

Repository for the **Secure Software Engineering** exam project, academic year **2025–2026**.

This project is based on the analysis, exploitation, remediation, and privacy-oriented redesign of a PHP/MySQL **Hospital Management System (HMS)**.

## Authors

- **Leonardo Moro** — Matricola: 869146
- **Domenico Scalise** — Matricola: 865702

Course: **Secure Software Engineering**  
University: **Università degli Studi di Bari Aldo Moro**

---

## Project Overview

The objective of this project is to evaluate and improve the security and privacy posture of an existing Hospital Management System web application.

The original application is a traditional PHP/MySQL system designed to support hospital workflows involving three main user roles:

- **Patients**, who can manage personal records, book appointments, and access prescriptions.
- **Doctors**, who can manage schedules, appointments, and clinical requests.
- **Administrators**, who can manage users, doctors, appointments, and system-level information.

Because the application handles personal and healthcare-related data, the project focuses on both **security engineering** and **privacy-by-design** principles.

The case study follows a Secure Software Development Lifecycle approach, combining:

- Red Teaming
- Passive and active reconnaissance
- Static Application Security Testing
- Dynamic Application Security Testing
- Manual vulnerability validation
- Security remediation
- Privacy assessment
- Privacy-by-design architectural improvement

---

## Technology Stack

The application uses the following technologies:

- **PHP**
- **MySQL**
- **Apache**
- **XAMPP**
- **Bootstrap**
- **jQuery**
- **Font Awesome**
- **TCPDF**

The application is intended to run locally in a XAMPP environment.

---

## Repository Structure

```text
Hospital-Management-System-SSE/
│
├── src/
│   └── Application source code
│
├── database/
│   └── MySQL database dump or schema file
│
├── docs/
│   ├── Final case study report
│   └── Final project presentation
│
├── evidence/
│   ├── sast/
│   │   └── Static analysis evidence
│   ├── dast/
│   │   └── Dynamic analysis evidence
│   └── manual-tests/
│       └── Manual validation and regression testing evidence
│
├── README.md
├── .gitignore
└── LICENSE

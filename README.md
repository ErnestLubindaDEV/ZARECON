# ZARECON 2026 – Zambia Annual Renewable Energy Conference

Official website for **ZARECON 2026**, the premier renewable energy conference in Zambia, organized by the **Zambia Renewable Energy Association (ZARENA)**.

**Theme:** Powering Sustainable Development: Innovation, Investment, and Implementation

**Conference dates:** 10 – 13 March 2026  
**Location:** InterContinental Hotel Lusaka, Zambia

## Table of Contents

- [Overview](#overview)
- [Features](#features)
- [Tech Stack](#tech-stack)
- [Installation & Setup](#installation--setup)
- [Project Structure](#project-structure)
- [Database Setup](#database-setup)
- [Usage](#usage)
- [Contributing](#contributing)
- [License](#license)
- [Contact](#contact)

## Overview

This is the official website for **ZARECON 2026**, built to provide information about the conference, allow paper/abstract submissions, facilitate registration, and showcase speakers, sponsors, and partners.

The site supports:
- User registration & login
- Paper/abstract submission with file upload
- Contact form
- Responsive design for desktop & mobile

## Features

- Modern, responsive design (Bootstrap + custom CSS)
- User registration with password hashing
- Login system with session management
- Paper submission form with file upload (PDF/DOC/DOCX)
- Dynamic track selection + option to add custom tracks
- Contact page with Google Maps embed
- Consistent navigation across inner pages
- Clean footer with social links and quick navigation

## Project Structure

ZARECON/
├── css/                  # Main CSS files
├── css1/                 # Alternative/legacy CSS
├── img/                  # Images, logo, hero backgrounds
├── js/                   # JavaScript files
├── js1/                  # Alternative JS files
├── uploads/              # Uploaded abstracts/papers
├── Resources/            # PDFs and documents
├── about.html            # About page
├── contact.html          # Contact page
├── index.html            # Home page
├── login.php             # User login
├── registration.php      # User registration
├── paper-registration.php # Paper/abstract submission form
├── zarecon.sql           # Database schema and data
└── README.md             # This file

## Tech Stack

- **Frontend**: HTML5, CSS3, Bootstrap 4/5, Font Awesome, Remixicon
- **Backend**: PHP (Vanilla – no framework)
- **Database**: MySQL (via phpMyAdmin / XAMPP)
- **File uploads**: Native PHP `move_uploaded_file`
- **Password security**: `password_hash()` + `password_verify()`
- **Local development**: XAMPP (Apache + MySQL + PHP 8.1+)

## Installation & Setup

### Prerequisites
- XAMPP (or any PHP + MySQL environment)
- Git (for cloning)

### Steps

1. **Clone the repository**
   ```bash
   git clone https://github.com/ErnestLubindaDEV/ZARECON.git

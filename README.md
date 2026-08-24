# Real-Time Transportation Ticketing Platform

A web-based transportation reservation and ticketing platform built with **PHP, JavaScript and MySQL**.

The platform provides a client-facing interface for browsing and making reservations, together with a dedicated administrative interface for managing the system.

## Features

* Transportation reservation and ticketing functionality
* Client-facing web interface
* Administrative dashboard
* Seat availability verification
* Reservation management
* MySQL database integration
* Email functionality
* Server-side PHP processing
* JavaScript-based frontend functionality

## Technologies

* **PHP**
* **JavaScript**
* **MySQL**
* **HTML**
* **CSS**
* **XAMPP / Apache**

## Project Structure

```text
├── admin/              # Administrative interface
├── img/                # Images and project assets
├── js/                 # JavaScript files
├── *.php               # Application pages and backend functionality
└── local_db.sql        # Database structure and data
```

## Running Locally

### Requirements

* XAMPP
* Apache
* MySQL
* A web browser

### Setup

1. Install and start **Apache** and **MySQL** from the XAMPP Control Panel.
2. Place the project inside:

```text
C:\xampp\htdocs\project_name
```

3. Open **phpMyAdmin**:

```text
http://localhost/phpmyadmin
```

4. Import `local_db.sql` into MySQL.
5. Open the client interface:

```text
http://localhost/project_name/
```

6. The administrative interface is available at:

```text
http://localhost/project_name/admin/
```

## Purpose

This project was developed as a practical web application combining frontend development, PHP backend logic and relational database management to implement a transportation reservation workflow.

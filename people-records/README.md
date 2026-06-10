# Fit Life Gym Membership Management System

A lightweight, full-stack web application built to streamline gym member registrations and administrative record-keeping. This project demonstrates core web development concepts, secure state management, and basic database security.

## 🚀 Features
* **User Authentication:** Restricts dashboard access to authorized administrators using PHP native session variables.
* **Full CRUD Operations:** Enables creation, retrieval, updating, and removal of member profiles in real-time.
* **Soft-Delete Architecture:** Implements a multi-tier data safety mechanism using `deleted_at` timestamps, moving records to a "Trash" view for recovery or permanent removal instead of direct deletion.
* **Input Sanitization:** Safeguards the database against SQL injection vectors by enforcing `mysqli_real_escape_string` and data validation protocols.
* **Responsive UI:** Built with a fluid, mobile-friendly interface powered by Bootstrap 5 layout components.

## 🛠️ Tech Stack
* **Frontend:** HTML5, CSS3, Bootstrap 5
* **Backend:** PHP
* **Database:** MySQL
* **Server Environment:** Apache (XAMPP)

## 🔧 Setup & Installation
1. Clone this repository into your local server directory (e.g., `xampp/htdocs/`).
2. Import the database structure into your local MySQL server (Database name: `people_records`, Table name: `individuals`).
3. Configure your local database connection variables in `index.php`.
4. Access the application via your browser at `http://localhost/your-repo-name/login.php`.
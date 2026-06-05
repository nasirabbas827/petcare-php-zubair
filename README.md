# petcare_php_final_zubair  

A simple PHP‑based web application for managing a pet shop. It provides separate interfaces for **admins**, **buyers**, and **doctors**, allowing them to handle pets, orders, appointments, feedback, and user accounts.

---  

## Overview  

The project demonstrates a full‑stack CRUD system built with vanilla PHP and MySQL. Core functionalities include:

* Pet catalog management (add, edit, view, delete)  
* Order processing and status tracking  
* Appointment scheduling for buyers and doctors  
* Feedback collection and admin review  
* User authentication (admin, buyer, doctor)  

All pages are organized under an `admin/` folder for the admin panel, while the public‑facing side contains the buyer and doctor dashboards.

---  

## Features  

| Area | Feature |
|------|---------|
| **Admin** | Login, manage users, view/edit pets, view orders, update order status, view appointments, view feedback, logout |
| **Buyer** | Register / login, browse pets, purchase pets, view order history, schedule appointments, give feedback |
| **Doctor** | Login, view scheduled appointments, update appointment status |
| **General** | Central navigation bar, session handling, basic input validation, SQL dump for quick DB setup |

---  

## Tech Stack  

| Layer | Technology |
|-------|------------|
| **Backend** | PHP 7.x / 8.x |
| **Database** | MySQL (schema in `Database/pet_db.sql`) |
| **Frontend** | HTML5, CSS3 (Bootstrap optional), minimal JavaScript |
| **Server** | Apache / Nginx (any server with PHP support) |
| **Version Control** | Git (GitHub) |

---  

## Installation  

1. **Clone the repository**  

   ```bash
   git clone https://github.com/your-username/petcare_php_final_zubair.git
   cd petcare_php_final_zubair
   ```

2. **Create a MySQL database**  

   ```sql
   CREATE DATABASE petcare;
   ```

3. **Import the schema**  

   ```bash
   mysql -u your_user -p petcare < Database/pet_db.sql
   ```

4. **Configure database connection**  

   Open `config.php` (and `admin/config.php` if you prefer a separate admin config) and set your credentials:

   ```php
   define('DB_HOST', 'localhost');
   define('DB_NAME', 'petcare');
   define('DB_USER', 'YOUR_DB_USER');
   define('DB_PASS', 'YOUR_DB_PASSWORD');
   ```

5. **Set up a web server**  

   * Place the project folder inside your web root (e.g., `htdocs` or `www`).  
   * Ensure the server points to `index.php` as the default document.  

6. **Adjust file permissions** (if required)

   ```bash
   chmod -R 755 .
   ```

7. **Optional – Composer**  

   The project does not rely on external packages, but you can run `composer install` if you add dependencies later.

---  

## Usage  

### Running locally  

1. Open a browser and navigate to:  

   ```
   http://localhost/petcare_php_final_zubair/
   ```

2. **Admin panel** – go to `admin/admin_login.php` and log in with the credentials you inserted into the `users` table (role = `admin`).  

3. **Buyer flow** – register via `register.php`, then browse pets (`index.php`), purchase with `buy_pet.php`, and view orders on `buyer_orders.php`.  

4. **Doctor flow** – log in via `doctor
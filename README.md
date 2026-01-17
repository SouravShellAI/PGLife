# PGLife - Full Stack PG Finding Web Application

## Introduction
**PGLife** is a responsive Full Stack web application designed to simplify the process of finding Paying Guest (PG) accommodations in major Indian cities. It serves as a bridge between PG owners and potential tenants, offering a seamless user experience from search to booking.

This project was built to solve the real-world problem of unorganized hostel/PG searching by providing a clean, filterable, and image-rich interface.

## Key Features
* **Dynamic Search:** Users can browse PGs by city (Delhi, Mumbai, Bangalore, Hyderabad).
* **Authentication System:** Secure Signup and Login with **Password Hashing (Bcrypt)** and Session Management.
* **Smart Dashboard:** A personalized user dashboard displaying profile details, booking history, and interested properties.
* **Property Details:** Detailed views including amenities, rent, gender restrictions, and testimonials.
* **Booking System:** Users can book properties directly through the platform.
* **Cancellation System:** Users can cancel bookings with specific reasons, which are archived for analytics.
* **Interactive UI:** Features a "Like/Interest" system that updates in real-time using **AJAX** without page reloads.

## Technical Stack
* **Frontend:** HTML5, CSS3, JavaScript, Bootstrap 4 (Responsive Design).
* **Backend:** Core PHP (Procedural).
* **Database:** MySQL (Relational Database with Foreign Key constraints).
* **AJAX:** Used for asynchronous updates (Bookings, Likes) to enhance User Experience.

## Database Architecture
The application uses a normalized Relational Database (SQL) to ensure data integrity:
* **Users:** Stores secure user credentials.
* **Properties:** Linked to Cities.
* **Amenities:** Linked to Properties via a bridge table (`property_amenities`) to allow many-to-many relationships.
* **Bookings & Cancellations:** Tracks user activity and history.

## How to Run Locally

### Prerequisites
* XAMPP (or WAMP/MAMP) installed.
* A browser (Chrome/Edge/Firefox).

### Installation Steps
1.  **Clone the Repository:**
    ```bash
    git clone [https://github.com/your-username/PGLife.git](https://github.com/your-username/PGLife.git)
    ```
2.  **Move Folder:**
    Move the `PGLife` folder to your XAMPP `htdocs` directory (usually `C:\xampp\htdocs\`).
3.  **Import Database:**
    * Open phpMyAdmin (`http://localhost/phpmyadmin`).
    * Create a new database named **`pg_life`**.
    * Click "Import" and select the `database/pg_life.sql` file from this project.
4.  **Configure Connection:**
    * Open `includes/database_connect.php`.
    * Ensure the username (default: `root`) and password (default: empty) match your XAMPP settings.
5.  **Run:**
    * Start Apache and MySQL in XAMPP.
    * Open `http://localhost/PGLife/index.php` in your browser.

## Challenges & Learnings
* **Database Normalization:** Learned how to efficiently structure `properties` and `amenities` to avoid data redundancy.
* **Security:** Implemented `htmlspecialchars` to prevent XSS attacks and Prepared Statements to prevent SQL Injection.
* **State Management:** Managed user sessions across pages (Dashboard vs Home) to control access to protected routes.

## Future Improvements
* Add an Admin Panel for PG owners to upload property details.
* Integrate a Payment Gateway for advance booking fees.
* Add a map view using Google Maps API.

---
*Developed by Sourav Mondal*

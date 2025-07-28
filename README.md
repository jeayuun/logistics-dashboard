<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<h1 align="center">AI-Powered Proximity Alerts</h1>

This project is a web application that provides proximity alerts for warehouse deliveries. It uses a Laravel frontend to interact with a Python/Flask microservice that performs the geospatial calculations.

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Features

* **Proximity Check**: A form to input delivery coordinates and check their distance from a fixed warehouse location.
* **Interactive Map**: Displays the warehouse, delivery location, and alert radius on an interactive Leaflet.js map.
* **Alert Logging**: Every proximity check is logged to a MySQL database for historical records.

---

## Installation & Setup

You need to set up both the frontend (Laravel) and the backend (Flask) components.

### **1. Backend Setup (Flask API)**

This microservice handles the distance calculations.

1.  **Navigate to the backend directory:**
    ```bash
    cd flask_proximity_alert
    ```

2.  **Create and activate a Python virtual environment:**
    ```bash
    # Create the environment
    python -m venv venv

    # Activate on Windows
    venv\Scripts\activate

    # Activate on macOS/Linux
    source venv/bin/activate
    ```

3.  **Install Python dependencies:**
    ```bash
    pip install Flask flask-cors geopy
    ```

### **2. Frontend Setup (Laravel App)**

This is the main web interface.

1.  **Navigate to the frontend directory:**
    ```bash
    cd logistics-dashboard
    ```

2.  **Install PHP dependencies:**
    ```bash
    composer install
    ```

3.  **Create your environment file:**
    ```bash
    cp .env.example .env
    ```

4.  **Generate an application key:**
    ```bash
    php artisan key:generate
    ```

5.  **Configure your database in `.env`:**
    Open the `.env` file and ensure your `DB_` variables are correct for your local environment (e.g., Laragon).
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=logistics-dashboard
    DB_USERNAME=root
    DB_PASSWORD=
    ```

6.  **Run database migrations:**
    This command will create the `alert_logs` table in your database.
    ```bash
    php artisan migrate
    ```

---

## How to Run the Application 🚀

You need two separate terminals running at the same time.

1.  **Start the Backend API:**
    In your first terminal, navigate to the `flask_proximity_alert` directory, activate the environment, and run the server.
    ```bash
    python app.py
    ```
    *This will serve the API at `http://127.0.0.1:5000`. Leave this terminal running.*

2.  **Start the Frontend Services:**
    Launch Laragon and click the **"Start All"** button to run your web server and database.

3.  **Access the Application:**
    Open your web browser and go to:
    **`http://logistics-dashboard.test/proximity-form`**

---

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
# DFM-hospital-Inventory-Management-System

## Overview

DFM Hospital Inventory Management System is a Laravel web application for managing the medical supplies, medicines, and other stock used by a hospital. It provides a central place for authorized staff to record inventory, monitor stock levels, and keep supply information accurate and up to date.

The application helps replace manual stock tracking with a searchable, organized workflow. Staff can use it to understand what is available, identify items that need replenishment, and maintain a history of inventory activity.

## Main functions

- **Inventory management** – Add, view, update, and remove inventory records.
- **Item organization** – Maintain item details such as names, categories, quantities, and other relevant information.
- **Stock monitoring** – Review current quantities and quickly identify low or unavailable stock.
- **Inventory transactions** – Record stock received, issued, or adjusted so quantity changes can be tracked.
- **Search and filtering** – Find supplies efficiently instead of searching through paper records or spreadsheets.
- **Dashboard and summaries** – View useful inventory information at a glance.
- **User access** – Restrict management functions to authenticated and authorized users.

## Benefits

This system supports hospital staff by improving stock visibility, reducing data-entry errors, helping prevent stockouts, and making routine inventory administration faster. It can also provide a clearer record of how supplies move through the organization.

## Technology

- [Laravel](https://laravel.com/) PHP framework
- PHP
- Database supported by Laravel
- Blade templates and web-based UI

## Installation

1. Clone the repository and open the project directory.
2. Install PHP dependencies:

	```bash
	composer install
	```

3. Create the environment file and configure the database in `.env`:

	```bash
	cp .env.example .env
	php artisan key:generate
	```

4. Create the database tables:

	```bash
	php artisan migrate
	```

5. Start the development server:

	```bash
	php artisan serve
	```

Open the URL shown by Artisan in a web browser and sign in with an application user.

## Security

Do not commit `.env` files, passwords, database credentials, or other private configuration values. Use the application's authentication and authorization controls when managing inventory data.

## License

This project uses the license specified by the project owner. Laravel is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).

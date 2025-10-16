# Laravel - Multi-Vendor Assignment

A multi-vendor e-commerce system built with Laravel 12, supporting admin, vendors, and customers.

---

## Setup Instructions

1. **Clone the repository**
```bash
git clone https://github.com/yogi010591/laravel-multivendor-assignment.git
cd laravel-multivendor-assignment
Install dependencies

composer install
npm install
npm run build


Configure environment

cp .env.example .env
php artisan key:generate


Update your database credentials in .env.

Run migrations and seeders

php artisan migrate --seed


Start the development server

php artisan serve


Visit http://127.0.0.1:8000

Sample Credentials
Admin

Email: admin@example.com

Password: password

Vendors

Vendor 1: vendor1@example.com / password

Vendor 2: vendor2@example.com / password

Customers

Customer 1: customer1@example.com / password

Customer 2: customer2@example.com / password

Seeders Included

UserSeeder.php – creates admin, vendors, and customers

VendorSeeder.php – creates sample vendors

ProductSeeder.php – creates sample products linked to vendors

Architecture Notes

MVC Structure: Default Laravel with Models, Views, Controllers.

Roles & Access:

admin → full access

vendor → manage own products, view own orders

customer → browse products, add to cart, checkout

Multi-vendor Logic:

Orders are split per vendor during checkout

Payments linked to individual orders

Stock is deducted immediately after checkout

Database Design:

users table with role column (admin/vendor/customer)

Separate tables for products, carts, orders, order_items, payments

Trade-offs / Assumptions:

Simple role-based access instead of full ACL

Payments are mocked as “paid” for simplicity

Vendor commissions or advanced reporting not implemented

Stock reservation is not handled (immediate deduction)

Notes

.env file is excluded from GitHub for security.

Run composer install and npm install after cloning.

Tested on Laravel 12 with PHP 8.2.

CRLF/LF line endings handled via .gitattributes for Windows compatibility.

Contact

For any issues, contact Yogesh Sankpal

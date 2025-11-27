# PopArt Listings

## Tech Stack

- **Backend:** Laravel 11
- **Frontend:** Vue 3 (Composition API) + Inertia.js
- **Styling:** Tailwind CSS
- **Database:** MySQL / SQLite
- **Build Tool:** Vite

## App Demo
- App is deployed on ec2 micro instance. You can check it out [here](http://ec2-63-181-83-110.eu-central-1.compute.amazonaws.com)

## Requirements

- PHP 8.2+
- Composer
- Node.js 18+ & NPM
- MySQL 8.0+ (or SQLite for local development)

## Installation

### 1. Clone the Repository

```bash
git clone git@github.com:bukela/popart.git
cd popart
```

### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install JavaScript dependencies
npm install
```

### 3. Environment Setup

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Configure Database

Edit `.env` file and set your database credentials like example below:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=popart
DB_USERNAME=root
DB_PASSWORD=your_password
```

For SQLite (local development):
```env
DB_CONNECTION=sqlite
```

### 5. Run Migrations & Seeders

```bash
# Create database tables and seed with sample data
php artisan migrate:fresh --seed
```

This will create:
- Sample categories
- Admin user: `admin@example.com` / `password`
- Regular user: `customer@example.com` / `password`
- Sample listings

### 6. Build Frontend Assets

```bash

# Production build
npm run build
```

### 7. Storage Link

```bash
# Create symbolic link for file uploads
php artisan storage:link
```

### 8. Start Development Server

```bash
php artisan serve
```

### Running Tests

```bash
php artisan test
```

Visit: `http://localhost:8000`

## Default Credentials

**Admin Account:**
- Email: `admin@example.com`
- Password: `password`

**Regular User:**
- Email: `customer@example.com`
- Password: `password`


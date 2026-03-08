# Herbal Aid

Laravel 11 application for herbal medicine management.

## Quick Start

Start the application:
```bash
sail up -d
```

Stop the application:
```bash
sail down
```

## URLs

- **Main Application**: http://127.0.0.1:8000/dashboard
- **phpMyAdmin**: http://localhost:8080 (username: `sail`, password: `password`)
- **Test Pages**: http://127.0.0.1:8000/test

## Database

### Run Migrations
```bash
sail artisan migrate
```

### Check Migration Status
```bash
sail artisan migrate:status
```

### Direct Database Access
```bash
docker exec herbal-aid-mysql-1 mysql -usail -ppassword herbal-aid -e "SELECT * FROM roles;"
```

## Project Structure

- `public/test/` - Simple HTML/CSS test pages
- `database/migrations/` - Database schema migrations
- `.env` - Environment configuration

## Database Roles

Current roles in the system:
- Admin (ID: 1)
- Guest (ID: 2)

## create new migration
sail artisan make:migration create_items_table

#!/bin/bash

##############################################################################
# Database Setup Helper Script
##############################################################################

echo "================================"
echo "VoIP Panel Database Setup"
echo "================================"
echo ""

# Check if running as root
if [ "$EUID" -eq 0 ]; then 
    echo "Please do NOT run as root. Run as your regular user."
    exit 1
fi

# Set database credentials
DB_NAME="voip_panel"
DB_USER="voipuser"

echo "This script will:"
echo "1. Create MySQL database: $DB_NAME"
echo "2. Create MySQL user: $DB_USER"
echo "3. Run Laravel migrations"
echo ""

read -p "Do you want to continue? (y/n) " -n 1 -r
echo
if [[ ! $REPLY =~ ^[Yy]$ ]]; then
    exit 1
fi

read -sp "Enter MySQL root password: " MYSQL_ROOT_PASS
echo ""

read -sp "Enter new password for database user '$DB_USER': " DB_PASS
echo ""

read -sp "Confirm password: " DB_PASS_CONFIRM
echo ""

if [ "$DB_PASS" != "$DB_PASS_CONFIRM" ]; then
    echo "Passwords do not match!"
    exit 1
fi

# Create database and user
echo ""
echo "Creating database and user..."

mysql -u root -p"$MYSQL_ROOT_PASS" <<MYSQL_SCRIPT
CREATE DATABASE IF NOT EXISTS $DB_NAME CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER IF NOT EXISTS '$DB_USER'@'localhost' IDENTIFIED BY '$DB_PASS';
GRANT ALL PRIVILEGES ON $DB_NAME.* TO '$DB_USER'@'localhost';
FLUSH PRIVILEGES;
MYSQL_SCRIPT

if [ $? -eq 0 ]; then
    echo "✓ Database and user created successfully"
else
    echo "✗ Failed to create database"
    exit 1
fi

# Update .env file
echo ""
echo "Updating .env file..."

if [ -f .env ]; then
    sed -i "s/DB_DATABASE=.*/DB_DATABASE=$DB_NAME/" .env
    sed -i "s/DB_USERNAME=.*/DB_USERNAME=$DB_USER/" .env
    sed -i "s/DB_PASSWORD=.*/DB_PASSWORD=$DB_PASS/" .env
    echo "✓ .env file updated"
else
    echo "✗ .env file not found. Please create it from .env.example"
    exit 1
fi

# Run migrations
echo ""
echo "Running database migrations..."
php artisan migrate

if [ $? -eq 0 ]; then
    echo ""
    echo "================================"
    echo "✓ Database setup completed!"
    echo "================================"
    echo ""
    echo "Database details:"
    echo "  Name: $DB_NAME"
    echo "  User: $DB_USER"
    echo "  Host: localhost"
    echo ""
    echo "You can now create an admin user:"
    echo "  php artisan tinker"
    echo ""
else
    echo "✗ Migration failed"
    exit 1
fi

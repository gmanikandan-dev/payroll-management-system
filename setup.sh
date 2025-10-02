#!/bin/bash

# Payroll Management System Setup Script
# This script automates the setup process for the Laravel payroll system

echo "🚀 Setting up Payroll Management System..."
echo "=========================================="

# Check if PHP is installed
if ! command -v php &> /dev/null; then
    echo "❌ PHP is not installed. Please install PHP 8.2 or higher."
    exit 1
fi

# Check if Composer is installed
if ! command -v composer &> /dev/null; then
    echo "❌ Composer is not installed. Please install Composer."
    exit 1
fi

# Check if Node.js is installed
if ! command -v node &> /dev/null; then
    echo "❌ Node.js is not installed. Please install Node.js 18.x or higher."
    exit 1
fi

# Check if NPM is installed
if ! command -v npm &> /dev/null; then
    echo "❌ NPM is not installed. Please install NPM."
    exit 1
fi

echo "✅ All required tools are installed!"
echo ""

# Install PHP dependencies
echo "📦 Installing PHP dependencies..."
composer install
if [ $? -ne 0 ]; then
    echo "❌ Failed to install PHP dependencies"
    exit 1
fi
echo "✅ PHP dependencies installed successfully!"
echo ""

# Install Node.js dependencies
echo "📦 Installing Node.js dependencies..."
npm install
if [ $? -ne 0 ]; then
    echo "❌ Failed to install Node.js dependencies"
    exit 1
fi
echo "✅ Node.js dependencies installed successfully!"
echo ""

# Copy environment file
echo "⚙️  Setting up environment configuration..."
if [ ! -f .env ]; then
    cp .env.example .env
    echo "✅ Environment file created from .env.example"
else
    echo "⚠️  .env file already exists, skipping..."
fi
echo ""

# Generate application key
echo "🔑 Generating application key..."
php artisan key:generate
echo "✅ Application key generated!"
echo ""

# Database setup
echo "🗄️  Database setup..."
echo "Please make sure you have:"
echo "1. MySQL server running"
echo "2. Created a database named 'payroll_system'"
echo "3. Updated .env file with correct database credentials"
echo ""
read -p "Have you completed the database setup? (y/n): " -n 1 -r
echo
if [[ ! $REPLY =~ ^[Yy]$ ]]; then
    echo "Please complete the database setup and run this script again."
    exit 1
fi

# Run migrations
echo "🔄 Running database migrations..."
php artisan migrate
if [ $? -ne 0 ]; then
    echo "❌ Failed to run migrations. Please check your database configuration."
    exit 1
fi
echo "✅ Database migrations completed!"
echo ""

# Seed the database
echo "🌱 Seeding database with initial data..."
php artisan db:seed
if [ $? -ne 0 ]; then
    echo "❌ Failed to seed database"
    exit 1
fi
echo "✅ Database seeded successfully!"
echo ""

# Build assets
echo "🎨 Building frontend assets..."
npm run build
if [ $? -ne 0 ]; then
    echo "❌ Failed to build assets"
    exit 1
fi
echo "✅ Frontend assets built successfully!"
echo ""

# Clear caches
echo "🧹 Clearing application caches..."
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
echo "✅ Application caches cleared!"
echo ""

echo "🎉 Setup completed successfully!"
echo ""
echo "📋 Default Login Credentials:"
echo "=============================="
echo "Admin User:"
echo "  Email: admin@payroll.com"
echo "  Password: password"
echo ""
echo "HR Manager:"
echo "  Email: hr@payroll.com"
echo "  Password: password"
echo ""
echo "Employee:"
echo "  Email: employee@payroll.com"
echo "  Password: password"
echo ""
echo "🚀 To start the application:"
echo "  php artisan serve"
echo ""
echo "🌐 Then visit: http://localhost:8000"
echo ""
echo "📚 For more information, check the README.md file"
echo ""
echo "Happy coding! 🎯"

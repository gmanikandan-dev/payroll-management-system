# Payroll Management System

A comprehensive Laravel-based payroll management system designed for managing employee data, attendance tracking, and payroll processing with role-based access control.

## 📋 Table of Contents

- [Project Overview](#project-overview)
- [Features](#features)
- [Technology Stack](#technology-stack)
- [Requirements](#requirements)
- [Installation & Setup](#installation--setup)
- [Project Flow](#project-flow)
- [Database Structure](#database-structure)
- [User Roles & Permissions](#user-roles--permissions)
- [API Endpoints](#api-endpoints)
- [Usage Guide](#usage-guide)
- [Development Workflow](#development-workflow)
- [Contributing](#contributing)

## 🎯 Project Overview

This payroll management system is built using Laravel 11 with modern web technologies. It provides a complete solution for managing employee information, tracking attendance, processing payroll, and maintaining organizational structure with proper role-based access control.

### Key Objectives
- **Employee Management**: Complete employee lifecycle management
- **Attendance Tracking**: Daily attendance recording and monitoring
- **Payroll Processing**: Automated salary calculations and approval workflow
- **Department Management**: Organizational structure management
- **Role-Based Security**: Secure access control for different user types

## ✨ Features

### Core Functionality
- 👥 **Employee Management**: Create, update, and manage employee records
- 📅 **Attendance Tracking**: Record and monitor daily attendance
- 💰 **Payroll Processing**: Automated salary calculations with approval workflow
- 🏢 **Department Management**: Organize employees by departments and positions
- 🔐 **Role-Based Access Control**: Admin, HR, and Employee roles with specific permissions

### Advanced Features
- 📊 **Dashboard Analytics**: Comprehensive statistics and reporting
- 📥 **Bulk Import**: Mass attendance data import functionality
- 🔄 **Automated Calculations**: Overtime, deductions, and net salary calculations
- 📱 **Responsive Design**: Mobile-friendly interface with Tailwind CSS
- 🛡️ **Security**: Middleware-based authentication and authorization

## 🛠 Technology Stack

### Backend
- **Laravel 11**: PHP framework
- **MySQL**: Database management
- **Eloquent ORM**: Database interactions
- **Laravel Breeze**: Authentication scaffolding

### Frontend
- **Blade Templates**: Server-side templating
- **Tailwind CSS**: Utility-first CSS framework
- **Alpine.js**: Lightweight JavaScript framework
- **Responsive Design**: Mobile-first approach

### Development Tools
- **Composer**: PHP dependency management
- **NPM**: Node.js package management
- **Vite**: Build tool and development server
- **Git**: Version control

## 📋 Requirements

### System Requirements
- **PHP**: 8.2 or higher
- **Composer**: Latest version
- **Node.js**: 18.x or higher
- **NPM**: 9.x or higher
- **MySQL**: 8.0 or higher
- **Web Server**: Apache/Nginx (or Laravel Sail)

### PHP Extensions
```bash
# Required PHP extensions
- BCMath
- Ctype
- cURL
- DOM
- Fileinfo
- JSON
- Mbstring
- OpenSSL
- PCRE
- PDO
- Tokenizer
- XML
```

## 🚀 Installation & Setup

### 1. Clone the Repository
```bash
git clone <repository-url>
cd payroll-system
```

### 2. Install PHP Dependencies
```bash
composer install
```

### 3. Install Node.js Dependencies
```bash
npm install
```

### 4. Environment Configuration
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 5. Database Setup
```bash
# Create database (MySQL)
mysql -u root -p
CREATE DATABASE payroll_system;

# Update .env file with database credentials
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=payroll_system
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 6. Run Migrations and Seeders
```bash
# Run database migrations
php artisan migrate

# Seed the database with initial data
php artisan db:seed
```

### 7. Build Assets
```bash
# Build frontend assets
npm run build

# Or for development
npm run dev
```

### 8. Start the Application
```bash
# Start Laravel development server
php artisan serve

# Application will be available at http://localhost:8000
```

## 🔄 Project Flow

### Development Timeline

#### Phase 1: Project Setup & Foundation
1. **Laravel Installation**: Set up Laravel 11 with Breeze authentication
2. **Database Design**: Created comprehensive database schema
3. **Model Creation**: Built Eloquent models with relationships
4. **Migration Files**: Designed database structure with foreign keys

#### Phase 2: Core Functionality
1. **Employee Management**: CRUD operations for employee records
2. **Department Management**: Organizational structure setup
3. **Position Management**: Job roles and salary structures
4. **Attendance System**: Daily attendance tracking

#### Phase 3: Payroll Processing
1. **Payroll Periods**: Time-based payroll management
2. **Salary Calculations**: Automated gross/net salary computation
3. **Approval Workflow**: Multi-step payroll approval process
4. **Reporting**: Comprehensive payroll reports

#### Phase 4: Security & Access Control
1. **Role-Based System**: Admin, HR, Employee roles
2. **Permission Management**: Granular access control
3. **Middleware Implementation**: Route protection
4. **User Authentication**: Secure login/logout system

#### Phase 5: UI/UX Enhancement
1. **Tailwind CSS Integration**: Modern, responsive design
2. **Dashboard Creation**: Comprehensive analytics dashboard
3. **Form Optimization**: User-friendly input forms
4. **Error Handling**: Beautiful error pages (403, 404)

#### Phase 6: Advanced Features
1. **Bulk Operations**: Mass data import capabilities
2. **System Health Monitoring**: Admin diagnostic tools
3. **Data Validation**: Comprehensive input validation
4. **Performance Optimization**: Database query optimization

## 🗄️ Database Structure

### Core Tables
```
users (authentication)
├── roles (user roles)
├── permissions (system permissions)
├── role_user (pivot table)
└── permission_role (pivot table)

employees (employee records)
├── departments (organizational units)
├── positions (job roles)
├── salary_structures (compensation details)
├── attendance_records (daily attendance)
└── payroll_records (salary payments)

payroll_periods (payroll cycles)
├── payroll_records (individual payments)
├── allowances (salary additions)
└── deductions (salary subtractions)
```

### Key Relationships
- **User ↔ Employee**: One-to-one relationship
- **Employee ↔ Department**: Many-to-one relationship
- **Employee ↔ Position**: Many-to-one relationship
- **Employee ↔ Attendance**: One-to-many relationship
- **PayrollPeriod ↔ PayrollRecord**: One-to-many relationship

## 👥 User Roles & Permissions

### Administrator
- **Full System Access**: All features and data
- **User Management**: Create and manage user accounts
- **System Configuration**: Modify system settings
- **Reports & Analytics**: Access to all reports

### Human Resources (HR)
- **Employee Management**: Create, update employee records
- **Payroll Processing**: Process and approve payroll
- **Attendance Management**: View and manage attendance
- **Department Management**: Organize departments and positions

### Employee
- **Self-Service**: View own profile and attendance
- **Limited Access**: Cannot modify other employee data
- **Personal Information**: Update own contact details

## 🔗 API Endpoints

### Authentication Routes
```
POST /login          - User login
POST /logout         - User logout
POST /register       - User registration
```

### Employee Management
```
GET    /employees           - List all employees
POST   /employees           - Create new employee
GET    /employees/{id}      - View employee details
PUT    /employees/{id}      - Update employee
DELETE /employees/{id}      - Delete employee
```

### Attendance Management
```
GET    /attendance                    - List attendance records
POST   /attendance                    - Create attendance record
GET    /attendance/bulk-import        - Bulk import form
POST   /attendance/bulk-import        - Process bulk import
GET    /my-attendance                 - Employee's own attendance
```

### Payroll Management
```
GET    /payrolls                      - List payroll periods
POST   /payrolls                      - Create payroll period
GET    /payrolls/{id}                 - View payroll details
POST   /payrolls/{id}/process         - Process payroll
POST   /payrolls/{id}/approve         - Approve payroll
```

## 📖 Usage Guide

### For Administrators
1. **Login** with admin credentials
2. **Create Departments** and **Positions**
3. **Add Employees** with user accounts
4. **Monitor System Health** via dashboard
5. **Process Payroll** for all employees

### For HR Managers
1. **Login** with HR credentials
2. **Manage Employee Records**
3. **Track Daily Attendance**
4. **Process Monthly Payroll**
5. **Generate Reports**

### For Employees
1. **Login** with employee credentials
2. **View Personal Profile**
3. **Check Attendance Records**
4. **Update Contact Information**

## 🔧 Development Workflow

### Git Workflow
```bash
# Create feature branch
git checkout -b feature/new-feature

# Make changes and commit
git add .
git commit -m "Add new feature"

# Push to remote
git push origin feature/new-feature

# Create pull request
```

### Code Standards
- **PSR-12**: PHP coding standards
- **Laravel Conventions**: Follow Laravel best practices
- **Blade Templates**: Use consistent naming conventions
- **Database**: Use descriptive table and column names

### Testing
```bash
# Run PHP tests
php artisan test

# Run specific test
php artisan test --filter=EmployeeTest

# Check code coverage
php artisan test --coverage
```

## 🚀 Deployment

### Production Setup
1. **Environment Configuration**: Update `.env` for production
2. **Database Migration**: Run migrations on production database
3. **Asset Compilation**: Build optimized assets
4. **Cache Optimization**: Enable Laravel caching
5. **Web Server Configuration**: Set up Apache/Nginx

### Environment Variables
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_CONNECTION=mysql
DB_HOST=your-db-host
DB_DATABASE=payroll_system
DB_USERNAME=your-username
DB_PASSWORD=your-password
```

## 📊 System Monitoring

### Health Check Endpoint
```
GET /health - System health status (Admin only)
```

### Monitoring Features
- Database connection status
- Data integrity checks
- Employee-User relationship validation
- System error tracking

## 🤝 Contributing

### How to Contribute
1. **Fork** the repository
2. **Create** a feature branch
3. **Make** your changes
4. **Test** thoroughly
5. **Submit** a pull request

### Code Review Process
- All code must be reviewed before merging
- Follow established coding standards
- Include comprehensive tests
- Update documentation as needed

## 📝 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 👥 Team

- **Project Lead**: [Your Name]
- **Backend Development**: Laravel & PHP
- **Frontend Development**: Blade & Tailwind CSS
- **Database Design**: MySQL & Eloquent ORM

## 📞 Support

For questions or support, please contact:
- **Email**: your-email@example.com
- **GitHub Issues**: Create an issue in the repository
- **Documentation**: Check the wiki for detailed guides

---

## 🎉 Project Completion Summary

This payroll management system represents a comprehensive solution for modern HR and payroll needs. The project successfully demonstrates:

- **Full-Stack Development**: Laravel backend with modern frontend
- **Database Design**: Well-structured relational database
- **Security Implementation**: Role-based access control
- **User Experience**: Intuitive and responsive interface
- **Scalability**: Modular architecture for future enhancements

The system is production-ready and can be deployed for real-world use in small to medium-sized organizations.

---

*Last updated: October 2024*
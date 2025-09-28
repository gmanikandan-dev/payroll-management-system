# Payroll Management System

A comprehensive payroll management system built with Laravel 12, featuring employee management, attendance tracking, and automated payroll processing.

## Features

### Core Functionality
- **Employee Management**: Complete employee lifecycle management with detailed profiles
- **Department & Position Management**: Organized company structure with role-based access
- **Attendance Tracking**: Daily attendance recording with overtime calculation
- **Payroll Processing**: Automated salary calculations with allowances and deductions
- **Dashboard Analytics**: Real-time insights and reporting

### Technical Features
- **Authentication**: Laravel Breeze with secure user management
- **Responsive Design**: Modern UI built with Tailwind CSS
- **Database Design**: Optimized schema with proper relationships
- **Code Quality**: PSR-12 compliant with comprehensive documentation

## Installation

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js & NPM
- MySQL/PostgreSQL/SQLite

### Setup Instructions

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd payroll-system
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node.js dependencies**
   ```bash
   npm install
   ```

4. **Environment configuration**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Database setup**
   ```bash
   # Configure your database in .env file
   php artisan migrate
   php artisan db:seed
   ```

6. **Build assets**
   ```bash
   npm run build
   ```

7. **Start the development server**
   ```bash
   php artisan serve
   ```

## Default Login Credentials

- **Email**: admin@payroll.com
- **Password**: password

## Database Schema

### Core Tables
- `users` - System users and authentication
- `departments` - Company departments
- `positions` - Job positions within departments
- `employees` - Employee information and profiles
- `salary_structures` - Employee salary configurations
- `payroll_periods` - Payroll processing periods
- `payroll_records` - Individual payroll calculations
- `attendance_records` - Daily attendance tracking
- `allowances` - Salary allowances
- `deductions` - Salary deductions

### Relationships
- Employees belong to Departments and Positions
- Payroll Records are linked to Employees and Payroll Periods
- Attendance Records track Employee daily attendance
- Allowances and Deductions are associated with Payroll Records

## Usage

### Employee Management
1. Navigate to **Employees** section
2. Add new employees with complete information
3. Assign departments and positions
4. Set salary structures and benefits

### Payroll Processing
1. Create payroll periods with start/end dates
2. System automatically calculates based on attendance
3. Review and approve payroll records
4. Generate payroll reports

### Attendance Tracking
1. Record daily attendance for employees
2. Track check-in/check-out times
3. Calculate overtime hours automatically
4. Generate attendance reports

## API Endpoints

### Authentication
- `POST /login` - User authentication
- `POST /logout` - User logout
- `POST /register` - User registration

### Employee Management
- `GET /employees` - List all employees
- `POST /employees` - Create new employee
- `GET /employees/{id}` - Get employee details
- `PUT /employees/{id}` - Update employee
- `DELETE /employees/{id}` - Terminate employee

### Payroll Management
- `GET /payrolls` - List payroll periods
- `POST /payrolls` - Create payroll period
- `POST /payrolls/{id}/process` - Process payroll
- `POST /payrolls/{id}/approve` - Approve payroll

## Development

### Code Standards
- Follow PSR-12 coding standards
- Use meaningful variable and function names
- Write comprehensive PHPDoc comments
- Implement proper error handling

### Testing
```bash
# Run tests
php artisan test

# Run with coverage
php artisan test --coverage
```

### Code Quality
```bash
# Run Laravel Pint for code formatting
./vendor/bin/pint

# Run static analysis
./vendor/bin/phpstan analyse
```

## Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## Security

- All user inputs are validated and sanitized
- CSRF protection enabled on all forms
- SQL injection prevention through Eloquent ORM
- XSS protection with proper output escaping
- Secure authentication with Laravel Breeze

## Performance

- Database queries optimized with eager loading
- Proper indexing on frequently queried columns
- Caching implemented for static data
- Pagination for large datasets
- Image optimization for file uploads

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Support

For support and questions, please contact the development team or create an issue in the repository.

## Changelog

### Version 1.0.0
- Initial release
- Employee management system
- Payroll processing
- Attendance tracking
- Dashboard analytics
- User authentication
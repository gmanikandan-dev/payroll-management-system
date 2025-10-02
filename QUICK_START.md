# 🚀 Quick Start Guide

## For Your Classmates - Get Running in 5 Minutes!

### Prerequisites Check
```bash
# Check if you have the required tools
php --version    # Should be 8.2+
composer --version
node --version   # Should be 18+
npm --version
mysql --version  # Should be 8.0+
```

### One-Command Setup
```bash
# Clone and setup everything automatically
git clone <your-repo-url>
cd payroll-system
chmod +x setup.sh
./setup.sh
```

### Manual Setup (if script doesn't work)
```bash
# 1. Install dependencies
composer install
npm install

# 2. Setup environment
cp .env.example .env
php artisan key:generate

# 3. Configure database in .env file
DB_DATABASE=payroll_system
DB_USERNAME=your_username
DB_PASSWORD=your_password

# 4. Create database
mysql -u root -p
CREATE DATABASE payroll_system;
exit

# 5. Run migrations and seeders
php artisan migrate
php artisan db:seed

# 6. Build assets
npm run build

# 7. Start the application
php artisan serve
```

### Default Login Credentials
| Role | Email | Password |
|------|-------|----------|
| Admin | admin@payroll.com | password |
| HR | hr@payroll.com | password |
| Employee | employee@payroll.com | password |

### What You Can Do After Login

#### As Admin:
- View comprehensive dashboard
- Manage all employees, departments, payrolls
- Access system health monitoring
- Full system control

#### As HR:
- Manage employee records
- Process payroll
- Track attendance
- Generate reports

#### As Employee:
- View your profile
- Check your attendance records
- Update personal information

### Common Issues & Solutions

#### Database Connection Error
```bash
# Check if MySQL is running
sudo service mysql start

# Verify database exists
mysql -u root -p -e "SHOW DATABASES;"
```

#### Permission Denied
```bash
# Fix file permissions
sudo chown -R $USER:$USER storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
```

#### Composer Issues
```bash
# Clear composer cache
composer clear-cache
composer install --no-cache
```

### Project Structure Overview
```
payroll-system/
├── app/
│   ├── Http/Controllers/     # All controllers
│   ├── Models/              # Database models
│   └── Http/Middleware/     # Custom middleware
├── database/
│   ├── migrations/          # Database structure
│   └── seeders/            # Initial data
├── resources/
│   ├── views/              # Blade templates
│   └── css/                # Stylesheets
├── routes/
│   └── web.php             # Application routes
└── public/                 # Web accessible files
```

### Key Features to Explore

1. **Employee Management**
   - Create new employees
   - Link employees to user accounts
   - Manage employee information

2. **Attendance System**
   - Record daily attendance
   - Bulk import attendance data
   - View attendance reports

3. **Payroll Processing**
   - Create payroll periods
   - Process monthly payroll
   - Approve payroll records

4. **Department Management**
   - Organize company structure
   - Manage positions and roles
   - Assign employees to departments

### Development Tips

#### Adding New Features
1. Create migration: `php artisan make:migration create_new_table`
2. Create model: `php artisan make:model NewModel`
3. Create controller: `php artisan make:controller NewController`
4. Add routes in `routes/web.php`
5. Create views in `resources/views/`

#### Database Changes
```bash
# Create new migration
php artisan make:migration add_new_column_to_table

# Run migrations
php artisan migrate

# Rollback if needed
php artisan migrate:rollback
```

#### Frontend Development
```bash
# Watch for changes during development
npm run dev

# Build for production
npm run build
```

### Testing the System

#### Test Employee Creation
1. Login as Admin/HR
2. Go to Employees → Add Employee
3. Fill in employee details
4. Check "Create user account" option
5. Submit and verify employee is created

#### Test Attendance Recording
1. Login as Admin/HR
2. Go to Attendance → Add Record
3. Select employee and date
4. Record check-in/check-out times
5. Verify attendance is recorded

#### Test Payroll Processing
1. Login as Admin/HR
2. Go to Payroll → Create Payroll Period
3. Set start/end dates
4. Process payroll for the period
5. Approve the payroll

### Need Help?

1. **Check the full README.md** for detailed documentation
2. **Look at the code comments** in controllers and models
3. **Check Laravel documentation** for framework-specific questions
4. **Ask your classmates** or instructor for help

### Next Steps

Once you have the system running:
1. Explore all the features
2. Try creating your own employees
3. Test the payroll processing workflow
4. Customize the UI if needed
5. Add new features as required

Happy coding! 🎉

# 👨‍💻 Development Guide

## Getting Started with Development

### Prerequisites
- PHP 8.2+
- Composer
- Node.js 18+
- MySQL 8.0+
- Git

### Initial Setup
```bash
# Clone the repository
git clone <your-repo-url>
cd payroll-system

# Run the setup script
chmod +x setup.sh
./setup.sh
```

### Development Workflow

#### 1. Daily Development Setup
```bash
# Start the development server
php artisan serve

# In another terminal, start Vite for hot reloading
npm run dev
```

#### 2. Making Changes

##### Adding New Features
```bash
# Create a new migration
php artisan make:migration create_new_table

# Create a new model
php artisan make:model NewModel

# Create a new controller
php artisan make:controller NewController

# Create a new seeder
php artisan make:seeder NewSeeder
```

##### Database Changes
```bash
# Run migrations
php artisan migrate

# Rollback if needed
php artisan migrate:rollback

# Reset database
php artisan migrate:fresh --seed
```

##### Frontend Changes
```bash
# Watch for changes
npm run dev

# Build for production
npm run build
```

### Code Structure

#### Controllers
Located in `app/Http/Controllers/`
- **EmployeeController**: Employee management
- **AttendanceController**: Attendance tracking
- **PayrollController**: Payroll processing
- **DepartmentController**: Department management
- **DashboardController**: Dashboard and analytics

#### Models
Located in `app/Models/`
- **Employee**: Employee data and relationships
- **User**: Authentication and roles
- **Department**: Organizational structure
- **Position**: Job roles
- **AttendanceRecord**: Daily attendance
- **PayrollRecord**: Salary payments

#### Views
Located in `resources/views/`
- **employees/**: Employee management views
- **attendance/**: Attendance tracking views
- **payrolls/**: Payroll processing views
- **departments/**: Department management views
- **layouts/**: Shared layout components

#### Routes
Located in `routes/web.php`
- Resource routes for CRUD operations
- Custom routes for special functionality
- Middleware-protected routes

### Database Schema

#### Key Tables
```sql
-- Users and Authentication
users (id, name, email, password, created_at, updated_at)
roles (id, name, slug, description, is_active)
permissions (id, name, slug, description, resource, action)
role_user (user_id, role_id)
permission_role (permission_id, role_id)

-- Employee Management
employees (id, employee_id, first_name, last_name, email, phone, hire_date, position_id, department_id, user_id, employment_status, basic_salary)
departments (id, name, description, code, is_active)
positions (id, title, description, code, department_id, min_salary, max_salary, is_active)

-- Attendance and Payroll
attendance_records (id, employee_id, date, check_in, check_out, hours_worked, overtime_hours, status, notes)
payroll_periods (id, name, start_date, end_date, status, pay_date, created_by)
payroll_records (id, payroll_period_id, employee_id, basic_salary, total_allowances, total_deductions, gross_salary, net_salary, status)
```

### Common Development Tasks

#### Adding a New Employee Field
1. Create migration:
```bash
php artisan make:migration add_new_field_to_employees_table
```

2. Update migration file:
```php
public function up()
{
    Schema::table('employees', function (Blueprint $table) {
        $table->string('new_field')->nullable();
    });
}
```

3. Update Employee model:
```php
protected $fillable = [
    // ... existing fields
    'new_field',
];
```

4. Update views and forms

#### Adding a New User Role
1. Add to RoleSeeder:
```php
[
    'name' => 'New Role',
    'slug' => 'new_role',
    'description' => 'Description of new role',
    'is_active' => true,
],
```

2. Add permissions in PermissionSeeder

3. Update middleware and routes

#### Creating a New Feature
1. Create migration for new table
2. Create model with relationships
3. Create controller with CRUD methods
4. Create views (index, create, edit, show)
5. Add routes to web.php
6. Update navigation if needed

### Testing

#### Manual Testing
```bash
# Test database connection
php artisan tinker
DB::connection()->getPdo();

# Test models
Employee::count();
User::with('roles')->get();
```

#### Browser Testing
1. Test all CRUD operations
2. Test role-based access
3. Test form validation
4. Test responsive design

### Debugging

#### Common Debugging Commands
```bash
# Check routes
php artisan route:list

# Check configuration
php artisan config:show

# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Check logs
tail -f storage/logs/laravel.log
```

#### Using Tinker
```bash
# Start Tinker
php artisan tinker

# Test queries
Employee::all();
User::where('email', 'admin@payroll.com')->first();
DB::table('employees')->count();
```

### Performance Optimization

#### Database Optimization
```bash
# Add indexes to frequently queried columns
php artisan make:migration add_indexes_to_employees_table

# Use eager loading to prevent N+1 queries
Employee::with('department', 'position')->get();
```

#### Frontend Optimization
```bash
# Build optimized assets
npm run build

# Enable caching in production
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Security Best Practices

#### Authentication
- Always use Laravel's built-in authentication
- Implement proper middleware for route protection
- Validate all user inputs

#### Authorization
- Use role-based access control
- Check permissions before allowing actions
- Implement proper error handling

#### Data Protection
- Use Eloquent ORM to prevent SQL injection
- Validate and sanitize all inputs
- Use CSRF protection on forms

### Deployment

#### Production Setup
```bash
# Set production environment
APP_ENV=production
APP_DEBUG=false

# Optimize for production
composer install --optimize-autoloader --no-dev
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

#### Environment Variables
```env
APP_NAME="Payroll Management System"
APP_ENV=production
APP_KEY=base64:your-generated-key
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=payroll_system
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### Common Issues and Solutions

#### Database Connection Issues
```bash
# Check MySQL service
sudo service mysql status
sudo service mysql start

# Test connection
mysql -u username -p -h hostname database_name
```

#### Permission Issues
```bash
# Fix file permissions
sudo chown -R www-data:www-data /path/to/project
sudo chmod -R 755 /path/to/project
sudo chmod -R 775 storage bootstrap/cache
```

#### Memory Issues
```bash
# Increase PHP memory limit
php -d memory_limit=512M artisan serve

# Optimize Composer
composer dump-autoload --optimize
```

### Code Style and Standards

#### PHP Standards
- Follow PSR-12 coding standards
- Use meaningful variable and function names
- Add comments for complex logic
- Keep functions small and focused

#### Laravel Conventions
- Use resource controllers for CRUD operations
- Follow Laravel naming conventions
- Use Eloquent relationships properly
- Implement proper validation

#### Frontend Standards
- Use semantic HTML
- Follow BEM methodology for CSS
- Keep JavaScript minimal and focused
- Ensure responsive design

### Collaboration

#### Git Workflow
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

#### Code Review
- Review all code before merging
- Check for security vulnerabilities
- Ensure proper error handling
- Verify functionality works as expected

### Resources

#### Documentation
- [Laravel Documentation](https://laravel.com/docs)
- [Tailwind CSS Documentation](https://tailwindcss.com/docs)
- [MySQL Documentation](https://dev.mysql.com/doc/)

#### Tools
- **IDE**: VS Code, PhpStorm, or Sublime Text
- **Database**: phpMyAdmin, MySQL Workbench, or Sequel Pro
- **API Testing**: Postman or Insomnia
- **Version Control**: Git with GitHub/GitLab

#### Community
- [Laravel Discord](https://discord.gg/laravel)
- [Stack Overflow](https://stackoverflow.com/questions/tagged/laravel)
- [Laravel News](https://laravel-news.com/)

---

*Happy coding! Remember to test thoroughly and follow best practices.*

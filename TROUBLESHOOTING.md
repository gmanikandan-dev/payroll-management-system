# 🔧 Troubleshooting Guide

## Common Issues and Solutions

### Database Issues

#### 1. Database Connection Error
**Error:** `SQLSTATE[HY000] [2002] Connection refused`

**Solutions:**
```bash
# Check if MySQL is running
sudo service mysql start
# or
sudo systemctl start mysql

# Check MySQL status
sudo service mysql status

# Test connection
mysql -u root -p
```

#### 2. Database Not Found
**Error:** `SQLSTATE[HY000] [1049] Unknown database 'payroll_system'`

**Solutions:**
```bash
# Create database
mysql -u root -p
CREATE DATABASE payroll_system;
exit

# Or update .env file with correct database name
DB_DATABASE=your_database_name
```

#### 3. Migration Errors
**Error:** `SQLSTATE[HY000]: General error: 1824 Failed to open the referenced table`

**Solutions:**
```bash
# Drop all tables and re-run migrations
php artisan migrate:fresh

# Or reset and re-run
php artisan migrate:reset
php artisan migrate
```

### PHP/Composer Issues

#### 1. Composer Memory Limit
**Error:** `Fatal error: Allowed memory size exhausted`

**Solutions:**
```bash
# Increase memory limit
php -d memory_limit=2G /usr/local/bin/composer install

# Or set in php.ini
memory_limit = 2G
```

#### 2. PHP Version Issues
**Error:** `This package requires php ^8.2`

**Solutions:**
```bash
# Check PHP version
php --version

# Update PHP (Ubuntu/Debian)
sudo apt update
sudo apt install php8.2 php8.2-cli php8.2-mysql

# Update PHP (macOS with Homebrew)
brew install php@8.2
```

#### 3. Missing PHP Extensions
**Error:** `The requested PHP extension ext-name is missing`

**Solutions:**
```bash
# Install required extensions (Ubuntu/Debian)
sudo apt install php8.2-mysql php8.2-mbstring php8.2-xml php8.2-curl php8.2-zip

# Install required extensions (macOS)
brew install php@8.2-mysql php@8.2-mbstring
```

### Node.js/NPM Issues

#### 1. NPM Permission Errors
**Error:** `EACCES: permission denied`

**Solutions:**
```bash
# Fix npm permissions
sudo chown -R $(whoami) ~/.npm
sudo chown -R $(whoami) /usr/local/lib/node_modules

# Or use nvm
curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.0/install.sh | bash
nvm install 18
nvm use 18
```

#### 2. Node Version Issues
**Error:** `The engine "node" is incompatible with this module`

**Solutions:**
```bash
# Check Node version
node --version

# Update Node.js
# Using nvm (recommended)
nvm install 18
nvm use 18

# Or download from nodejs.org
```

### Laravel Application Issues

#### 1. Application Key Missing
**Error:** `No application encryption key has been specified`

**Solutions:**
```bash
# Generate application key
php artisan key:generate

# Or manually set in .env
APP_KEY=base64:your-key-here
```

#### 2. Storage Permissions
**Error:** `The stream or file could not be opened`

**Solutions:**
```bash
# Fix storage permissions
sudo chown -R www-data:www-data storage
sudo chmod -R 775 storage

# Or for development
sudo chown -R $USER:$USER storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
```

#### 3. Route Cache Issues
**Error:** `Route not found`

**Solutions:**
```bash
# Clear route cache
php artisan route:clear
php artisan config:clear
php artisan cache:clear

# Rebuild cache
php artisan config:cache
php artisan route:cache
```

### Frontend/Build Issues

#### 1. Vite Build Errors
**Error:** `Failed to resolve import`

**Solutions:**
```bash
# Clear node modules and reinstall
rm -rf node_modules package-lock.json
npm install

# Clear Vite cache
npm run build -- --force
```

#### 2. Tailwind CSS Not Working
**Error:** Styles not applying

**Solutions:**
```bash
# Rebuild assets
npm run build

# Check tailwind.config.js
# Ensure content paths are correct
content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
],
```

### Authentication Issues

#### 1. Login Not Working
**Error:** Invalid credentials

**Solutions:**
```bash
# Reset database and reseed
php artisan migrate:fresh --seed

# Check if users exist
php artisan tinker
User::all()
```

#### 2. Role/Permission Errors
**Error:** `Unauthorized access`

**Solutions:**
```bash
# Re-run role and permission seeders
php artisan db:seed --class=RoleSeeder
php artisan db:seed --class=PermissionSeeder
php artisan db:seed --class=RolePermissionSeeder
```

### Development Environment Issues

#### 1. Port Already in Use
**Error:** `Address already in use`

**Solutions:**
```bash
# Find process using port 8000
lsof -i :8000

# Kill the process
kill -9 PID

# Or use different port
php artisan serve --port=8080
```

#### 2. File Watcher Issues (Vite)
**Error:** `ENOSPC: System limit for number of file watchers reached`

**Solutions:**
```bash
# Increase file watcher limit
echo fs.inotify.max_user_watches=524288 | sudo tee -a /etc/sysctl.conf
sudo sysctl -p
```

### Browser Issues

#### 1. Mixed Content Errors
**Error:** `Mixed Content: The page was loaded over HTTPS`

**Solutions:**
```bash
# Use HTTPS in development
php artisan serve --host=0.0.0.0 --port=8000

# Or update APP_URL in .env
APP_URL=https://localhost:8000
```

#### 2. CORS Issues
**Error:** `Access to fetch at '...' from origin '...' has been blocked by CORS policy`

**Solutions:**
```bash
# Install CORS package
composer require fruitcake/laravel-cors

# Publish config
php artisan vendor:publish --tag="cors"
```

### Performance Issues

#### 1. Slow Database Queries
**Solutions:**
```bash
# Enable query logging
DB_LOG_QUERIES=true

# Add database indexes
php artisan make:migration add_indexes_to_tables
```

#### 2. Memory Issues
**Solutions:**
```bash
# Increase PHP memory limit
php -d memory_limit=512M artisan serve

# Optimize Composer autoloader
composer dump-autoload --optimize
```

### Deployment Issues

#### 1. Production Environment
**Solutions:**
```bash
# Set production environment
APP_ENV=production
APP_DEBUG=false

# Optimize for production
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

#### 2. File Permissions
**Solutions:**
```bash
# Set correct permissions
sudo chown -R www-data:www-data /path/to/project
sudo chmod -R 755 /path/to/project
sudo chmod -R 775 storage bootstrap/cache
```

## Getting Help

### Debug Mode
```bash
# Enable debug mode
APP_DEBUG=true

# Check logs
tail -f storage/logs/laravel.log
```

### Useful Commands
```bash
# Check Laravel installation
php artisan --version

# List all routes
php artisan route:list

# Check configuration
php artisan config:show

# Database status
php artisan migrate:status
```

### Community Resources
- **Laravel Documentation**: https://laravel.com/docs
- **Stack Overflow**: Search for Laravel-specific issues
- **Laravel Discord**: Real-time community help
- **GitHub Issues**: Check project repository issues

### Contact Information
- **Project Repository**: [Your GitHub repo]
- **Email**: [Your email]
- **Class Discord/Slack**: [Your class communication channel]

## Prevention Tips

### Best Practices
1. **Always backup** before making changes
2. **Use version control** (Git) for all changes
3. **Test in development** before production
4. **Keep dependencies updated**
5. **Monitor logs** regularly

### Environment Setup
1. **Use consistent PHP versions** across team
2. **Document all setup steps**
3. **Use Docker** for consistent environments
4. **Keep .env.example updated**
5. **Test setup script** regularly

---

*If you encounter an issue not covered here, please create an issue in the project repository or ask for help in the class communication channel.*

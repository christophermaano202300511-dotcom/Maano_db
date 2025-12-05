# Troubleshooting Guide - Maano Database Project

## Connection Issues

### Problem: "Connection failed: Connection refused"
**Cause:** MySQL service is not running

**Solutions:**
1. Open XAMPP Control Panel
2. Click "Start" button next to MySQL module
3. Wait for status to show "Running"
4. Refresh your browser

---

### Problem: "Connection failed: Unknown database 'maano_db'"
**Cause:** Database hasn't been created yet

**Solutions:**
1. Go to http://localhost/phpmyadmin/
2. Create database manually:
   - Click "New" 
   - Enter database name: `maano_db`
   - Click Create
3. Then run setup_database.sql:
   - Click "SQL" tab
   - Copy entire contents of setup_database.sql
   - Paste into SQL query window
   - Click "Go"

---

### Problem: "Access denied for user 'root'@'localhost'"
**Cause:** MySQL credentials are incorrect

**Solutions:**
1. Check your XAMPP MySQL password:
   - Default password is empty
2. Update database.php if needed:
   ```php
   $username = "root";
   $password = ""; // Empty for default XAMPP
   ```
3. Restart MySQL service

---

## Display Issues

### Problem: Blank page or "0 results" everywhere
**Cause:** No data in database tables

**Solutions:**
1. Verify database exists: http://localhost/phpmyadmin/
2. Check if tables were created:
   - In phpMyAdmin, select `maano_db` database
   - Look for tables: categories, products, customers, orders, order_items
3. If tables exist but are empty, add sample data:
   - Go to manage_categories.php
   - Click "Add New Category" and add at least one category
   - Then add products and customers

---

### Problem: CSS not loading (page looks plain)
**Cause:** style.css file is missing or path is wrong

**Solutions:**
1. Verify style.css exists in your project folder:
   ```
   C:\xampp\htdocs\maano_db\style.css
   ```
2. Check file name capitalization (case-sensitive on some servers)
3. Clear browser cache (Ctrl+Shift+Delete) and refresh

---

### Problem: Images or assets not showing
**Cause:** Not applicable - this project doesn't use images

---

## Navigation & Routing Issues

### Problem: Links give 404 errors or page not found
**Cause:** Files not in correct location or wrong URL

**Solutions:**
1. Verify all PHP files are in: `C:\xampp\htdocs\maano_db\`
2. Use correct URL: `http://localhost/maano_db/`
3. Don't use spaces in folder names
4. Restart Apache if files were added after startup

---

### Problem: Header navigation links don't work
**Cause:** Relative paths or server configuration

**Solutions:**
1. Make sure you're accessing via: `http://localhost/maano_db/`
2. Don't access files directly from file system
3. Use proper http:// URLs, not file://

---

## Form & Data Issues

### Problem: "Please fill all fields correctly" error
**Cause:** Missing required fields in form

**Solutions:**
1. Fill in all required fields (marked with *)
2. Check data types:
   - Prices must be numbers (e.g., 29.99)
   - Emails must be valid format
   - Dates must use date picker
3. Check for extremely long inputs

---

### Problem: "Category already exists" error
**Cause:** Duplicate category name

**Solutions:**
1. Use a different category name
2. Category names must be unique in the database
3. Check existing categories on manage_categories.php

---

### Problem: "Cannot delete category with existing products"
**Cause:** Foreign key constraint

**Solutions:**
1. This is by design - products are linked to categories
2. Delete all products in that category first
3. Then delete the category

---

### Problem: Can't create order with products
**Cause:** Missing products or customers

**Solutions:**
1. Create at least one customer first
2. Create at least one product (which requires a category)
3. Then go to create_order.php
4. Add at least one product to the order

---

## PHP Errors

### Problem: Blank page with no error message
**Cause:** PHP error display is disabled

**Solutions:**
1. Check browser console (F12 → Console)
2. Check XAMPP Apache error log:
   ```
   C:\xampp\apache\logs\error.log
   ```
3. Enable PHP error display in `database.php`:
   ```php
   error_reporting(E_ALL);
   ini_set('display_errors', 1);
   ```

---

### Problem: "Call to undefined function" errors
**Cause:** Missing PHP extensions

**Solutions:**
1. Most functions are built-in, shouldn't happen
2. Check XAMPP has PHP 7.0+ installed
3. Verify MySQLi extension is enabled

---

### Problem: Session errors or messages not showing
**Cause:** Sessions not working properly

**Solutions:**
1. Make sure `session_start()` is at top of file (it is)
2. Check tmp directory has write permissions
3. Try clearing browser cookies

---

## Performance Issues

### Problem: Page loads slowly
**Cause:** Large database or server issues

**Solutions:**
1. Check MySQL is optimized:
   - Use EXPLAIN for queries
   - Check indexes are created (they are)
2. Reduce data in tables if testing
3. Restart Apache and MySQL services

---

## Security Issues

### Problem: Getting SQL errors in user messages
**Cause:** Debug info being exposed

**Solutions:**
1. Don't modify error messages in production
2. Check database.php doesn't echo raw $conn->error
3. Use try-catch blocks to handle errors properly

---

## Complete Reinstall Instructions

If nothing works, completely restart:

1. **Stop services:**
   - XAMPP Control Panel → Stop Apache and MySQL

2. **Delete old files:**
   - Remove folder: `C:\xampp\htdocs\maano_db\`

3. **Copy new files:**
   - Place all project files in: `C:\xampp\htdocs\maano_db\`

4. **Start services:**
   - XAMPP Control Panel → Start Apache and MySQL
   - Wait for green status

5. **Create database:**
   - Go to: http://localhost/phpmyadmin/
   - Run setup_database.sql

6. **Access application:**
   - Go to: http://localhost/maano_db/

---

## Getting Help

### Check These First:
1. Is Apache running? (green in XAMPP)
2. Is MySQL running? (green in XAMPP)
3. Are all files in correct folder?
4. Can you access http://localhost/phpmyadmin/?
5. Does database `maano_db` exist?

### Debug Steps:
1. Check XAMPP error logs
2. Test database connection with phpMyAdmin
3. Look at browser developer console (F12)
4. Check file permissions
5. Try Chrome DevTools Network tab to see requests

### Advanced Help:
- XAMPP Logs: `C:\xampp\apache\logs\`
- MySQL Logs: `C:\xampp\mysql\data\`
- PHP Files: Check for syntax errors with `php -l filename.php`

---

**Still having issues?** Double-check:
- ✓ XAMPP services are running
- ✓ Files are in htdocs folder
- ✓ Database is created
- ✓ Accessing via http://localhost URL
- ✓ Using correct browser (Chrome/Firefox recommended)

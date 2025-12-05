# Maano Database Project - Complete Setup Guide

## Overview
This is a full CRUD (Create, Read, Update, Delete) application with JOIN operations for managing products, categories, customers, and orders.

## Prerequisites
- XAMPP installed (or Apache + MySQL separately)
- PHP 7.0 or higher
- Modern web browser

## Step 1: Install XAMPP

1. Download XAMPP from: https://www.apachefriends.org/
2. Run the installer and choose installation directory (e.g., `C:\xampp`)
3. Install Apache and MySQL modules
4. Complete the installation

## Step 2: Place Project Files

1. Locate your XAMPP installation folder (typically `C:\xampp`)
2. Navigate to the `htdocs` folder
3. Create a new folder named `maano_db` (or your preferred name)
4. Copy all files from this project into that folder

**Example path:** `C:\xampp\htdocs\maano_db\`

## Step 3: Start XAMPP Services

1. Open XAMPP Control Panel
2. Click "Start" for **Apache** module
3. Click "Start" for **MySQL** module
4. Wait for both to show as running (green indicator)

## Step 4: Create the Database

### Method 1: Using phpMyAdmin (GUI)

1. Open web browser and go to: `http://localhost/phpmyadmin/`
2. Click on "SQL" tab in the top menu
3. Copy and paste the entire contents of `setup_database.sql` file
4. Click "Go" to execute

### Method 2: Using Command Line

1. Open Command Prompt
2. Navigate to your XAMPP MySQL bin folder:
   ```
   cd C:\xampp\mysql\bin
   ```
3. Connect to MySQL:
   ```
   mysql -u root -p
   ```
   (Press Enter when prompted for password - default XAMPP password is empty)
4. Paste the contents of `setup_database.sql` and execute

## Step 5: Verify Database Connection

1. Update `database.php` if needed (default settings should work):
   - `$servername = "localhost"`
   - `$username = "root"`
   - `$password = ""` (empty for default XAMPP)
   - `$database = "maano_db"`

## Step 6: Access the Application

1. Open your web browser
2. Go to: `http://localhost/maano_db/`
3. You should see the Maano Database System homepage with the products list

## File Structure

```
maano_db/
├── database.php              # Database connection file
├── style.css                 # Main stylesheet
├── index.php                 # Products list (READ with JOIN)
├── add_product.php           # Add new product (CREATE)
├── edit_product.php          # Edit product (UPDATE)
├── delete_product.php        # Delete product (DELETE)
├── manage_categories.php     # View/manage categories
├── add_category.php          # Add category (CREATE)
├── edit_category.php         # Edit category (UPDATE)
├── delete_category.php       # Delete category (DELETE)
├── manage_customers.php      # View/manage customers
├── add_customer.php          # Add customer (CREATE)
├── edit_customer.php         # Edit customer (UPDATE)
├── delete_customer.php       # Delete customer (DELETE)
├── view_orders.php           # View all orders (READ with JOIN)
├── create_order.php          # Create new order (CREATE)
├── view_order_details.php    # View order details (READ with JOIN)
├── delete_order.php          # Delete order (DELETE)
├── setup_database.sql        # SQL script to create database and tables
└── README.md                 # This file
```

## Database Structure

### Tables and Relationships

**categories**
- id (Primary Key)
- category_name (Unique)
- description
- created_at

**products** (One-to-Many with categories)
- id (Primary Key)
- product_name
- description
- price
- category_id (Foreign Key → categories.id)
- created_at

**customers**
- id (Primary Key)
- first_name
- last_name
- email
- phone
- address
- created_at

**orders** (One-to-Many with customers)
- id (Primary Key)
- customer_id (Foreign Key → customers.id)
- order_date
- created_at

**order_items** (Junction table between orders and products)
- id (Primary Key)
- order_id (Foreign Key → orders.id)
- product_id (Foreign Key → products.id)
- quantity
- price
- created_at

## Features Implemented

### 1. Products Management
- **Create:** Add new products with category selection
- **Read:** Display products with category names using JOIN
- **Update:** Edit product details
- **Delete:** Remove products

### 2. Categories Management
- **Create:** Add new categories
- **Read:** Display all categories
- **Update:** Edit category information
- **Delete:** Remove categories (with validation)

### 3. Customers Management
- **Create:** Add new customers
- **Read:** Display all customers
- **Update:** Edit customer details
- **Delete:** Remove customers

### 4. Orders Management
- **Create:** Create orders with multiple products
- **Read:** Display orders with customer names (JOIN)
- **Read Details:** View order details with product information (JOIN)
- **Delete:** Remove orders

## SQL JOIN Examples Used

### 1. Products with Categories
```sql
SELECT p.id, p.product_name, p.price, c.category_name 
FROM products p
JOIN categories c ON p.category_id = c.id
```

### 2. Orders with Customers
```sql
SELECT o.id, o.order_date, c.first_name, c.last_name
FROM orders o
JOIN customers c ON o.customer_id = c.id
```

### 3. Order Items with Products
```sql
SELECT oi.id, p.product_name, oi.quantity, oi.price
FROM order_items oi
JOIN products p ON oi.product_id = p.id
WHERE oi.order_id = ?
```

## Troubleshooting

### Issue: "Connection failed: Unknown database"
- **Solution:** Make sure you've run the `setup_database.sql` script in phpMyAdmin

### Issue: Can't access phpMyAdmin
- **Solution:** Make sure Apache and MySQL are started in XAMPP Control Panel

### Issue: Pages show "0 results" or blank
- **Solution:** Insert sample data through phpMyAdmin or add categories and products using the application

### Issue: Connection to localhost failed
- **Solution:** 
  - Check MySQL is running in XAMPP
  - Verify port 3306 is available
  - Check `database.php` credentials

## Additional Notes

- All forms include HTML escaping to prevent XSS attacks
- Prepared statements are used to prevent SQL injection
- Foreign key constraints ensure data integrity
- Transactions are used when creating orders (atomic operations)
- Sample data is included in `setup_database.sql`

## Security Features

- Input validation on all forms
- SQL injection prevention using prepared statements
- XSS prevention using htmlspecialchars()
- Confirmation dialogs for delete operations
- Session management for messages and feedback

## Navigation

The application includes a navigation bar for easy access:
- **Products:** Main products list
- **Categories:** Manage product categories
- **Customers:** Manage customer information
- **Orders:** View and manage orders
- **+ Add Product:** Quick link to add products

Enjoy your Maano Database System!

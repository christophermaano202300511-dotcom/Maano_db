# Quick Start Guide - Maano Database Project

## 🚀 Get Started in 5 Minutes

### 1. Copy Project to XAMPP
```
Copy all files from Maano_db folder to:
C:\xampp\htdocs\maano_db\
```

### 2. Start Services
- Open XAMPP Control Panel
- Click "Start" on Apache
- Click "Start" on MySQL
- Wait for green indicators

### 3. Create Database
- Go to: http://localhost/phpmyadmin/
- Click "SQL" tab
- Paste contents of `setup_database.sql`
- Click "Go"

### 4. Run Application
- Open: http://localhost/maano_db/
- Click "Add Product" to start using the app

## 📁 Project Files Overview

| File | Purpose |
|------|---------|
| `database.php` | MySQL connection |
| `index.php` | Products list (main page) |
| `add_product.php` | Add new product form |
| `edit_product.php` | Edit product form |
| `delete_product.php` | Delete product script |
| `manage_categories.php` | View all categories |
| `add_category.php` | Add category script |
| `edit_category.php` | Edit category form |
| `delete_category.php` | Delete category script |
| `manage_customers.php` | View all customers |
| `add_customer.php` | Add customer script |
| `edit_customer.php` | Edit customer form |
| `delete_customer.php` | Delete customer script |
| `view_orders.php` | View all orders (with JOINs) |
| `create_order.php` | Create new order form |
| `view_order_details.php` | View single order (with JOINs) |
| `delete_order.php` | Delete order script |
| `style.css` | Application styling |
| `setup_database.sql` | Database creation script |

## 🔗 Database Relationships

```
categories (1) ──→ (Many) products
customers  (1) ──→ (Many) orders
orders     (1) ──→ (Many) order_items ←─ (Many) products
```

## 💾 Key SQL JOIN Queries

**Products with Categories:**
```sql
SELECT p.*, c.category_name 
FROM products p
JOIN categories c ON p.category_id = c.id
```

**Orders with Customers:**
```sql
SELECT o.*, c.first_name, c.last_name
FROM orders o
JOIN customers c ON o.customer_id = c.id
```

**Order Details (3-way JOIN):**
```sql
SELECT oi.*, p.product_name, o.order_date, c.first_name
FROM order_items oi
JOIN products p ON oi.product_id = p.id
JOIN orders o ON oi.order_id = o.id
JOIN customers c ON o.customer_id = c.id
```

## ✅ CRUD Operations Implemented

- ✅ **CREATE:** Add products, categories, customers, orders
- ✅ **READ:** View all items with JOIN operations
- ✅ **UPDATE:** Edit products, categories, customers
- ✅ **DELETE:** Remove items with validation
- ✅ **JOIN:** Related data displayed together
- ✅ **VALIDATION:** Input checking and error handling
- ✅ **SECURITY:** SQL injection prevention, XSS protection

## 🎯 Navigation

All pages have a navigation bar with links to:
- Products (main list)
- Categories management
- Customers management
- Orders management
- + Add Product (quick link)

## 🐛 Common Issues & Solutions

| Issue | Solution |
|-------|----------|
| Can't access phpmyadmin | Start MySQL in XAMPP |
| Pages show blank | Run `setup_database.sql` |
| Can't connect to database | Check MySQL credentials in `database.php` |
| 404 errors | Verify files in `C:\xampp\htdocs\maano_db\` |

## 📝 Default Database Credentials

- **Host:** localhost
- **Username:** root
- **Password:** (empty)
- **Database:** maano_db

## 🔒 Security Features

✓ SQL Injection Prevention (Prepared Statements)
✓ XSS Prevention (htmlspecialchars)
✓ Foreign Key Constraints
✓ Input Validation
✓ Delete Confirmations
✓ Transaction Support for Orders

---

**Need help?** Check the full `README.md` for detailed documentation.

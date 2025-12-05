# SQL Reference Guide - Maano Database Project

## Database Overview

**Database Name:** `maano_db`

**Tables:** categories, products, customers, orders, order_items

---

## CREATE Operations

### Create Category
```sql
INSERT INTO categories (category_name, description) 
VALUES ('Electronics', 'Electronic devices and gadgets');
```

### Create Product
```sql
INSERT INTO products (product_name, description, price, category_id) 
VALUES ('Laptop', 'High-performance laptop', 999.99, 1);
```

### Create Customer
```sql
INSERT INTO customers (first_name, last_name, email, phone, address) 
VALUES ('John', 'Doe', 'john@example.com', '555-0101', '123 Main St');
```

### Create Order
```sql
INSERT INTO orders (customer_id, order_date) 
VALUES (1, '2025-12-06');
```

### Create Order Item
```sql
INSERT INTO order_items (order_id, product_id, quantity, price) 
VALUES (1, 1, 2, 999.99);
```

---

## READ Operations (SELECT)

### Get All Products with Categories (JOIN)
```sql
SELECT p.id, p.product_name, p.description, p.price, c.category_name
FROM products p
JOIN categories c ON p.category_id = c.id
ORDER BY p.product_name ASC;
```

### Get All Categories
```sql
SELECT * FROM categories ORDER BY category_name ASC;
```

### Get Products by Category
```sql
SELECT p.* FROM products p
WHERE p.category_id = 1;
```

### Get All Customers
```sql
SELECT * FROM customers ORDER BY first_name ASC;
```

### Get All Orders with Customer Details (JOIN)
```sql
SELECT o.id, o.order_date, c.first_name, c.last_name, 
       COUNT(oi.id) as item_count
FROM orders o
JOIN customers c ON o.customer_id = c.id
LEFT JOIN order_items oi ON o.id = oi.order_id
GROUP BY o.id
ORDER BY o.order_date DESC;
```

### Get Order Details (3-way JOIN)
```sql
SELECT oi.id, p.product_name, oi.quantity, oi.price,
       (oi.quantity * oi.price) as subtotal
FROM order_items oi
JOIN products p ON oi.product_id = p.id
WHERE oi.order_id = 1;
```

### Get Complete Order Information (4-way JOIN)
```sql
SELECT o.id as order_id, o.order_date,
       c.first_name, c.last_name, c.email,
       p.product_name, oi.quantity, oi.price,
       (oi.quantity * oi.price) as item_total
FROM orders o
JOIN customers c ON o.customer_id = c.id
JOIN order_items oi ON o.id = oi.order_id
JOIN products p ON oi.product_id = p.id
ORDER BY o.order_date DESC, p.product_name;
```

### Count Products by Category
```sql
SELECT c.category_name, COUNT(p.id) as product_count
FROM categories c
LEFT JOIN products p ON c.id = p.category_id
GROUP BY c.id
ORDER BY c.category_name;
```

### Get Customer Order Summary
```sql
SELECT c.first_name, c.last_name, COUNT(o.id) as total_orders,
       SUM(oi.quantity * oi.price) as total_spent
FROM customers c
LEFT JOIN orders o ON c.id = o.customer_id
LEFT JOIN order_items oi ON o.id = oi.order_id
GROUP BY c.id
ORDER BY total_spent DESC;
```

---

## UPDATE Operations

### Update Category
```sql
UPDATE categories 
SET category_name = 'Computing', description = 'Computers and accessories'
WHERE id = 1;
```

### Update Product
```sql
UPDATE products 
SET product_name = 'Gaming Laptop', price = 1299.99, category_id = 1
WHERE id = 1;
```

### Update Customer
```sql
UPDATE customers 
SET email = 'newemail@example.com', phone = '555-0999'
WHERE id = 1;
```

---

## DELETE Operations

### Delete Product
```sql
DELETE FROM products WHERE id = 1;
```

### Delete Category (if no products)
```sql
DELETE FROM categories WHERE id = 1;
```

### Delete Customer
```sql
DELETE FROM customers WHERE id = 1;
```

### Delete Order (cascades to order_items)
```sql
DELETE FROM orders WHERE id = 1;
```

### Delete Order Item
```sql
DELETE FROM order_items WHERE id = 1;
```

---

## Useful Queries

### Find Products Over $100
```sql
SELECT * FROM products WHERE price > 100 ORDER BY price DESC;
```

### Find Recent Orders (Last 30 days)
```sql
SELECT o.*, c.first_name, c.last_name
FROM orders o
JOIN customers c ON o.customer_id = c.id
WHERE o.order_date >= DATE_SUB(NOW(), INTERVAL 30 DAY)
ORDER BY o.order_date DESC;
```

### Find Top 5 Most Expensive Products
```sql
SELECT * FROM products ORDER BY price DESC LIMIT 5;
```

### Find Customers Who Made Orders
```sql
SELECT DISTINCT c.* FROM customers c
JOIN orders o ON c.id = o.customer_id
ORDER BY c.first_name;
```

### Calculate Total Revenue
```sql
SELECT SUM(oi.quantity * oi.price) as total_revenue
FROM order_items oi;
```

### Find Average Order Value
```sql
SELECT AVG(order_total) as average_order_value FROM (
  SELECT SUM(oi.quantity * oi.price) as order_total
  FROM order_items oi
  GROUP BY oi.order_id
) as order_totals;
```

### Find Most Ordered Products
```sql
SELECT p.product_name, SUM(oi.quantity) as total_ordered
FROM order_items oi
JOIN products p ON oi.product_id = p.id
GROUP BY oi.product_id
ORDER BY total_ordered DESC;
```

---

## Table Schemas

### categories
```sql
CREATE TABLE categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    category_name VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### products
```sql
CREATE TABLE products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    product_name VARCHAR(150) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    category_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);
```

### customers
```sql
CREATE TABLE customers (
    id INT PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100),
    phone VARCHAR(20),
    address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### orders
```sql
CREATE TABLE orders (
    id INT PRIMARY KEY AUTO_INCREMENT,
    customer_id INT NOT NULL,
    order_date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE
);
```

### order_items
```sql
CREATE TABLE order_items (
    id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    price DECIMAL(10, 2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);
```

---

## Indexes

All indexes are automatically created by setup_database.sql:

```sql
CREATE INDEX idx_product_category ON products(category_id);
CREATE INDEX idx_order_customer ON orders(customer_id);
CREATE INDEX idx_orderitem_order ON order_items(order_id);
CREATE INDEX idx_orderitem_product ON order_items(product_id);
```

---

## Data Relationships

```
categories (1) ──────────────────┐
                                 │ FOREIGN KEY
                                 │ (category_id)
                                 ↓
                            products (Many)

customers (1) ────────────────────┐
                                  │ FOREIGN KEY
                                  │ (customer_id)
                                  ↓
                            orders (Many)

orders (1) ──────────────────┐     products (1) ──────┐
           │ FOREIGN KEY     │                        │ FOREIGN KEY
           │ (order_id)      │                        │ (product_id)
           ↓                 │                        ↓
      order_items ◄──────────────────────────────────
```

---

## Sample Data Queries

### Insert Sample Categories
```sql
INSERT INTO categories (category_name, description) VALUES
('Electronics', 'Electronic devices and gadgets'),
('Clothing', 'Apparel and fashion items'),
('Books', 'Educational and recreational books'),
('Home & Garden', 'Home and garden supplies');
```

### Insert Sample Products
```sql
INSERT INTO products (product_name, description, price, category_id) VALUES
('Laptop', 'High-performance laptop', 999.99, 1),
('Smartphone', '5G enabled smartphone', 799.99, 1),
('T-Shirt', 'Comfortable cotton t-shirt', 29.99, 2),
('Jeans', 'Blue denim jeans', 49.99, 2),
('Python Book', 'Learn Python Programming', 49.99, 3);
```

### Insert Sample Customers
```sql
INSERT INTO customers (first_name, last_name, email, phone, address) VALUES
('John', 'Doe', 'john@example.com', '555-0101', '123 Main St'),
('Jane', 'Smith', 'jane@example.com', '555-0102', '456 Oak Ave'),
('Bob', 'Johnson', 'bob@example.com', '555-0103', '789 Pine Rd');
```

---

## Maintenance Queries

### Check Database Size
```sql
SELECT table_name, ROUND(((data_length + index_length) / 1024 / 1024), 2) 
AS size_mb FROM information_schema.TABLES 
WHERE table_schema = 'maano_db';
```

### Count Total Records
```sql
SELECT 
  (SELECT COUNT(*) FROM categories) as categories,
  (SELECT COUNT(*) FROM products) as products,
  (SELECT COUNT(*) FROM customers) as customers,
  (SELECT COUNT(*) FROM orders) as orders,
  (SELECT COUNT(*) FROM order_items) as order_items;
```

### Backup Recommendations
- Regular backups of MySQL data directory
- Export database via phpMyAdmin
- Keep setup_database.sql as reference

---

For more information, refer to MySQL documentation: https://dev.mysql.com/doc/

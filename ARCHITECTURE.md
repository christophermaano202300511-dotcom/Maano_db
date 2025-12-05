# Maano Database - Visual Guides & Architecture

## 📊 Database Entity-Relationship Diagram (ERD)

```
┌─────────────────────┐
│    categories       │
├─────────────────────┤
│ id (PK)            │
│ category_name (U)  │
│ description        │
│ created_at         │
└────────┬────────────┘
         │ (1)
         │ has many
         │ (1:M)
         │
         ↓ (FK: category_id)
┌─────────────────────┐
│    products         │
├─────────────────────┤
│ id (PK)            │
│ product_name       │
│ description        │
│ price              │
│ category_id (FK)   │
│ created_at         │
└─────────────────────┘


┌─────────────────────┐
│    customers        │
├─────────────────────┤
│ id (PK)            │
│ first_name         │
│ last_name          │
│ email              │
│ phone              │
│ address            │
│ created_at         │
└────────┬────────────┘
         │ (1)
         │ places many
         │ (1:M)
         │
         ↓ (FK: customer_id)
┌─────────────────────┐
│     orders          │
├─────────────────────┤
│ id (PK)            │
│ customer_id (FK)   │
│ order_date         │
│ created_at         │
└────────┬────────────┘
         │ (1)
         │ contains many
         │ (1:M)
         │
         ↓ (FK: order_id)
┌──────────────────────────┐     ┌─────────────────────┐
│     order_items          │     │    products         │
├──────────────────────────┤     ├─────────────────────┤
│ id (PK)                 │     │ id (PK)            │
│ order_id (FK)           │◄────│ (referenced from)   │
│ product_id (FK) ────────┼────→│ product_id (FK)    │
│ quantity                │     │ price              │
│ price                   │     │ ...                │
│ created_at              │     │                    │
└──────────────────────────┘     └─────────────────────┘
```

---

## 🌳 File Structure Tree

```
Maano_db/
│
├── 📄 Core Files
│   ├── database.php               (MySQL Connection)
│   ├── style.css                  (Styling)
│   └── index.php                  (Main Products Page)
│
├── 📁 Category Management
│   ├── manage_categories.php       (View Categories)
│   ├── add_category.php           (Add Handler)
│   ├── edit_category.php          (Edit Form)
│   └── delete_category.php        (Delete Handler)
│
├── 📁 Product Management
│   ├── add_product.php            (Add Form)
│   ├── edit_product.php           (Edit Form)
│   └── delete_product.php         (Delete Handler)
│
├── 📁 Customer Management
│   ├── manage_customers.php       (View Customers)
│   ├── add_customer.php           (Add Handler)
│   ├── edit_customer.php          (Edit Form)
│   └── delete_customer.php        (Delete Handler)
│
├── 📁 Order Management
│   ├── view_orders.php            (View All Orders)
│   ├── create_order.php           (Create Form)
│   ├── view_order_details.php     (View Single Order)
│   └── delete_order.php           (Delete Handler)
│
├── 📊 Database
│   └── setup_database.sql         (DB Setup Script)
│
└── 📚 Documentation
    ├── README.md                  (Full Documentation)
    ├── QUICK_START.md             (Quick Reference)
    ├── TROUBLESHOOTING.md         (Problem Solving)
    ├── SQL_REFERENCE.md           (SQL Queries)
    ├── SETUP_COMPLETE.md          (Summary)
    └── ARCHITECTURE.md            (This File)
```

---

## 🔄 Application Flow

### Main Navigation
```
┌─────────────────────────────────────────────────────┐
│           📦 Maano Database System                   │
│   [Products] [Categories] [Customers] [Orders]      │
└─────────────────────────────────────────────────────┘

         ↓

    Choose Section
         ↓
    ┌────┴────┬────────┬──────────┬────────┐
    ↓         ↓        ↓          ↓        ↓
 Products Categories Customers  Orders  Add Product
```

### CRUD Operations Flow

#### CREATE Flow
```
Add Form
   ↓
User fills form
   ↓
Submit Form (POST)
   ↓
Validation
   ├─ Success → INSERT into DB → Redirect with Success Message
   └─ Error → Redisplay Form with Error Message
```

#### READ Flow
```
Page Load
   ↓
SELECT from DB (with JOINs)
   ↓
Display Results in Table
```

#### UPDATE Flow
```
Edit Link (with ID)
   ↓
SELECT Record (with ID)
   ↓
Display Form (prefilled)
   ↓
User modifies fields
   ↓
Submit Form (POST)
   ↓
UPDATE DB Record
   ↓
Redirect to List View
```

#### DELETE Flow
```
Delete Link (with ID)
   ↓
Confirmation Dialog
   ├─ Cancel → Stay on page
   └─ Confirm → DELETE from DB → Redirect
```

---

## 🗄️ JOIN Query Patterns Used

### Pattern 1: Simple JOIN (1:Many)
```
Table A (1) ──→ Table B (Many)
                  ↓
            SELECT *
            FROM TableB
            JOIN TableA ON TableB.fk = TableA.id

Example: Products with Categories
SELECT p.*, c.category_name
FROM products p
JOIN categories c ON p.category_id = c.id
```

### Pattern 2: LEFT JOIN with COUNT
```
Table A (1) ──→ Table B (Many)
                  ↓
            SELECT COUNT(*)
            FROM TableA
            LEFT JOIN TableB ON TableA.id = TableB.fk
            GROUP BY TableA.id

Example: Orders with Item Count
SELECT o.*, COUNT(oi.id) as item_count
FROM orders o
LEFT JOIN order_items oi ON o.id = oi.order_id
GROUP BY o.id
```

### Pattern 3: Multi-Table JOIN
```
Table A (1) ──→ Table B (Many) ──→ Table C (1)
                         ↓
            SELECT *
            FROM TableB
            JOIN TableA ON TableB.fk_a = TableA.id
            JOIN TableC ON TableB.fk_c = TableC.id

Example: Order Items with Products
SELECT oi.*, p.product_name, o.order_date
FROM order_items oi
JOIN products p ON oi.product_id = p.id
JOIN orders o ON oi.order_id = o.id
```

---

## 🔐 Security Architecture

```
┌─────────────────────────────────────────┐
│        USER INPUT (Untrusted)           │
└────────────────┬────────────────────────┘
                 │
                 ↓
         ┌───────────────────┐
         │  Input Validation │
         │  - Check type     │
         │  - Check range    │
         │  - Check format   │
         └────────┬──────────┘
                  │
                  ↓
         ┌───────────────────────────┐
         │ Prepared Statements (PHP) │
         │ - Parameter binding       │
         │ - No string concatenation │
         └────────┬──────────────────┘
                  │
                  ↓
         ┌──────────────────────┐
         │ MySQL Database       │
         │ (Query executed)     │
         └────────┬─────────────┘
                  │
                  ↓
         ┌──────────────────────┐
         │ Results Returned     │
         └────────┬─────────────┘
                  │
                  ↓
         ┌──────────────────────┐
         │ htmlspecialchars()   │
         │ (Output Escaping)    │
         └────────┬─────────────┘
                  │
                  ↓
         ┌─────────────────────┐
         │ Display to Browser  │
         │ (Safe HTML)         │
         └─────────────────────┘
```

---

## 📱 Page Load Sequence Diagram

```
User Opens Page
      ↓
Browser Requests PHP File
      ↓
┌─────────────────────────────────────┐
│  PHP Execution Phase                │
│  1. Load database.php               │
│  2. session_start()                 │
│  3. Process POST/GET requests       │
│  4. Execute SQL queries             │
│  5. Store results                   │
└─────────────────┬───────────────────┘
                  ↓
┌─────────────────────────────────────┐
│  HTML Generation Phase              │
│  1. Header section                  │
│  2. Navigation bar                  │
│  3. Form or Table                   │
│  4. Footer                          │
└─────────────────┬───────────────────┘
                  ↓
            Response Sent
                  ↓
         Browser Renders
                  ↓
         User Sees Page
```

---

## 🔄 Database Transaction Flow (Orders)

```
User clicks "Create Order"
         ↓
Load create_order.php
         ↓
Display Form (Customers, Products)
         ↓
User fills form + selects products
         ↓
Submit Form
         ↓
┌──────────────────────────────────┐
│  BEGIN TRANSACTION               │
│  (All-or-Nothing guarantee)      │
│  ↓                               │
│  1. Validate inputs              │
│  2. INSERT into orders table     │
│  3. Get inserted order_id        │
│  4. Loop through products        │
│  5. INSERT into order_items      │
│  6. For each item:               │
│     - Get product price          │
│     - Insert with quantity       │
│  7. All successful?              │
│     ├─ YES: COMMIT              │
│     └─ NO:  ROLLBACK            │
└──────────────────────────────────┘
         ↓
    Success/Error
         ↓
    Redirect + Message
         ↓
    User Sees Result
```

---

## 🌐 URL Routing

```
Base URL: http://localhost/maano_db/

Root Level:
  /index.php                    → Products list

Product Routes:
  /index.php                    → Display (CREATE, READ)
  /add_product.php              → Add form (CREATE)
  /edit_product.php?id=X        → Edit form (UPDATE)
  /delete_product.php?id=X      → Delete action (DELETE)

Category Routes:
  /manage_categories.php        → Display (CREATE, READ)
  /add_category.php             → Add handler (CREATE)
  /edit_category.php?id=X       → Edit form (UPDATE)
  /delete_category.php?id=X     → Delete action (DELETE)

Customer Routes:
  /manage_customers.php         → Display (CREATE, READ)
  /add_customer.php             → Add handler (CREATE)
  /edit_customer.php?id=X       → Edit form (UPDATE)
  /delete_customer.php?id=X     → Delete action (DELETE)

Order Routes:
  /view_orders.php              → All orders (READ with JOIN)
  /create_order.php             → Create order form (CREATE)
  /view_order_details.php?id=X  → Single order (READ with JOIN)
  /delete_order.php?id=X        → Delete action (DELETE)
```

---

## 💾 Data Flow in Forms

### Add/Edit Form Processing

```
HTTP REQUEST (GET or POST)
    ↓
┌────────────────────────────────────┐
│  If GET (Load Form)                │
│  - Retrieve existing data (if edit)│
│  - Display form HTML               │
│  - Prefill values (if edit)        │
│  - Return HTML to browser          │
└────────────────────────────────────┘
    OR
┌────────────────────────────────────┐
│  If POST (Submit Form)             │
│  - Get $_POST data                 │
│  - Validate all fields             │
│  - Check for errors                │
│  ├─ Error: Store in $_SESSION      │
│  │         Redirect back           │
│  └─ Success: Execute query         │
│             Store success message  │
│             Redirect to list       │
└────────────────────────────────────┘
    ↓
RESPONSE to Browser
```

---

## 🎨 UI Components Architecture

```
Header (Fixed)
├── Logo/Title
├── Navigation Bar
│   ├── Products
│   ├── Categories
│   ├── Customers
│   ├── Orders
│   └── + Add Product

Content Container
├── Messages (Success/Error/Info)
├── Main Content
│   ├── Forms
│   │   ├── Input Fields
│   │   ├── Selects/Dropdowns
│   │   ├── Textareas
│   │   └── Buttons
│   │
│   └── Tables
│       ├── Header Row
│       ├── Data Rows (with hover)
│       └── Action Buttons

Footer
└── Copyright

CSS Styling
├── Color Scheme
├── Typography
├── Spacing
├── Responsive Design
└── Interactive Elements
```

---

## 📊 State Management

### Session Usage

```php
// Error/Success Messages
$_SESSION['error']   = 'Error message';
$_SESSION['success'] = 'Success message';

// Flow:
// 1. Set message before redirect
// 2. Redirect to page
// 3. Page displays message
// 4. Unset message
// 5. Message disappears on next request
```

### Request Methods

```
GET Requests:
  - Fetch data to display
  - Pass ID for editing
  - Navigation between pages

POST Requests:
  - Submit forms
  - Create/Update/Delete operations
  - Sensitive data transfers
```

---

## ⚡ Performance Optimization

### Indexes
```sql
idx_product_category    → Speed up category lookups
idx_order_customer      → Speed up customer order lookups
idx_orderitem_order     → Speed up order item retrieval
idx_orderitem_product   → Speed up product lookups
```

### Query Optimization
- JOINs used instead of multiple queries
- Indexes on foreign keys
- GROUP BY for aggregations
- LIMIT for pagination (future)

---

## 🔍 Error Handling Layers

```
┌─────────────────────────────────────┐
│  Layer 1: Input Validation (PHP)    │
│  - Type checking                    │
│  - Length validation                │
│  - Format checking                  │
└──────────────┬──────────────────────┘
               ↓
┌─────────────────────────────────────┐
│  Layer 2: Database Constraints      │
│  - UNIQUE constraints               │
│  - NOT NULL constraints             │
│  - Foreign key constraints          │
│  - Data type validation             │
└──────────────┬──────────────────────┘
               ↓
┌─────────────────────────────────────┐
│  Layer 3: Application Logic         │
│  - Business rules                   │
│  - Cross-table validation           │
│  - Permission checks                │
└──────────────┬──────────────────────┘
               ↓
           Success or Error
           (Caught & Reported)
```

---

## 📈 Scalability Considerations

### Current Design Supports:
- ✓ Multiple users concurrently
- ✓ Thousands of products
- ✓ Thousands of orders
- ✓ Large result sets

### Future Improvements:
- [ ] Add pagination for large lists
- [ ] Add search/filter functionality
- [ ] Add user authentication
- [ ] Add audit logging
- [ ] Add caching layer
- [ ] Add API endpoints
- [ ] Add bulk operations

---

## 🎯 Design Patterns Used

1. **MVC-like Structure**
   - Database layer (database.php)
   - Logic layer (PHP handlers)
   - View layer (HTML output)

2. **CRUD Pattern**
   - Create form → Handler → List view
   - Read → Display with JOINs
   - Update form → Handler → List view
   - Delete → Handler → List view

3. **Template Pattern**
   - Common header navigation
   - Common footer
   - Consistent styling
   - Reusable message display

4. **Separation of Concerns**
   - Database connection separate
   - Styling separate (CSS file)
   - Business logic separate
   - Display logic separate

---

This comprehensive architecture ensures a scalable, maintainable, and secure database application!

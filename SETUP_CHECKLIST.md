# ✅ Maano Database Project - Setup Checklist

## 📋 Pre-Setup Requirements

### System Requirements
- [ ] Windows operating system
- [ ] XAMPP installed (or Apache + MySQL separately)
- [ ] PHP 7.0+ available
- [ ] MySQL 5.7+ available
- [ ] Modern web browser (Chrome, Firefox, Edge)
- [ ] Port 80 (Apache) available
- [ ] Port 3306 (MySQL) available

---

## 🔧 Installation Phase

### Step 1: Prepare Files
- [ ] Download/extract all project files
- [ ] Verify you have 26 files total (18 PHP + 1 SQL + 7 Docs)
- [ ] Check file names have no typos
- [ ] Ensure no files are corrupted

### Step 2: Place Files in XAMPP
- [ ] Locate XAMPP installation directory
- [ ] Navigate to `htdocs` folder
- [ ] Create new folder: `maano_db`
- [ ] Copy ALL 26 files into `maano_db` folder
- [ ] Verify path: `C:\xampp\htdocs\maano_db\`
- [ ] Verify all files copied correctly

### Step 3: Start XAMPP Services
- [ ] Open XAMPP Control Panel
- [ ] Click "Start" for Apache module
- [ ] Wait for Apache to show "Running" (green)
- [ ] Click "Start" for MySQL module
- [ ] Wait for MySQL to show "Running" (green)
- [ ] Both services should be green before proceeding

---

## 🗄️ Database Setup Phase

### Step 4: Create Database
#### Option A: Using phpMyAdmin (Recommended)
- [ ] Open web browser
- [ ] Go to: http://localhost/phpmyadmin/
- [ ] Verify page loads successfully
- [ ] Locate "SQL" tab in top menu
- [ ] Open `setup_database.sql` file in text editor
- [ ] Copy entire contents of file
- [ ] Paste into phpMyAdmin SQL query box
- [ ] Click "Go" button
- [ ] Check for success message

#### Option B: Using Command Line
- [ ] Open Command Prompt
- [ ] Navigate to: `C:\xampp\mysql\bin`
- [ ] Type: `mysql -u root -p`
- [ ] Press Enter (password is empty)
- [ ] Open `setup_database.sql` in text editor
- [ ] Copy entire contents
- [ ] Paste into MySQL command line
- [ ] Verify successful execution

### Step 5: Verify Database Created
- [ ] In phpMyAdmin, look for `maano_db` database
- [ ] Click on `maano_db`
- [ ] Verify these tables exist:
  - [ ] categories
  - [ ] products
  - [ ] customers
  - [ ] orders
  - [ ] order_items
- [ ] Verify sample data exists (3 categories, 3 products, 2 customers)

---

## 🔐 Configuration Phase

### Step 6: Verify Database Connection
- [ ] Open `database.php` in text editor
- [ ] Check credentials:
  - [ ] `$servername = "localhost"` ✓
  - [ ] `$username = "root"` ✓
  - [ ] `$password = ""` (empty) ✓
  - [ ] `$database = "maano_db"` ✓
- [ ] NO changes needed (defaults are correct)
- [ ] Save file (no changes)

---

## 🌐 Application Access Phase

### Step 7: Test Application Access
- [ ] Open web browser
- [ ] Navigate to: http://localhost/maano_db/
- [ ] Verify page loads (not 404 error)
- [ ] Verify header displays "📦 Maano Database System"
- [ ] Verify navigation bar shows 4 links:
  - [ ] Products
  - [ ] Categories
  - [ ] Customers
  - [ ] Orders
- [ ] Verify "0 results" or sample data displays

### Step 8: Test Each Section
#### Products Page
- [ ] Click "Products" link
- [ ] Verify products display (if data exists)
- [ ] Verify category names show (JOIN working)
- [ ] See "+ Add Product" button

#### Categories Page
- [ ] Click "Categories" link
- [ ] Verify categories display
- [ ] See form to add new category
- [ ] See Edit/Delete buttons

#### Customers Page
- [ ] Click "Customers" link
- [ ] Verify customers display (if data exists)
- [ ] See form to add new customer
- [ ] See Edit/Delete buttons

#### Orders Page
- [ ] Click "Orders" link
- [ ] Verify orders display (if data exists)
- [ ] Verify customer names show (JOIN working)
- [ ] See "+ Create New Order" button

---

## ✨ Functionality Testing Phase

### Step 9: Test CRUD Operations

#### CREATE - Add New Data
- [ ] Go to Categories page
- [ ] Click "Add New Category"
- [ ] Enter category name: "Test Category"
- [ ] Enter description: "Test Description"
- [ ] Click "Add Category"
- [ ] Verify success message shows
- [ ] Verify new category appears in list

#### CREATE - Add Product
- [ ] Go to "+ Add Product"
- [ ] Enter product name: "Test Product"
- [ ] Enter description: "Test"
- [ ] Enter price: 99.99
- [ ] Select category: "Test Category"
- [ ] Click "Add Product"
- [ ] Verify success message
- [ ] Verify product appears with category name

#### CREATE - Add Customer
- [ ] Go to Customers page
- [ ] Enter first name: "Test"
- [ ] Enter last name: "User"
- [ ] Enter email: "test@example.com"
- [ ] Enter phone: "555-0123"
- [ ] Enter address: "123 Test St"
- [ ] Click "Add Customer"
- [ ] Verify success message
- [ ] Verify customer appears in list

#### CREATE - Create Order
- [ ] Go to Orders page
- [ ] Click "+ Create New Order"
- [ ] Select customer: "Test User"
- [ ] Set order date: today
- [ ] Select product: "Test Product"
- [ ] Enter quantity: 2
- [ ] Click "Create Order"
- [ ] Verify success message
- [ ] Verify order appears in list

#### READ - View with JOINs
- [ ] Go to Products page
- [ ] Verify category names display (not just IDs)
- [ ] Go to Orders page
- [ ] Verify customer names display (not just IDs)
- [ ] Click "View" on an order
- [ ] Verify product names display (not just IDs)
- [ ] Verify order total calculates correctly

#### UPDATE - Edit Data
- [ ] Go to Products page
- [ ] Click "Edit" on "Test Product"
- [ ] Change price to 149.99
- [ ] Click "Update Product"
- [ ] Verify success message
- [ ] Verify new price displays

#### UPDATE - Edit Category
- [ ] Go to Categories page
- [ ] Click "Edit" on "Test Category"
- [ ] Change name to "Modified Category"
- [ ] Click "Update Category"
- [ ] Verify success message
- [ ] Verify new name displays

#### UPDATE - Edit Customer
- [ ] Go to Customers page
- [ ] Click "Edit" on "Test User"
- [ ] Change email to "newemail@example.com"
- [ ] Click "Update Customer"
- [ ] Verify success message
- [ ] Verify new email displays

#### DELETE - Remove Data
- [ ] Go to Products page
- [ ] Click "Delete" on "Test Product"
- [ ] Confirm deletion in dialog
- [ ] Verify success message
- [ ] Verify product removed from list

- [ ] Go to Orders page
- [ ] Click "Delete" on test order
- [ ] Confirm deletion
- [ ] Verify success message
- [ ] Verify order removed

- [ ] Go to Customers page
- [ ] Click "Delete" on "Test User"
- [ ] Confirm deletion
- [ ] Verify success message
- [ ] Verify customer removed

#### DELETE - Category (with validation)
- [ ] Go to Categories page
- [ ] Try to delete a category with products
- [ ] Verify error message appears
- [ ] Verify category NOT deleted

---

## 🎨 UI & Styling Phase

### Step 10: Verify Appearance
- [ ] Verify header has gradient background
- [ ] Verify navigation bar is styled
- [ ] Verify tables have proper formatting
- [ ] Verify forms have proper styling
- [ ] Verify buttons are styled
- [ ] Verify success messages are green
- [ ] Verify error messages are red
- [ ] Verify responsive design (resize browser)

---

## 📱 Responsive Design Phase

### Step 11: Test Responsive Design
- [ ] Test on desktop (normal size)
- [ ] Resize browser window to tablet size
- [ ] Verify layout adapts
- [ ] Resize browser window to mobile size
- [ ] Verify layout still works
- [ ] Test navigation on mobile size

---

## 🔍 Error Handling Phase

### Step 12: Test Error Scenarios
#### Invalid Input
- [ ] Try to add product without name
- [ ] Verify error message shows
- [ ] Try to add with invalid price
- [ ] Verify error message shows

#### Duplicate Data
- [ ] Try to add category with existing name
- [ ] Verify error message shows

#### Delete Validation
- [ ] Try to delete category with products
- [ ] Verify prevents deletion
- [ ] Verify error message shows

#### Cascade Deletes
- [ ] Delete order
- [ ] Verify order items deleted too
- [ ] Delete category with no products
- [ ] Verify deletion allowed

---

## 🧪 Advanced Testing Phase

### Step 13: Test Advanced Features
#### Multi-item Orders
- [ ] Create order with multiple products
- [ ] Verify all items display
- [ ] Verify total calculates correctly
- [ ] Verify all relationships display

#### Transaction Integrity
- [ ] Create complex order
- [ ] Verify data consistency
- [ ] Check no partial data exists

#### Navigation Consistency
- [ ] Test all links work
- [ ] Test back/cancel buttons
- [ ] Test all pages accessible
- [ ] Verify no broken links

---

## 📊 Data Verification Phase

### Step 14: Verify Data Integrity
- [ ] Check phpMyAdmin for correct data
- [ ] Verify foreign key relationships
- [ ] Verify no orphaned records
- [ ] Verify timestamps on records
- [ ] Verify calculations are correct

---

## 📚 Documentation Phase

### Step 15: Documentation Review
- [ ] README.md exists and readable
- [ ] QUICK_START.md exists and readable
- [ ] TROUBLESHOOTING.md exists
- [ ] SQL_REFERENCE.md exists
- [ ] ARCHITECTURE.md exists
- [ ] INDEX.md exists
- [ ] All markdown files have links

---

## 🚀 Pre-Launch Phase

### Step 16: Final Verification
- [ ] All 26 files present in folder
- [ ] All PHP files working
- [ ] All CSS loaded
- [ ] All database operations working
- [ ] All CRUD operations tested
- [ ] Error handling verified
- [ ] Responsive design works
- [ ] Documentation complete

---

## ✅ Completion Checklist

### All Systems Go!
- [ ] XAMPP services running
- [ ] Database created and populated
- [ ] All files in correct location
- [ ] Application loads in browser
- [ ] All pages accessible
- [ ] All CRUD operations working
- [ ] All JOINs returning correct data
- [ ] Error messages display properly
- [ ] No broken links or 404s
- [ ] Styling displays correctly
- [ ] Mobile responsive
- [ ] Documentation accessible

---

## 🎯 Success Criteria

Your setup is complete when:
✅ You can access http://localhost/maano_db/
✅ You see the Maano Database System header
✅ Navigation bar shows all 4 sections
✅ You can add a category
✅ You can add a product with category selection
✅ You can add a customer
✅ You can create an order
✅ You can view products with category names (JOIN)
✅ You can view orders with customer names (JOIN)
✅ All edit and delete operations work
✅ Error messages appear for invalid input

---

## 🐛 Troubleshooting Quick Links

If something doesn't work:

| Issue | Check |
|-------|-------|
| Page won't load | Services running? Files copied? |
| 404 errors | Files in right folder? |
| Blank pages | Database created? CSS loaded? |
| No data | Database populated? Tables exist? |
| Errors on submit | Check error message, refer to TROUBLESHOOTING.md |
| JOINs not working | Database relationships set up? |
| Can't add categories | MySQL running? Permissions? |

---

## 📞 Support Resources

### Quick Help
1. Check [TROUBLESHOOTING.md](TROUBLESHOOTING.md)
2. Check [INDEX.md](INDEX.md) for documentation
3. Check browser console (F12)
4. Check XAMPP error logs

### Files to Reference
- [README.md](README.md) - Complete setup guide
- [QUICK_START.md](QUICK_START.md) - Quick reference
- [SQL_REFERENCE.md](SQL_REFERENCE.md) - Database queries
- [ARCHITECTURE.md](ARCHITECTURE.md) - System design

---

## 📝 Notes Section

Use this space to record your setup:

```
Date Setup Started: _________________
Date Setup Completed: _________________
Any Issues Encountered: _________________
Solutions Applied: _________________
Custom Modifications Made: _________________
Additional Notes: _________________
```

---

## 🎉 You're Ready!

Congratulations! You have successfully set up the Maano Database Project with:

✅ Complete CRUD functionality
✅ SQL JOIN operations
✅ Professional UI with styling
✅ Security best practices
✅ Complete documentation
✅ Error handling
✅ Database relationships

**Now go explore, build, and learn!** 🚀

---

**Checklist Version: 1.0**
**Last Updated: December 6, 2025**
**Project: Maano Database System**

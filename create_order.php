<?php
session_start();
include 'database.php';

// Fetch customers for dropdown
$cust_query = "SELECT id, first_name, last_name FROM customers ORDER BY first_name ASC";
$cust_result = $conn->query($cust_query);

// Fetch products for order items
$prod_query = "SELECT p.id, p.product_name, p.price FROM products p ORDER BY p.product_name ASC";
$prod_result = $conn->query($prod_query);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customer_id = intval($_POST['customer_id']);
    $order_date = $_POST['order_date'];
    $product_ids = isset($_POST['product_ids']) ? $_POST['product_ids'] : [];
    $quantities = isset($_POST['quantities']) ? $_POST['quantities'] : [];

    if (empty($customer_id) || empty($order_date)) {
        $_SESSION['error'] = 'Please select customer and order date.';
    } else {
        // Start transaction
        $conn->begin_transaction();

        try {
            // Insert order
            $insert_order = "INSERT INTO orders (customer_id, order_date) VALUES (?, ?)";
            $stmt = $conn->prepare($insert_order);
            $stmt->bind_param("is", $customer_id, $order_date);
            $stmt->execute();
            $order_id = $conn->insert_id;

            // Insert order items
            $insert_item = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($insert_item);

            $has_items = false;
            foreach ($product_ids as $index => $product_id) {
                if (!empty($product_id) && isset($quantities[$index]) && $quantities[$index] > 0) {
                    // Get product price
                    $price_query = "SELECT price FROM products WHERE id = ?";
                    $price_stmt = $conn->prepare($price_query);
                    $price_stmt->bind_param("i", $product_id);
                    $price_stmt->execute();
                    $price_result = $price_stmt->get_result();
                    $price_row = $price_result->fetch_assoc();
                    $price = $price_row['price'];
                    $quantity = intval($quantities[$index]);

                    $stmt->bind_param("iiii", $order_id, $product_id, $quantity, $price);
                    $stmt->execute();
                    $has_items = true;
                }
            }

            if (!$has_items) {
                throw new Exception('Order must contain at least one item.');
            }

            $conn->commit();
            $_SESSION['success'] = 'Order created successfully!';
            header('Location: view_orders.php');
            exit();
        } catch (Exception $e) {
            $conn->rollback();
            $_SESSION['error'] = 'Error creating order: ' . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Order</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .order-item {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 10px;
            margin-bottom: 15px;
            padding: 15px;
            background-color: #f0f0f0;
            border-radius: 5px;
        }
        .add-item-btn {
            background-color: #27ae60;
            margin-top: 10px;
        }
        .add-item-btn:hover {
            background-color: #229954;
        }
        .remove-item-btn {
            background-color: #e74c3c;
            padding: 8px 15px;
        }
        .remove-item-btn:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>
    <header>
        <h1>📦 Maano Database System</h1>
        <nav>
            <a href="index.php">Products</a>
            <a href="manage_categories.php">Categories</a>
            <a href="manage_customers.php">Customers</a>
            <a href="view_orders.php">Orders</a>
            <a href="add_product.php">+ Add Product</a>
        </nav>
    </header>

    <div class="container">
        <div class="content">
            <h2>Create New Order</h2>

            <?php 
            if (isset($_SESSION['error'])) {
                echo '<div class="error">' . $_SESSION['error'] . '</div>';
                unset($_SESSION['error']);
            }
            ?>

            <form method="POST">
                <label for="customer_id">Customer:</label>
                <select id="customer_id" name="customer_id" required>
                    <option value="">-- Select a Customer --</option>
                    <?php
                    if ($cust_result->num_rows > 0) {
                        while ($cust = $cust_result->fetch_assoc()) {
                            $full_name = htmlspecialchars($cust['first_name'] . ' ' . $cust['last_name']);
                            echo '<option value="' . $cust['id'] . '">' . $full_name . '</option>';
                        }
                    }
                    ?>
                </select>

                <label for="order_date">Order Date:</label>
                <input type="date" id="order_date" name="order_date" value="<?php echo date('Y-m-d'); ?>" required>

                <h3>Add Items to Order</h3>
                <div id="order-items">
                    <div class="order-item">
                        <div>
                            <label>Product:</label>
                            <select name="product_ids[]" class="product-select">
                                <option value="">-- Select Product --</option>
                                <?php
                                $prod_result->data_seek(0); // Reset result pointer
                                while ($prod = $prod_result->fetch_assoc()) {
                                    echo '<option value="' . $prod['id'] . '">' . htmlspecialchars($prod['product_name']) . ' ($' . number_format($prod['price'], 2) . ')</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div>
                            <label>Quantity:</label>
                            <input type="number" name="quantities[]" min="1" placeholder="Qty">
                        </div>
                        <div>
                            <label>&nbsp;</label>
                            <button type="button" class="remove-item-btn" onclick="removeItem(this)">Remove</button>
                        </div>
                    </div>
                </div>

                <button type="button" class="add-item-btn" onclick="addItem()">+ Add Another Item</button>

                <div style="margin-top: 20px;">
                    <button type="submit">Create Order</button>
                    <a href="view_orders.php" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function addItem() {
            const container = document.getElementById('order-items');
            const newItem = document.querySelector('.order-item').cloneNode(true);
            
            // Reset values
            newItem.querySelector('select').value = '';
            newItem.querySelector('input[type="number"]').value = '';
            
            container.appendChild(newItem);
        }

        function removeItem(button) {
            const items = document.querySelectorAll('.order-item');
            if (items.length > 1) {
                button.closest('.order-item').remove();
            } else {
                alert('You must have at least one item.');
            }
        }
    </script>

    <footer>
        <p>&copy; 2025 Maano Database System. All rights reserved.</p>
    </footer>
</body>
</html>

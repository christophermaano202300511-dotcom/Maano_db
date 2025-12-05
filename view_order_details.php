<?php
session_start();
include 'database.php';

// Get order ID from URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error'] = 'Invalid order ID.';
    header('Location: view_orders.php');
    exit();
}

$order_id = intval($_GET['id']);

// Fetch order with customer details using JOIN
$query = "SELECT o.id, o.order_date, c.first_name, c.last_name, c.email, c.phone
          FROM orders o
          JOIN customers c ON o.customer_id = c.id
          WHERE o.id = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$order_result = $stmt->get_result();

if ($order_result->num_rows == 0) {
    $_SESSION['error'] = 'Order not found.';
    header('Location: view_orders.php');
    exit();
}

$order = $order_result->fetch_assoc();

// Fetch order items with product details using JOIN
$items_query = "SELECT oi.id, p.product_name, oi.quantity, oi.price, (oi.quantity * oi.price) as subtotal
                FROM order_items oi
                JOIN products p ON oi.product_id = p.id
                WHERE oi.order_id = ?
                ORDER BY p.product_name ASC";

$items_stmt = $conn->prepare($items_query);
$items_stmt->bind_param("i", $order_id);
$items_stmt->execute();
$items_result = $items_stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .order-summary {
            background-color: #f0f0f0;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .order-summary div {
            margin-bottom: 10px;
        }
        .order-summary strong {
            display: inline-block;
            width: 150px;
        }
        .total-row {
            font-weight: bold;
            font-size: 1.1em;
            background-color: #667eea;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
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
            <h2>Order #<?php echo $order['id']; ?> Details</h2>

            <div class="order-summary">
                <div>
                    <strong>Order Date:</strong> <?php echo date('M d, Y', strtotime($order['order_date'])); ?>
                </div>
                <div>
                    <strong>Customer:</strong> <?php echo htmlspecialchars($order['first_name'] . ' ' . $order['last_name']); ?>
                </div>
                <div>
                    <strong>Email:</strong> <?php echo htmlspecialchars($order['email'] ?? 'N/A'); ?>
                </div>
                <div>
                    <strong>Phone:</strong> <?php echo htmlspecialchars($order['phone'] ?? 'N/A'); ?>
                </div>
            </div>

            <h3>Order Items</h3>
            <?php
            if ($items_result->num_rows > 0) {
                echo '<table>';
                echo '<thead>';
                echo '<tr>';
                echo '<th>Product Name</th>';
                echo '<th>Unit Price</th>';
                echo '<th>Quantity</th>';
                echo '<th>Subtotal</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';

                $total = 0;
                while ($item = $items_result->fetch_assoc()) {
                    $subtotal = $item['subtotal'];
                    $total += $subtotal;
                    
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($item['product_name']) . '</td>';
                    echo '<td>$' . number_format($item['price'], 2) . '</td>';
                    echo '<td>' . $item['quantity'] . '</td>';
                    echo '<td>$' . number_format($subtotal, 2) . '</td>';
                    echo '</tr>';
                }

                echo '<tr><td colspan="4" class="total-row">Total: $' . number_format($total, 2) . '</td></tr>';
                echo '</tbody>';
                echo '</table>';
            } else {
                echo '<div class="info">No items in this order.</div>';
            }
            ?>

            <div style="margin-top: 20px;">
                <a href="view_orders.php" class="btn btn-secondary">Back to Orders</a>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 Maano Database System. All rights reserved.</p>
    </footer>
</body>
</html>

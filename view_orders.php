<?php
session_start();
include 'database.php';

$message = '';
if (isset($_SESSION['success'])) {
    $message = '<div class="success">' . $_SESSION['success'] . '</div>';
    unset($_SESSION['success']);
}

// Fetch all orders with customer names using JOIN
$query = "SELECT o.id, o.order_date, c.first_name, c.last_name, COUNT(oi.id) as item_count, SUM(oi.quantity * oi.price) as total
          FROM orders o
          JOIN customers c ON o.customer_id = c.id
          LEFT JOIN order_items oi ON o.id = oi.order_id
          GROUP BY o.id
          ORDER BY o.order_date DESC";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Orders</title>
    <link rel="stylesheet" href="style.css">
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
            <h2>Orders</h2>
            
            <?php echo $message; ?>

            <div>
                <a href="create_order.php" class="btn" style="margin-bottom: 20px;">+ Create New Order</a>
            </div>

            <?php
            if ($result->num_rows > 0) {
                echo '<table>';
                echo '<thead>';
                echo '<tr>';
                echo '<th>Order ID</th>';
                echo '<th>Customer Name</th>';
                echo '<th>Order Date</th>';
                echo '<th>Items</th>';
                echo '<th>Total</th>';
                echo '<th>Actions</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';

                while ($row = $result->fetch_assoc()) {
                    $customer_name = htmlspecialchars($row['first_name'] . ' ' . $row['last_name']);
                    echo '<tr>';
                    echo '<td>#' . $row['id'] . '</td>';
                    echo '<td>' . $customer_name . '</td>';
                    echo '<td>' . date('M d, Y', strtotime($row['order_date'])) . '</td>';
                    echo '<td>' . ($row['item_count'] ?? 0) . '</td>';
                    echo '<td>$' . number_format($row['total'] ?? 0, 2) . '</td>';
                    echo '<td class="actions">';
                    echo '<a href="view_order_details.php?id=' . $row['id'] . '" class="btn btn-edit">View</a>';
                    echo '<a href="delete_order.php?id=' . $row['id'] . '" class="btn btn-delete" onclick="return confirm(\'Are you sure?\');">Delete</a>';
                    echo '</td>';
                    echo '</tr>';
                }

                echo '</tbody>';
                echo '</table>';
            } else {
                echo '<div class="info">No orders found. <a href="create_order.php">Create your first order</a></div>';
            }
            ?>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 Maano Database System. All rights reserved.</p>
    </footer>
</body>
</html>

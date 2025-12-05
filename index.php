<?php
session_start();
include 'database.php';

$message = '';
if (isset($_SESSION['success'])) {
    $message = '<div class="success">' . $_SESSION['success'] . '</div>';
    unset($_SESSION['success']);
}
if (isset($_SESSION['error'])) {
    $message = '<div class="error">' . $_SESSION['error'] . '</div>';
    unset($_SESSION['error']);
}


$query = "SELECT p.id, p.product_name, p.description, p.price, c.category_name 
          FROM products p
          JOIN categories c ON p.category_id = c.id
          ORDER BY p.product_name ASC";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maano Database - Products</title>
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
            <a href="add_product.php" style="background-color: rgba(255,255,255,0.2);">+ Add Product</a>
        </nav>
    </header>

    <div class="container">
        <div class="content">
            <h2>Products List</h2>
            
            <?php echo $message; ?>

            <?php
            if ($result->num_rows > 0) {
                echo '<table>';
                echo '<thead>';
                echo '<tr>';
                echo '<th>Product Name</th>';
                echo '<th>Category</th>';
                echo '<th>Description</th>';
                echo '<th>Price</th>';
                echo '<th>Actions</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';

                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row['product_name']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['category_name']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['description']) . '</td>';
                    echo '<td>$' . number_format($row['price'], 2) . '</td>';
                    echo '<td class="actions">';
                    echo '<a href="edit_product.php?id=' . $row['id'] . '" class="btn btn-edit">Edit</a>';
                    echo '<a href="delete_product.php?id=' . $row['id'] . '" class="btn btn-delete" onclick="return confirm(\'Are you sure?\');">Delete</a>';
                    echo '</td>';
                    echo '</tr>';
                }

                echo '</tbody>';
                echo '</table>';
            } else {
                echo '<div class="info">No products found. <a href="add_product.php">Add your first product</a></div>';
            }
            ?>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 Maano Database System. All rights reserved.</p>
    </footer>
</body>
</html>

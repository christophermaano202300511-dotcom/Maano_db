<?php
session_start();
include 'database.php';

$message = '';
if (isset($_SESSION['success'])) {
    $message = '<div class="success">' . $_SESSION['success'] . '</div>';
    unset($_SESSION['success']);
}

// Fetch all categories
$query = "SELECT * FROM categories ORDER BY category_name ASC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Categories</title>
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
            <h2>Manage Categories</h2>
            
            <?php echo $message; ?>

            <h3>Add New Category</h3>
            <form method="POST" action="add_category.php">
                <label for="category_name">Category Name:</label>
                <input type="text" id="category_name" name="category_name" required placeholder="Enter category name">
                
                <label for="description">Description:</label>
                <textarea id="description" name="description" placeholder="Enter category description"></textarea>
                
                <button type="submit">Add Category</button>
            </form>

            <h3>Categories List</h3>
            <?php
            if ($result->num_rows > 0) {
                echo '<table>';
                echo '<thead>';
                echo '<tr>';
                echo '<th>Category Name</th>';
                echo '<th>Description</th>';
                echo '<th>Actions</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';

                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row['category_name']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['description'] ?? '') . '</td>';
                    echo '<td class="actions">';
                    echo '<a href="edit_category.php?id=' . $row['id'] . '" class="btn btn-edit">Edit</a>';
                    echo '<a href="delete_category.php?id=' . $row['id'] . '" class="btn btn-delete" onclick="return confirm(\'Are you sure?\');">Delete</a>';
                    echo '</td>';
                    echo '</tr>';
                }

                echo '</tbody>';
                echo '</table>';
            } else {
                echo '<div class="info">No categories found. Add your first category above.</div>';
            }
            ?>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 Maano Database System. All rights reserved.</p>
    </footer>
</body>
</html>

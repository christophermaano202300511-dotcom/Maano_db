<?php
session_start();
include 'database.php';

// Fetch categories for dropdown
$cat_query = "SELECT id, category_name FROM categories ORDER BY category_name ASC";
$cat_result = $conn->query($cat_query);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_name = trim($_POST['product_name']);
    $description = trim($_POST['description']);
    $price = floatval($_POST['price']);
    $category_id = intval($_POST['category_id']);

    if (empty($product_name) || empty($category_id) || $price <= 0) {
        $_SESSION['error'] = 'Please fill all fields correctly.';
    } else {
        // Insert new product
        $insert_query = "INSERT INTO products (product_name, description, price, category_id) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("ssdi", $product_name, $description, $price, $category_id);

        if ($stmt->execute()) {
            $_SESSION['success'] = 'Product added successfully!';
            header('Location: index.php');
            exit();
        } else {
            $_SESSION['error'] = 'Error adding product: ' . $stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
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
            <h2>Add New Product</h2>

            <?php 
            if (isset($_SESSION['error'])) {
                echo '<div class="error">' . $_SESSION['error'] . '</div>';
                unset($_SESSION['error']);
            }
            ?>

            <form method="POST">
                <label for="product_name">Product Name:</label>
                <input type="text" id="product_name" name="product_name" required placeholder="Enter product name">

                <label for="description">Description:</label>
                <textarea id="description" name="description" placeholder="Enter product description"></textarea>

                <label for="price">Price ($):</label>
                <input type="number" id="price" name="price" step="0.01" min="0" required placeholder="Enter price">

                <label for="category_id">Category:</label>
                <select id="category_id" name="category_id" required>
                    <option value="">-- Select a Category --</option>
                    <?php
                    if ($cat_result->num_rows > 0) {
                        while ($cat = $cat_result->fetch_assoc()) {
                            echo '<option value="' . $cat['id'] . '">' . htmlspecialchars($cat['category_name']) . '</option>';
                        }
                    } else {
                        echo '<option value="">No categories available</option>';
                    }
                    ?>
                </select>

                <div>
                    <button type="submit">Add Product</button>
                    <a href="index.php" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 Maano Database System. All rights reserved.</p>
    </footer>
</body>
</html>

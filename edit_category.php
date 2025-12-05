<?php
session_start();
include 'database.php';

// Get category ID from URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error'] = 'Invalid category ID.';
    header('Location: manage_categories.php');
    exit();
}

$category_id = intval($_GET['id']);

// Fetch category data
$query = "SELECT * FROM categories WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $category_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    $_SESSION['error'] = 'Category not found.';
    header('Location: manage_categories.php');
    exit();
}

$category = $result->fetch_assoc();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category_name = trim($_POST['category_name']);
    $description = trim($_POST['description']);

    if (empty($category_name)) {
        $_SESSION['error'] = 'Category name cannot be empty.';
    } else {
        // Update category
        $update_query = "UPDATE categories SET category_name = ?, description = ? WHERE id = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("ssi", $category_name, $description, $category_id);

        if ($stmt->execute()) {
            $_SESSION['success'] = 'Category updated successfully!';
            header('Location: manage_categories.php');
            exit();
        } else {
            $_SESSION['error'] = 'Error updating category: ' . $stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category</title>
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
            <h2>Edit Category</h2>

            <form method="POST">
                <label for="category_name">Category Name:</label>
                <input type="text" id="category_name" name="category_name" value="<?php echo htmlspecialchars($category['category_name']); ?>" required>

                <label for="description">Description:</label>
                <textarea id="description" name="description"><?php echo htmlspecialchars($category['description'] ?? ''); ?></textarea>

                <div>
                    <button type="submit">Update Category</button>
                    <a href="manage_categories.php" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 Maano Database System. All rights reserved.</p>
    </footer>
</body>
</html>

<?php
session_start();
include 'database.php';

// Get product ID from URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error'] = 'Invalid product ID.';
    header('Location: index.php');
    exit();
}

$product_id = intval($_GET['id']);

// Delete product
$delete_query = "DELETE FROM products WHERE id = ?";
$stmt = $conn->prepare($delete_query);
$stmt->bind_param("i", $product_id);

if ($stmt->execute()) {
    $_SESSION['success'] = 'Product deleted successfully!';
} else {
    $_SESSION['error'] = 'Error deleting product: ' . $stmt->error;
}

header('Location: index.php');
exit();
?>

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

// Check if there are products in this category
$check_query = "SELECT COUNT(*) as count FROM products WHERE category_id = ?";
$stmt = $conn->prepare($check_query);
$stmt->bind_param("i", $category_id);
$stmt->execute();
$check_result = $stmt->get_result();
$check_row = $check_result->fetch_assoc();

if ($check_row['count'] > 0) {
    $_SESSION['error'] = 'Cannot delete category with existing products. Delete products first.';
} else {
    // Delete category
    $delete_query = "DELETE FROM categories WHERE id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $category_id);

    if ($stmt->execute()) {
        $_SESSION['success'] = 'Category deleted successfully!';
    } else {
        $_SESSION['error'] = 'Error deleting category: ' . $stmt->error;
    }
}

header('Location: manage_categories.php');
exit();
?>

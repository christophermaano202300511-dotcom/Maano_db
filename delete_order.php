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

// Start transaction
$conn->begin_transaction();

try {
    // Delete order items first (foreign key constraint)
    $delete_items = "DELETE FROM order_items WHERE order_id = ?";
    $stmt = $conn->prepare($delete_items);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();

    // Delete order
    $delete_order = "DELETE FROM orders WHERE id = ?";
    $stmt = $conn->prepare($delete_order);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();

    $conn->commit();
    $_SESSION['success'] = 'Order deleted successfully!';
} catch (Exception $e) {
    $conn->rollback();
    $_SESSION['error'] = 'Error deleting order: ' . $e->getMessage();
}

header('Location: view_orders.php');
exit();
?>

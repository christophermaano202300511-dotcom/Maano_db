<?php
session_start();
include 'database.php';

// Get customer ID from URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error'] = 'Invalid customer ID.';
    header('Location: manage_customers.php');
    exit();
}

$customer_id = intval($_GET['id']);

// Delete customer
$delete_query = "DELETE FROM customers WHERE id = ?";
$stmt = $conn->prepare($delete_query);
$stmt->bind_param("i", $customer_id);

if ($stmt->execute()) {
    $_SESSION['success'] = 'Customer deleted successfully!';
} else {
    $_SESSION['error'] = 'Error deleting customer: ' . $stmt->error;
}

header('Location: manage_customers.php');
exit();
?>

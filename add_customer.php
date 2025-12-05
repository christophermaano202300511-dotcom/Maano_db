<?php
session_start();
include 'database.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);

    if (empty($first_name) || empty($last_name)) {
        $_SESSION['error'] = 'First name and last name are required.';
    } else {
        // Insert new customer
        $insert_query = "INSERT INTO customers (first_name, last_name, email, phone, address) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("sssss", $first_name, $last_name, $email, $phone, $address);

        if ($stmt->execute()) {
            $_SESSION['success'] = 'Customer added successfully!';
        } else {
            $_SESSION['error'] = 'Error adding customer: ' . $stmt->error;
        }
    }

    header('Location: manage_customers.php');
    exit();
}
?>

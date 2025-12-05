<?php
session_start();
include 'database.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category_name = trim($_POST['category_name']);
    $description = trim($_POST['description']);

    if (empty($category_name)) {
        $_SESSION['error'] = 'Category name cannot be empty.';
    } else {
        // Check if category already exists
        $check_query = "SELECT id FROM categories WHERE category_name = ?";
        $stmt = $conn->prepare($check_query);
        $stmt->bind_param("s", $category_name);
        $stmt->execute();
        $check_result = $stmt->get_result();

        if ($check_result->num_rows > 0) {
            $_SESSION['error'] = 'This category already exists.';
        } else {
            // Insert new category
            $insert_query = "INSERT INTO categories (category_name, description) VALUES (?, ?)";
            $stmt = $conn->prepare($insert_query);
            $stmt->bind_param("ss", $category_name, $description);

            if ($stmt->execute()) {
                $_SESSION['success'] = 'Category added successfully!';
            } else {
                $_SESSION['error'] = 'Error adding category: ' . $stmt->error;
            }
        }
    }

    header('Location: manage_categories.php');
    exit();
}
?>

<?php
session_start();
include 'database.php';

$message = '';
if (isset($_SESSION['success'])) {
    $message = '<div class="success">' . $_SESSION['success'] . '</div>';
    unset($_SESSION['success']);
}

// Fetch all customers
$query = "SELECT * FROM customers ORDER BY first_name ASC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Customers</title>
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
            <h2>Manage Customers</h2>
            
            <?php echo $message; ?>

            <h3>Add New Customer</h3>
            <form method="POST" action="add_customer.php">
                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" name="first_name" required placeholder="Enter first name">
                
                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" name="last_name" required placeholder="Enter last name">
                
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Enter email address">
                
                <label for="phone">Phone:</label>
                <input type="tel" id="phone" name="phone" placeholder="Enter phone number">
                
                <label for="address">Address:</label>
                <textarea id="address" name="address" placeholder="Enter full address"></textarea>
                
                <button type="submit">Add Customer</button>
            </form>

            <h3>Customers List</h3>
            <?php
            if ($result->num_rows > 0) {
                echo '<table>';
                echo '<thead>';
                echo '<tr>';
                echo '<th>Name</th>';
                echo '<th>Email</th>';
                echo '<th>Phone</th>';
                echo '<th>Address</th>';
                echo '<th>Actions</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';

                while ($row = $result->fetch_assoc()) {
                    $full_name = htmlspecialchars($row['first_name'] . ' ' . $row['last_name']);
                    echo '<tr>';
                    echo '<td>' . $full_name . '</td>';
                    echo '<td>' . htmlspecialchars($row['email'] ?? '') . '</td>';
                    echo '<td>' . htmlspecialchars($row['phone'] ?? '') . '</td>';
                    echo '<td>' . htmlspecialchars($row['address'] ?? '') . '</td>';
                    echo '<td class="actions">';
                    echo '<a href="edit_customer.php?id=' . $row['id'] . '" class="btn btn-edit">Edit</a>';
                    echo '<a href="delete_customer.php?id=' . $row['id'] . '" class="btn btn-delete" onclick="return confirm(\'Are you sure?\');">Delete</a>';
                    echo '</td>';
                    echo '</tr>';
                }

                echo '</tbody>';
                echo '</table>';
            } else {
                echo '<div class="info">No customers found. Add your first customer above.</div>';
            }
            ?>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 Maano Database System. All rights reserved.</p>
    </footer>
</body>
</html>

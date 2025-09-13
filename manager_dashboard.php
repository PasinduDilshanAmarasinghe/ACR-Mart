<?php
session_start();
include 'db.php';

// Check if manager is logged in
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'manager') {
    header("Location: login.php");
    exit();
}

// Fetch products from database
$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manager Dashboard - ACR Mart</title>
<style>
    /* Body & container */
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        background: #f5f5f5;
    }
    .container {
        max-width: 1000px;
        margin: 20px auto;
        padding: 0 15px;
    }

    /* Header */
    header {
        background: #4B2E0E;
        color: #f0d87c;
        padding: 15px;
        text-align: center;
    }

    /* Navbar */
    nav {
        background: #4B2E0E;
        padding: 10px;
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 15px;
    }
    nav a {
        color: #f0d87c;
        text-decoration: none;
        font-weight: bold;
        padding: 8px 16px;
        border-radius: 5px;
    }
    nav a:hover {
        background: #b69122;
        color: #fff;
    }

    /* Table */
    table {
        width: 100%;
        border-collapse: collapse;
        background: #fff;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        margin-top: 20px;
    }
    th, td {
        border: 1px solid #ddd;
        padding: 12px;
        text-align: center;
    }
    th {
        background: #4B2E0E;
        color: #f0d87c;
    }
    tr:nth-child(even) { background: #f9f9f9; }
    img {
        max-width: 80px;
        max-height: 80px;
    }

    /* Headings */
    h2 {
        text-align: center;
        color: #4B2E0E;
        margin-bottom: 15px;
    }
</style>
</head>
<body>

<header>
    <h1>Manager Dashboard - ACR Mart</h1>
</header>

<nav>
    <a href="manager_dashboard.php">Dashboard</a>
    <a href="manager.php">Add Product</a>
    <a href="logout.php">Sign Out</a>
</nav>

<div class="container">
    <h2>All Products</h2>
    <table>
        <tr>
            <th>Product ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Price (LKR)</th>
            <th>Stock</th>
            <th>Category</th>
            <th>Image</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>".$row['product_id']."</td>
                        <td>".$row['name']."</td>
                        <td>".$row['description']."</td>
                        <td>LKR ".number_format($row['price'],2)."</td>
                        <td>".$row['stock']."</td>
                        <td>".$row['category']."</td>
                        <td><img src='".$row['image_url']."' alt='".$row['name']."'></td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No products available</td></tr>";
        }
        ?>
    </table>
</div>

</body>
</html>
<?php $conn->close(); ?>

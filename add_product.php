<?php
session_start();

// Restrict access to admin only
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: signin.php");
    exit();
}

include('db.php');

$categories = ['Stationery','Beverages','Electronics','Clothing','Food','Other'];
$success = '';
$error = '';

// Handle Add Product form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = floatval($_POST['price']);
    $stock = intval($_POST['stock']);
    $category = $_POST['category'];

    // Handle image upload
    $imagePath = '';
    if(isset($_FILES['image']) && $_FILES['image']['error'] == 0){
        $uploadDir = "piks/";
        if(!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

        $fileName = time() . "_" . basename($_FILES['image']['name']);
        $targetFile = $uploadDir . $fileName;

        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg','jpeg','png','webp','gif'];

        if(in_array($fileType, $allowedTypes)){
            if(move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)){
                $imagePath = $fileName; // store only file name
            } else {
                $error = "Failed to upload image.";
            }
        } else {
            $error = "Invalid image type. Allowed: jpg, jpeg, png, webp, gif.";
        }
    }

    if(empty($error)){
        $stmt = $conn->prepare("INSERT INTO products (name, description, price, stock, image_url, category) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdiss", $name, $description, $price, $stock, $imagePath, $category);

        if($stmt->execute()){
            $success = "Product added successfully!";
        } else {
            $error = "Error adding product: " . $conn->error;
        }
    }
}

// Fetch all products for the table
$result = $conn->query("SELECT product_id, name, category, price, image_url FROM products");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard</title>
<style>
    body {
        font-family: Arial, sans-serif;
        margin:0;
        background:#f5f5f5;
    }

    /* Navbar */
    nav {
        background:#4B2E0E;
        padding:1rem;
        color:#fff;
        display:flex;
        justify-content:space-around;
        flex-wrap: wrap;
    }
    nav a {
        color:#f0d87c;
        text-decoration:none;
        font-weight:bold;
        margin:5px;
    }
    nav a:hover { color:#fff; }

    /* Container */
    .container {
        max-width: 1000px;
        margin: 20px auto;
        padding: 0 15px;
    }

    /* Form */
    .form-container {
        background: #fff;
        padding: 2rem;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        text-align: center;
        margin-bottom: 30px;
    }
    input, textarea, select {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border-radius: 5px;
        border: 1px solid #ccc;
        font-size: 1rem;
    }
    button {
        padding: 10px 20px;
        background: #4B2E0E;
        color: #f0d87c;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-weight: bold;
        width: 100%;
        font-size: 1rem;
    }
    button:hover { background: #b69122; }
    .message { margin: 10px 0; font-weight: bold; }
    .success { color: green; }
    .error { color: red; }

    /* Table */
    table {
        width:100%;
        border-collapse:collapse;
        background:#fff;
    }
    th, td {
        border:1px solid #ddd;
        padding:10px;
        text-align:left;
    }
    th {
        background:#4B2E0E;
        color:#f0d87c;
    }
    tr:nth-child(even) { background:#f9f9f9; }
    img { max-width:60px; max-height:60px; }
</style>
</head>
<body>

<nav>
    <a href="admin_dashboard.php">Home</a>
    <a href="add_product.php">Add Products</a>
    <a href="remove_product.php">Remove Products</a>
    <a href="update_product.php">Change Values</a>
    <a href="logout.php">Logout</a>
</nav>

<div class="container">

    <div class="form-container">
        <h2>Add Product</h2>
        <?php if($success) echo "<div class='message success'>$success</div>"; ?>
        <?php if($error) echo "<div class='message error'>$error</div>"; ?>

        <form method="POST" enctype="multipart/form-data">
            <input type="text" name="name" placeholder="Product Name" required>
            <textarea name="description" rows="3" placeholder="Description" required></textarea>
            <input type="number" step="0.01" name="price" placeholder="Price (LKR)" required>
            <input type="number" name="stock" placeholder="Stock Quantity" required>
            <select name="category" required>
                <option value="">Select Category</option>
                <?php foreach($categories as $cat) echo "<option value=\"$cat\">$cat</option>"; ?>
            </select>
            <input type="file" name="image" accept="image/*">
            <button type="submit">Add Product</button>
        </form>
    </div>

    

</div>

</body>
</html>

<?php $conn->close(); ?>

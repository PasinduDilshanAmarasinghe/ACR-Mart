<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: signin.php");
    exit();
}
include('db.php');

if(isset($_POST['product_id'])){
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $stmt = $conn->prepare("UPDATE products SET price=?, stock=? WHERE product_id=?");
    $stmt->bind_param("dii", $price, $stock, $_POST['product_id']);
    if($stmt->execute()){
        $success = "Product updated successfully!";
    } else {
        $error = "Error updating product.";
    }
}

// Fetch products for dropdown
$products = $conn->query("SELECT product_id, name, price, stock FROM products");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Update Product</title>
<style>
body { 
    font-family: Arial; 
    margin: 0; 
    padding: 0; 
    background:#f5f5f5; 
}
nav { 
    background:#4B2E0E; 
    padding:1rem; 
    color:#fff; 
    display:flex; 
    justify-content:space-around; 
}
nav a { 
    color:#f0d87c; 
    text-decoration:none; 
    font-weight:bold; 
}
.container {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: calc(100vh - 60px); /* full height minus navbar */
    padding: 20px;
}
form { 
    background:#fff; 
    padding:2rem; 
    border-radius:10px; 
    max-width:400px; 
    width:100%;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}
select, input { 
    width:100%; 
    padding:10px; 
    margin:10px 0; 
    border-radius:5px; 
    border:1px solid #ccc; 
}
button { 
    padding:10px 20px; 
    background:#4B2E0E; 
    color:#f0d87c; 
    border:none; 
    border-radius:5px; 
    cursor:pointer; 
}
button:hover { 
    background:#b69122; 
}
p { 
    color:green; 
}
.error { 
    color:red; 
}
h2 {
    text-align: center;
    margin-bottom: 15px;
}
</style>
</head>
<body>
<nav>
    <a href="admin_dashboard.php">Home</a>
    <a href="add_product.php">Add Product</a>
    <a href="remove_product.php">Remove Product</a>
    <a href="logout.php">Logout</a>
</nav>

<div class="container">
    <form method="POST">
        <h2>Update Product</h2>

        <?php if(isset($success)) echo "<p>$success</p>"; ?>
        <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>

        <label>Select Product</label>
        <select name="product_id" required>
            <option value="">--Select Product--</option>
            <?php while($row = $products->fetch_assoc()): ?>
            <option value="<?php echo $row['product_id']; ?>">
                <?php echo $row['name'] . " | Price: " . $row['price'] . " | Stock: " . $row['stock']; ?>
            </option>
            <?php endwhile; ?>
        </select>

        <label>New Price</label>
        <input type="number" step="0.01" name="price" required>

        <label>New Stock</label>
        <input type="number" name="stock" required>

        <button type="submit">Update Product</button>
    </form>
</div>
</body>
</html>

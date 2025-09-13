<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'manager') {
    header("Location: signin.php");
    exit();
}
include('db.php');

$categories = ['Stationery','Beverages','Electronics','Clothing','Food','Other'];

// Handle delete securely (POST instead of GET)
if(isset($_POST['delete_product'])){
    $id = intval($_POST['product_id']);
    if($id > 0){
        $stmt = $conn->prepare("DELETE FROM products WHERE product_id = ? LIMIT 1");
        if($stmt){
            $stmt->bind_param("i", $id);
            if($stmt->execute()){
                if($stmt->affected_rows > 0){
                    $success = "Product deleted successfully!";
                } else {
                    $error = "No product found with that ID.";
                }
            } else {
                $error = "Failed to delete product: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $error = "Failed to prepare delete statement: " . $conn->error;
        }
    } else {
        $error = "Invalid product id.";
    }
}

// Handle update price securely
if(isset($_POST['update_price'])){
    $id = intval($_POST['product_id']);
    $new_price = floatval($_POST['new_price']);
    $stmt = $conn->prepare("UPDATE products SET price=? WHERE product_id=?");
    $stmt->bind_param("di", $new_price, $id);
    if($stmt->execute()){
        $success = "Price updated successfully!";
    } else {
        $error = "Failed to update price: ".$conn->error;
    }
}

// Handle add product securely
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_product'])) {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = floatval($_POST['price']);
    $stock = intval($_POST['stock']);
    $category = $_POST['category'];

    $imagePath = null;

    if(isset($_FILES['image']) && $_FILES['image']['error'] == 0){
        $uploadDir = "piks/";
        if(!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

        $fileName = time() . "_" . basename($_FILES['image']['name']);
        $targetFile = $uploadDir . $fileName;

        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg','jpeg','png','webp','gif'];

        if(in_array($fileType, $allowedTypes)){
            if(move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)){
                $imagePath = $targetFile;
            } else {
                $error = "Failed to upload image.";
            }
        } else {
            $error = "Invalid image type. Allowed: jpg, jpeg, png, webp, gif.";
        }
    }

    if(!isset($error)){
        $stmt = $conn->prepare("INSERT INTO products (name, description, price, stock, image_url, category) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdiss", $name, $description, $price, $stock, $imagePath, $category);
        if($stmt->execute()){
            $success = "Product added successfully!";
        } else {
            $error = "Error adding product: ".$conn->error;
        }
    }
}

// Fetch all products
$result = $conn->query("SELECT * FROM products ORDER BY product_id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manager Dashboard</title>
<style>
body { font-family: Arial; padding: 2rem; background:#f5f5f5; }
nav { background:rgba(56, 42, 6, 1); padding:1rem; color:#fff; display:flex; justify-content:space-around; }
nav a { color:#f0d87c; text-decoration:none; font-weight:bold; }
h2, h3 { color:#4B2E0E; margin-top: 20px; }
form, table { margin-top: 20px; }
form { background:#fff; padding:2rem; border-radius:10px; max-width:500px; box-shadow:0px 3px 8px rgba(0,0,0,0.1); }
input, textarea, select { width:100%; padding:10px; margin:10px 0; border-radius:5px; border:1px solid #ccccccff; }
button { padding:10px 20px; background:#1f3c88; color:#f0d87c; border:none; border-radius:5px; cursor:pointer; }
button:hover { background:#f0d87c; color:#1f3c88; }
.error { color:red; }
.success { color:green; }
table { width:100%; border-collapse:collapse; background:#fff; border-radius:10px; overflow:hidden; }
th, td { padding:10px; border:1px solid #ccc; text-align:center; }
img { max-width:60px; max-height:60px; object-fit:contain; }
</style>
</head>
<body>

<nav>
<a href="manager_dashboard.php">Dashboard</a>
<a href="logout.php">Logout</a>
</nav>

<h2>Manager Dashboard</h2>

<?php if(isset($success)) echo "<p class='success'>$success</p>"; ?>
<?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>

<h3>All Products</h3>
<table>
<tr>
<th>ID</th>
<th>Name</th>
<th>Description</th>
<th>Price</th>
<th>Stock</th>
<th>Category</th>
<th>Image</th>
<th>Actions</th>
</tr>
<?php while($row = $result->fetch_assoc()): ?>
<tr>
<td><?= $row['product_id'] ?></td>
<td><?= htmlspecialchars($row['name']) ?></td>
<td><?= htmlspecialchars($row['description']) ?></td>
<td>LKR <?= number_format($row['price'],2) ?></td>
<td><?= $row['stock'] ?></td>
<td><?= htmlspecialchars($row['category']) ?></td>
<td><?php if($row['image_url']) echo "<img src='{$row['image_url']}' alt='product'>"; ?></td>
<td>
    <!-- Update price form -->
    <form method="post" style="margin-bottom:5px;">
        <input type="hidden" name="product_id" value="<?= $row['product_id'] ?>">
        <input type="number" step="0.01" name="new_price" placeholder="New Price" required>
        <button type="submit" name="update_price">Update Price</button>
    </form>
    <!-- Delete form -->
    <form method="post" onsubmit="return confirm('Are you sure you want to delete this product?');">
        <input type="hidden" name="product_id" value="<?= $row['product_id'] ?>">
        <button type="submit" name="delete_product" style="background:red; color:white;">Delete</button>
    </form>
</td>
</tr>
<?php endwhile; ?>
</table>

<h3>Add New Product</h3>
<form method="POST" enctype="multipart/form-data">
<input type="hidden" name="add_product" value="1">

<label>Name</label>
<input type="text" name="name" required>

<label>Description</label>
<textarea name="description" rows="3" required></textarea>

<label>Price</label>
<input type="number" step="0.01" name="price" required>

<label>Stock</label>
<input type="number" name="stock" required>

<label>Category</label>
<select name="category" required>
    <option value="">Select Category</option>
    <?php foreach($categories as $cat): ?>
        <option value="<?= $cat ?>"><?= $cat ?></option>
    <?php endforeach; ?>
</select>

<label>Image</label>
<input type="file" name="image" accept="image/*" required>

<button type="submit">Add Product</button>
</form>

</body>
</html>

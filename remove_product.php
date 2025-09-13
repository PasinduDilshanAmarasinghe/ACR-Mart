<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: signin.php");
    exit();
}
include('db.php');

if(isset($_POST['product_id'])){
    $stmt = $conn->prepare("DELETE FROM products WHERE product_id=?");
    $stmt->bind_param("i", $_POST['product_id']);
    if($stmt->execute()){
        $success = "Product removed successfully!";
    } else {
        $error = "Error removing product.";
    }
}

// Fetch products for dropdown
$products = $conn->query("SELECT product_id, name FROM products");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Remove Product</title>
<style>
body { 
    font-family: Arial; 
    margin: 0;
    height: 100vh;
    display: flex;
    flex-direction: column;
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
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
}
form { 
    background:#fff; 
    padding:2rem; 
    border-radius:10px; 
    max-width:400px; 
    width:100%;
    box-shadow:0px 3px 8px rgba(0,0,0,0.1);
    text-align:center;
}
select { 
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
p { color:green; }
.error { color:red; }
</style>
</head>
<body>
<nav>
<a href="admin_dashboard.php">Home</a>
<a href="add_product.php">Add Product</a>
<a href="update_product.php">Change Values</a>
<a href="logout.php">Logout</a>
</nav>

<div class="container">
    <div>
        <h2 style="text-align:center;">Remove Product</h2>

        <?php if(isset($success)) echo "<p>$success</p>"; ?>
        <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>

        <form method="POST">
            <label>Select Product</label>
            <select name="product_id" required>
                <option value="">--Select Product--</option>
                <?php while($row = $products->fetch_assoc()): ?>
                <option value="<?php echo $row['product_id']; ?>"><?php echo $row['name']; ?></option>
                <?php endwhile; ?>
            </select>

            <button type="submit">Remove Product</button>
        </form>
    </div>
</div>
</body>
</html>

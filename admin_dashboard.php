<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: signin.php");
    exit();
}

// Connect to DB
$host = "localhost"; // change if needed
$user = "root";      // your db username
$pass = "";          // your db password
$db   = "acr_mart";  // your db name

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Fetch all products
$sql = "SELECT product_id, name, price, category, image_url FROM products";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <style>
    body { font-family: Arial, sans-serif; margin:0; padding:0; background:#f5f5f5; }
    nav { background:#4B2E0E; padding:1rem; color:#fff; display:flex; justify-content:space-around; }
    nav a { color:#f0d87c; text-decoration:none; font-weight:bold; }
    nav a:hover { color:#fff; }
    main { padding:2rem; }
    h1 { margin-bottom:1rem; }
    table { width:100%; border-collapse:collapse; background:#fff; margin-top:1.5rem; }
    th, td { border:1px solid #ddd; padding:10px; text-align:left; }
    th { background:#4B2E0E; color:#f0d87c; }
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

  <main>
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
    <p>This is your admin dashboard.</p>

    <h2>All Products</h2>
    <table>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Category</th>
        <th>Price (Rs)</th>
        <th>Image</th>
      </tr>
      <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?php echo htmlspecialchars($row['product_id']); ?></td>
            <td><?php echo htmlspecialchars($row['name']); ?></td>
            <td><?php echo htmlspecialchars($row['category']); ?></td>
            <td><?php echo number_format($row['price'], 2); ?></td>
            <td>
              <?php if (!empty($row['image_url'])): ?>
                <img src="piks/<?php echo htmlspecialchars($row['image_url']); ?>" alt="Product">
              <?php else: ?>
                No image
              <?php endif; ?>
            </td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr><td colspan="5">No products found.</td></tr>
      <?php endif; ?>
    </table>
  </main>
</body>
</html>
<?php $conn->close(); ?>

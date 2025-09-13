<?php
session_start();

// Ensure cart is always an array
if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle delete actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Delete single product
    if (isset($_POST['delete_id'])) {
        $id = $_POST['delete_id'];
        unset($_SESSION['cart'][$id]);
    }
    // Delete all products
    if (isset($_POST['delete_all'])) {
        $_SESSION['cart'] = [];
    }
}

// Sanitize cart: remove invalid entries
$cart = [];
foreach ($_SESSION['cart'] as $id => $item) {
    if (is_array($item) && isset($item['name'], $item['price'], $item['quantity'], $item['image_url'])) {
        $cart[$id] = $item;
    }
}
$_SESSION['cart'] = $cart;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>ACR Mart - Cart</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      background: #fff;
      color: #333;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    nav {
      position: fixed;
      top: 0;
      height: 10%;
      width: 100%;
      background: #4B2E0E;
      padding: 1rem 2rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 3px 10px rgba(0,0,0,0.3);
      z-index: 10;
    }

    .nav-left img {
      height: 120px;
      display: block;
    }

    .nav-right a {
      color: #f0d87c;
      text-decoration: none;
      margin-left: 2rem;
      font-weight: 600;
      transition: color 0.3s ease;
      position: relative;
    }

    .nav-right a:hover,
    .nav-right a:focus {
      color: #b69122;
    }

    .nav-right a::after {
      content: '';
      position: absolute;
      width: 0;
      height: 2px;
      background: #f0d87c;
      left: 0;
      bottom: -4px;
      transition: width 0.3s ease;
    }

    .nav-right a:hover::after,
    .nav-right a:focus::after {
      width: 100%;
    }

    main {
      padding: 120px 2rem 2rem;
      max-width: 1000px;
      margin: auto;
      flex: 1;
    }

    h2 {
      text-align: center;
      font-size: 2rem;
      font-weight: 900;
      margin-bottom: 2rem;
      color: #4B2E0E;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 2rem;
      user-select: none;
    }

    th, td {
      border: 1px solid #ddd;
      padding: 12px 15px;
      text-align: center;
      font-weight: 600;
      color: #4B2E0E;
      vertical-align: middle;
    }

    th {
      background-color: #f0d87c;
    }

    .product-info {
      display: flex;
      align-items: center;
      gap: 15px;
      justify-content: center;
    }

    .product-info img {
      width: 70px;
      height: 70px;
      object-fit: cover;
      border-radius: 10px;
      border: 1px solid #ddd;
    }

    tfoot td {
      font-weight: 900;
      font-size: 1.2rem;
      color: #d1a83f;
    }

    .delivery-options {
      margin-bottom: 2rem;
      display: flex;
      gap: 2rem;
      justify-content: center;
      user-select: none;
    }

    .delivery-options label {
      font-weight: 700;
      font-size: 1.1rem;
      color: #4B2E0E;
      cursor: pointer;
    }

    .delivery-options input[type="radio"] {
      margin-right: 0.5rem;
      cursor: pointer;
    }

    .action-buttons {
      display: flex;
      justify-content: center;
      gap: 2rem;
      margin-bottom: 3rem;
    }

    .action-buttons button {
      background-color: #4B2E0E;
      color: #f0d87c;
      border: none;
      padding: 0.8rem 2rem;
      font-size: 1.1rem;
      font-weight: 700;
      border-radius: 30px;
      cursor: pointer;
      box-shadow: 0 5px 15px rgba(75,46,14,0.7);
      transition: background-color 0.3s ease;
      user-select: none;
    }

    .action-buttons button:hover {
      background-color: #3a2207;
    }

    .delete-btn {
      background-color: #a00;
      padding: 0.3rem 0.8rem;
      border-radius: 5px;
      font-size: 0.9rem;
      color: #fff;
      font-weight: 600;
    }

    .delete-btn:hover {
      background-color: #700;
    }

    #empty-message {
      text-align: center;
      font-size: 1.3rem;
      font-weight: 600;
      color: #a05200;
      margin-top: 3rem;
      user-select: none;
    }

    footer {
      background-color: #3a2207;
      color: #fff;
      padding: 40px 0;
      font-family: Arial, sans-serif;
    }

    .footer-container {
      display: flex;
      justify-content:end;
      flex-wrap: wrap;
      max-width: 1200px;
      margin: auto;
    }

    .footer-container div {
      flex: 1;
      margin: 15px;
      min-width: 220px;
    }

    .footer-container h3 {
      border-bottom: 2px solid #ffcc00;
      padding-bottom: 8px;
      margin-bottom: 15px;
      font-size: 18px;
    }

    .footer-container ul {
      list-style: none;
    }

    .footer-container ul li {
      margin: 8px 0;
    }

    .footer-container ul li a {
      color: #ddd;
      text-decoration: none;
      transition: 0.3s;
    }

    .footer-container ul li a:hover {
      color: #ffcc00;
    }

    .footer-contact p {
      margin: 6px 0;
    }

    .footer-social a img {
      width: 28px;
      margin-right: 10px;
      filter: brightness(0) invert(1);
      transition: 0.3s;
    }

    .footer-social a img:hover {
      filter: brightness(0) invert(0.8) sepia(1) hue-rotate(30deg) saturate(5);
    }

    .footer-bottom {
      text-align: center;
      padding: 15px 0;
      border-top: 1px solid #444;
      margin-top: 20px;
      font-size: 14px;
      color: #bbb;
    }
  </style>
</head>
<body>

  <nav>
    <div class="nav-left">
      <a href="products.php"><img src="piks/logo.png" alt="ACR Mart Logo" /></a>
    </div>
    <div class="nav-right">
      <a href="home.html">Home</a>
      <a href="products.php">Products</a>
      <a href="about.html">About Us</a>
      <a href="cart.php">🛒 Cart</a>
      <a href="signin.php">Sign In</a>
    </div>
  </nav>

  <main>
    <h2>Your Cart</h2>

    <?php if(empty($cart)) : ?>
        <p id="empty-message">Your cart is empty.</p>
    <?php else: ?>
        <table id="cart-table" aria-label="Shopping Cart Table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Unit Price (Rs.)</th>
                    <th>Total Price (Rs.)</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $grandTotal = 0;
                foreach($cart as $id => $item): 
                    $totalPrice = $item['price'] * $item['quantity'];
                    $grandTotal += $totalPrice;
                ?>
                    <tr>
                        <td>
                          <div class="product-info">
                            <img src="<?php echo htmlspecialchars($item['image_url']); ?>" alt="Product Image">
                            <span><?php echo htmlspecialchars($item['name']); ?></span>
                          </div>
                        </td>
                        <td><?php echo $item['quantity']; ?></td>
                        <td>Rs. <?php echo number_format($item['price'], 2); ?></td>
                        <td>Rs. <?php echo number_format($totalPrice, 2); ?></td>
                        <td>
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="delete_id" value="<?php echo $id; ?>">
                                <button type="submit" class="delete-btn">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3">Grand Total</td>
                    <td colspan="2">Rs. <?php echo number_format($grandTotal, 2); ?></td>
                </tr>
            </tfoot>
        </table>

        <div class="delivery-options" role="radiogroup" aria-label="Select delivery option">
          <label>
            <input type="radio" name="delivery" value="delivery" checked />
            Deliver to Customer
          </label>
          <label>
            <input type="radio" name="delivery" value="pickup" />
            Pick up
          </label>
        </div>

        <div class="action-buttons">
            <form method="post" style="display:inline;">
                <button type="submit" name="delete_all">Delete All</button>
            </form>

            <form method="post" action="delivery.php" style="display:inline;">
                <button type="submit" id="checkout-btn">Checkout</button>
            </form>
        </div>
    <?php endif; ?>
  </main>

  <footer>
    <div class="footer-container">
      <div class="footer-about">
        <h3>About Us</h3>
        <p>We are your one-stop online store, offering high-quality products at affordable prices with fast delivery and excellent customer service.</p>
      </div>

      <div class="footer-links">
        <h3>Quick Links</h3>
        <ul>
          <li><a href="index.html">Home</a></li>
          <li><a href="products.php">Shop</a></li>
          <li><a href="about.html">About</a></li>
          <li><a href="contact.html">Contact</a></li>
          <li><a href="faq.html">FAQs</a></li>
        </ul>
      </div>

      <div class="footer-contact">
        <h3>Contact Us</h3>
        <p>Email: support@acrmart.com</p>
        <p>Phone: +94 77 123 4567</p>
        <p>Address: Colombo, Sri Lanka</p>
      </div>

      <div class="footer-social">
        <h3>Follow Us</h3>
        <a href="#"><img src="piks/fb.png" alt="Facebook"></a>
        <a href="#"><img src="piks/inst.png" alt="Instagram"></a>
      </div>
    </div>
    <div class="footer-bottom">
      <p>© 2025 ACR Mart. All rights reserved.</p>
    </div>
  </footer>

</body>
</html>


//manger@acr123
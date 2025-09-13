<?php
// add_to_cart.php
session_start();
header('Content-Type: application/json');

// Only accept POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status'=>'error','message'=>'Invalid request method']);
    exit;
}

// Get POST values (application/x-www-form-urlencoded)
$id       = trim($_POST['id'] ?? '');
$name     = trim($_POST['name'] ?? '');
$price    = (float) ($_POST['price'] ?? 0);
$image    = trim($_POST['image'] ?? ''); // expected full path e.g. piks/foo.png
$quantity = (int) ($_POST['quantity'] ?? 1);

if ($id === '' || $name === '' || $price <= 0 || $quantity < 1) {
    echo json_encode(['status'=>'error','message'=>'Missing or invalid product data']);
    exit;
}

// Ensure cart exists and is an array
if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Add or update item
if (isset($_SESSION['cart'][$id])) {
    // increase quantity
    $_SESSION['cart'][$id]['quantity'] += $quantity;
} else {
    // add new
    $_SESSION['cart'][$id] = [
        'name' => $name,
        'price' => $price,
        'quantity' => $quantity,
        'image_url' => $image
    ];
}

// Respond with success and current cart item count
$items_count = array_sum(array_column($_SESSION['cart'], 'quantity'));
echo json_encode(['status'=>'success','message'=>'Added to cart','items_count'=>$items_count]);
exit;

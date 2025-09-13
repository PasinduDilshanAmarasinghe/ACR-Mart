<?php
session_start();
include('db.php');

// Example: purchase info sent from front-end
$customer_name = $_SESSION['username'] ?? 'Guest';
$delivery_type = $_POST['delivery_type']; // e.g., 'Home Delivery' or 'Pick Up'
$products = $_POST['products']; // Array of ['name' => 'Item1', 'qty' => 2, 'price' => 150]
$total_price = $_POST['total_price'];

// Prepare product list as HTML
$productListHTML = "<ul>";
foreach($products as $item){
    $productListHTML .= "<li>{$item['name']} - Quantity: {$item['qty']} - Price: Rs. {$item['price']}</li>";
}
$productListHTML .= "</ul>";

// Manager email
$manager_email = "shevon.weerawardane@gmail.com";

// Email subject & message
$subject = "New Purchase from Customer: $customer_name";

$message = "
<html>
<head>
<title>New Purchase</title>
</head>
<body>
<h2>New Purchase Notification</h2>
<p><strong>Customer Name:</strong> $customer_name</p>
<p><strong>Delivery Type:</strong> $delivery_type</p>
<p><strong>Products Ordered:</strong></p>
$productListHTML
<p><strong>Total Price:</strong> Rs. $total_price</p>
</body>
</html>
";

// Set content-type for HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// Optional: From header
$headers .= "From: aloenanasewana@gmail.com" . "\r\n";

// Send the email
if(mail($manager_email, $subject, $message, $headers)){
    echo json_encode(['status' => 'success', 'message' => 'Purchase confirmed and manager notified!']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to send email.']);
}
?>

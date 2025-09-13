<?php
session_start();
require 'db.php'; // Database connection

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// 1. Get purchase data
$customer_name = $_POST['customer_name'] ?? "Guest";
$delivery_type = $_POST['delivery_type'] ?? "Home Delivery";
$products = $_POST['products'] ?? []; // array of ['product_id' => qty]

// Validate products
if(empty($products)){
    echo json_encode(['status'=>'error','message'=>'No products selected']);
    exit;
}

// 2. Fetch product details from DB
$total_price = 0;
$product_details = [];
foreach($products as $product_id => $qty){
    $stmt = $conn->prepare("SELECT name, price FROM products WHERE product_id=?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if($row = $result->fetch_assoc()){
        $product_details[] = [
            'name' => $row['name'],
            'qty' => $qty,
            'price' => $row['price']
        ];
        $total_price += $row['price'] * $qty;
    }
}

// 3. Optional: Save order in DB
/*
$stmt2 = $conn->prepare("INSERT INTO orders (customer_name, delivery_type, total_price) VALUES (?, ?, ?)");
$stmt2->bind_param("ssd", $customer_name, $delivery_type, $total_price);
$stmt2->execute();
$order_id = $stmt2->insert_id;
*/

// 4. Send email
try {
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'aloenanasewana@gmail.com'; // Sender Gmail
    $mail->Password = 'YOUR_APP_PASSWORD'; // Gmail App Password
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('aloenanasewana@gmail.com', 'Aloe Serene Mart');
    $mail->addAddress('shevon.weerawardane@gmail.com'); // Manager
    $mail->addAddress('shevon.weerawardane@gmail.com'); // Admin

    $mail->isHTML(true);
    $mail->Subject = "New Purchase Notification";

    $productHTML = "<table border='1' cellpadding='5' cellspacing='0' style='border-collapse:collapse;'>
        <tr><th>Product</th><th>Qty</th><th>Price</th></tr>";
    foreach($product_details as $item){
        $productHTML .= "<tr>
            <td>{$item['name']}</td>
            <td>{$item['qty']}</td>
            <td>Rs. {$item['price']}</td>
        </tr>";
    }
    $productHTML .= "</table>";

    $mail->Body = "
        <h2>New Purchase</h2>
        <p><strong>Customer:</strong> $customer_name</p>
        <p><strong>Delivery Type:</strong> $delivery_type</p>
        <p><strong>Products:</strong></p>
        $productHTML
        <p><strong>Total Price:</strong> Rs. $total_price</p>
    ";

    $mail->send();
    echo json_encode(['status'=>'success','message'=>'Purchase successful! Email sent.']);
} catch (Exception $e) {
    echo json_encode(['status'=>'error','message'=>"Email could not be sent. Mailer Error: {$mail->ErrorInfo}"]);
}
?>

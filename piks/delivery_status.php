<?php
session_start();
include('db.php');

// Check if order_id is passed
if(!isset($_GET['order_id'])) {
    die("Invalid request. No order ID found.");
}

$orderId = intval($_GET['order_id']);

// Fetch order details
$stmt = $conn->prepare("SELECT * FROM orders WHERE order_id=?");
$stmt->bind_param("i", $orderId);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();

if(!$order) {
    die("Order not found!");
}

// Fetch order items
$items = $conn->query("SELECT * FROM order_items WHERE order_id=$orderId");

// Estimate delivery time (you can adjust logic)
$estimatedDelivery = "";
if($order['order_type'] == "delivery") {
    $estimatedDelivery = date("h:i A", strtotime($order['order_time'] . " +2 hours"));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delivery Status - Order <?php echo $orderId; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8f8f8;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 70%;
            margin: 50px auto;
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0px 0px 8px rgba(0,0,0,0.2);
        }
        h2 {
            text-align: center;
            color: #4CAF50;
        }
        .status-box {
            background: #eafbea;
            border-left: 5px solid #4CAF50;
            padding: 15px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        th {
            background: #f0f0f0;
        }
        .info-box {
            margin-top: 20px;
            background: #fff3cd;
            border-left: 5px solid #ff9900;
            padding: 15px;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 14px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>📦 Order Status</h2>

        <div class="status-box">
            <strong>Status:</strong> Pending  
            <br>
            <strong>Payment:</strong> Pending  
            <br>
            <?php if($order['order_type'] == "delivery") { ?>
                <strong>Estimated Delivery Time:</strong> <?php echo $estimatedDelivery; ?>  
            <?php } else { ?>
                <strong>Pickup Location:</strong> ACR Mart Store, Colombo  
            <?php } ?>
        </div>

        <h3>🧾 Order Information</h3>
        <p><strong>Order ID:</strong> <?php echo $order['order_id']; ?></p>
        <p><strong>Customer:</strong> <?php echo $order['customer_name']; ?> (<?php echo $order['phone']; ?>)</p>
        <p><strong>Order Type:</strong> <?php echo ucfirst($order['order_type']); ?></p>
        <?php if($order['order_type'] == "delivery") { ?>
            <p><strong>Delivery Address:</strong> <?php echo $order['address']; ?></p>
        <?php } ?>
        <p><strong>Date:</strong> <?php echo $order['order_date']; ?> | <strong>Time:</strong> <?php echo $order['order_time']; ?></p>

        <h3>🛒 Order Items</h3>
        <table>
            <tr>
                <th>Product</th><th>Quantity</th><th>Unit Price</th><th>Total</th>
            </tr>
            <?php 
            $grandTotal = 0;
            while($row = $items->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['product_name']}</td>
                        <td>{$row['quantity']}</td>
                        <td>Rs. {$row['unit_price']}</td>
                        <td>Rs. {$row['total_price']}</td>
                      </tr>";
                $grandTotal += $row['total_price'];
            }
            ?>
            <tr>
                <td colspan="3"><strong>Grand Total</strong></td>
                <td><strong>Rs. <?php echo $grandTotal; ?></strong></td>
            </tr>
        </table>

        <div class="info-box">
            <strong>ℹ️ Important Information:</strong>
            <ul>
                <?php if($order['order_type'] == "delivery") { ?>
                    <li>Your order is being processed and will be delivered to your address.</li>
                    <li>You will receive an SMS/Call before delivery.</li>
                <?php } else { ?>
                    <li>Please bring your Order ID when picking up your items.</li>
                    <li>Pickup is available between 9 AM - 6 PM.</li>
                <?php } ?>
                <li>If payment is Cash on Delivery, please keep the exact amount ready.</li>
            </ul>
        </div>

        <div class="footer">
            Need help? Contact us at <strong>+94 77 123 4567</strong> or <strong>support@acrmart.com</strong>
        </div>
    </div>
</body>
</html>

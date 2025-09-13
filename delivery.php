<?php
session_start();
include('db.php');

// Check if user selected delivery or pickup
if(isset($_POST['order_type'])) {
    $orderType = $_POST['order_type'];
} else {
    $orderType = "delivery"; // default
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8f8f8;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 60%;
            margin: 50px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 8px rgba(0,0,0,0.2);
        }
        h2 {
            text-align: center;
            color: #5a3e1b;
        }
        form {
            margin-top: 20px;
        }
        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }
        input, select, textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            margin-top: 20px;
            padding: 12px;
            background: #5a3e1b;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }
        button:hover {
            background: #8b5e2f;
        }
        .note {
            background: #ffe9b3;
            padding: 10px;
            margin-top: 15px;
            border-left: 5px solid #ff9900;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2><?php echo ucfirst($orderType); ?> Details</h2>
        
        <?php if($orderType == "delivery") { ?>
            <form action="process_delivery.php" method="post">
                <input type="hidden" name="order_type" value="delivery">
                
                <label>Full Name</label>
                <input type="text" name="name" required>
                
                <label>Phone Number</label>
                <input type="text" name="phone" required>
                
                <label>Delivery Address</label>
                <textarea name="address" required></textarea>
                
                <label>Preferred Delivery Date</label>
                <input type="date" name="date" required>
                
                <label>Preferred Delivery Time</label>
                <input type="time" name="time" required>
                
                <button type="submit">Confirm Delivery</button>
            </form>
        <?php } else { ?>
            <div class="note">
                <strong>Pickup Location:</strong>  
                ACR Mart Store, Colombo, Sri Lanka  
            </div>
            
            <form action="process_delivery.php" method="post">
                <input type="hidden" name="order_type" value="pickup">
                
                <label>Full Name</label>
                <input type="text" name="name" required>
                
                <label>Phone Number</label>
                <input type="text" name="phone" required>
                
                <label>Pickup Date</label>
                <input type="date" name="date" required>
                
                <label>Pickup Time</label>
                <input type="time" name="time" required>
                
                <button type="submit">Confirm Pickup</button>
            </form>
        <?php } ?>
    </div>
</body>
</html>

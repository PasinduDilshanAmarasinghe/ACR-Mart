<?php
include('db.php'); // Make sure this connects to your database

$products = [];

// Fetch all products from database
$result = $conn->query("SELECT * FROM products ORDER BY name ASC");

if($result){
    while($row = $result->fetch_assoc()){
        // Ensure browser can load image: prepend folder path
        $row['image_url'] = 'piks/' . $row['image_url']; 
        $products[] = $row;
    }
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($products);
?>

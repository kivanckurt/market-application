<?php
require "db.php";
session_start();
extract($_GET);
if(isset($product_id) && getProductDetailed($product_id)){
    // Display the alert message
    echo "<script>window.alert('Item removed from your inventory');</script>";

    // Delete the product from the database
    $stmt = $db->prepare("delete from products where product_id = ?");
    $stmt->execute([$product_id]);

    // Redirect the user back to the main page
    header("location: market_main.php");
    exit; // Add exit to prevent further execution
}
?>
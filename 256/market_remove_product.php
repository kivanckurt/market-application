<?php
require "db.php";
session_start();
extract($_GET);
if(isset($product_id) && getProductDetailed($product_id)){
    $stmt = $db->prepare("delete from products where product_id = ?");
    $stmt->execute([$product_id]);
    header("location: market_main_copy.php?message='item removed from your inventory'");
    echo "mal";
}


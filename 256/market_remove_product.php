<?php
require "db.php";
session_start();
extract($_GET);
if(isset($product_id) && getProductDetailed($product_id)){
    $stmt = $db->prepare("delete from stocks where product_id = ? and email = ?");
    $stmt->execute([$product_id, $_SESSION["market_user"]["email"]]);
    header("location: market_main.php?message='item removed from your inventory'");
    echo "mal";
}


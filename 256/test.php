<?php
    session_start();
    require_once "db.php";
    require_once "customer_header.php";
    require_once "customer_operations.php";
    var_dump($_SESSION);
    var_dump($_COOKIE);
    // var_dump(getProductDetailed(1007));
    $user = &$_SESSION["customer_user"];
    $cart = &$user["cart"];
    var_dump($cart);
    // var_dump($_SESSION);
    purchaseCart();
    var_dump($cart);
    // var_dump($_SESSION);
    // var_dump(getCartInformation());
// Bind parameters with their respective data types for improved security

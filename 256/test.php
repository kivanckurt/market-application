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
    var_dump(getStock(1001));
    var_dump(isUpcomingProduct(1001));
    // updateCart(1001,115);
    // var_dump($cart);
    // purchaseCart();
    // var_dump($cart);
    // var_dump(getStock(1001));
    // var_dump($_SESSION);
    // var_dump(getCartInformation());
// Bind parameters with their respective data types for improved security

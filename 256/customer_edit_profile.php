<?php
    if(!isset($_SESSION)){
        session_start();
    }
    require_once "db.php";
    require_once "customer_operations.php";
    //if not authenticated, redirect to main page
    if(!isAuthenticatedCusto()){
        header("location: customer_login.php");
        exit;
    }
    var_dump($_SESSION);

    //generate shopping cart if it is not set
    if(!isset($_SESSION["customer_user"]["cart"])){
        $_SESSION["customer_user"]["cart"] = [];
    }
    $user = &$_SESSION["customer_user"];
    $cart =$_SESSION["customer_user"]["cart"];

    var_dump($user);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>
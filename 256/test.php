<?php
    session_start();
    require_once "db.php";
    $user = $_SESSION["user"];
    $email = $user["email"];
    $stmt = $db->prepare("UPDATE stocks,products SET `stock`=20 where stocks.email = 'cankaya@migros.com.tr' and products.product_id = 1007 and stocks.product_id =products.product_id;");
    $stmt->execute();
    var_dump(getProductDetailed(1007));
// Bind parameters with their respective data types for improved security

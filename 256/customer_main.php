<?php
    session_start();
    require "db.php";

    //if not authenticated, redirect to main page
    if(!isAuthenticatedCusto()){
        header("location: customer_login.php");
        exit;
    }
    $user = $_SESSION["customer_user"];
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
if(isset($_SESSION["customer_user"])){
    extract($_SESSION["customer_user"]);
    // var_dump($_SESSION["market_user"]);
    $user = $_SESSION["customer_user"];
}
?>
<h1><?=$user["name"]?></h1>
<h1><?=$user["email"]?></h1>
<h1><?=$user["city"]?></h1>
<h1><?=$user["city"]?></h1>
<h1><?=$user["district"]?></h1>
<h1><?=$user["address"]?></h1>
<h1><?=$user["remember"]?></h1>
<h1><?=$user["profile"]?></h1>
</body>
</html>
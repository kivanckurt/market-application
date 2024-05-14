<?php
    session_start();
    require "db.php";

    //if not authenticated, redirect to main page
    if(!isAuthenticatedCusto()){
        header("location: customer_login.php");
        exit;
    }
    $user = $_SESSION["customer_user"];
    $stocks=getAllProducts();
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .navbar{
            display:flex;flex-direction:row;
            justify-content:space-around;
            height:50px;
            width:800px;
            margin:20px auto;
            background-color:blue;
            border-radius:40px;
            justify-self: center;
        }
        .navbar a{
            color: white;
            margin:15px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
        }
        table,th,td{
            border:1px solid black;
            border-collapse: collapse;
        }
        table tr{
            height:80px;
            
        }
        table td{
            width:100px;
            margin:0 auto;
        }
        table img{
            height:80px;width: 80px;margin:0 auto;
        }
        table{
            width:800px;
            margin:0 auto;
        }
        table a{
            text-decoration: none;
            justify-self: center;
            margin:0 auto;
            
        }
    </style>
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
<p><a href="logout.php">Log out</a></p>
<?php var_dump($_SESSION) ?>
<?php var_dump($_COOKIE) ?>

</body>
</html>
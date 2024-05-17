<?php
    if(!isset($_SESSION)){
        session_start();
    }
if(isset($_SESSION["customer_user"])){
    extract($_SESSION["customer_user"]);
    // var_dump($_SESSION["market_user"]);
    $user = $_SESSION["customer_user"];
    // var_dump($user);
}

require_once "customer_operations.php";
require_once "db.php";
?>
<style>
</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="app.css">
    <style>
        header{
        color:red;
        text-align: center;
        position: relative;
        border: 1px solid black;
        border-radius: 10px;
        }
        header .logo{ color: white; background-color: lightblue;}
        .logo a {text-decoration: none; color: blue; font-size: 30px; border-radius: 10px;}
        #searchBar{border-radius: 10px; height: max-content; width: 300px;
        position: absolute; left: 200px; top: 10px;}
        #searchBar::placeholder{font-size: large;}
        .userInfo{position: absolute; right: 30px;}
        .userInfo div{border: 1px solid black; border-radius: 10px;}
        #profile{width: 30px;}
        .cartInfo{position: absolute; right: 150px; top: 10px;}
    </style>
    <title>Document</title>
</head>
<body>
    <header>
        <table>
            <tr>
                <td class="logo">
                    <div><span><a href="customer_main.php">xxmarkt</a></span></div>
                </td>
                <td>
                    <form action="customer_main.php?" method="GET">
                        <input type="text" name="keyword" id="searchBar" placeholder="Apple" 
                        <?= isset($_GET["keyword"]) ? "value={$_GET['keyword']}" :""  ?>>
                    </form>
                </td>
                <td>
                <a href="customer_cart.php">
                    <div>
                    <?php
                        $cartInfo = getCartInformation();
                        // var_dump($cartInfo);
                        echo "{$cartInfo['total_price']} TL, {$cartInfo['item_cnt']} ";
                    ?>
                    </div>
                </a>
                </td>
                <td class="userInfo">
                    <a href="customer_edit_profile.php">
                    <div>
                        <img src="./images/apples.jpeg" alt="" id="profile">
                        <span><?=$user["name"] ?></span>
                    </div>
                    </a>
                </td>
            </tr>
        </table>
    </header>
</body>
</html>
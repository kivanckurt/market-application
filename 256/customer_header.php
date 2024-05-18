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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        header {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #6038b4;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 10px 20px;
            border-radius: 10px;
        }
        .logo a {
            text-decoration: none;
            color: orange;
            font-size: 27px;
            font-weight: bold;
            padding: 12px;
            border-radius: 10px;
            overflow: hidden;
        }
        
        .search-container {
            display: flex;
            align-items: center;
            background-color: #fff;
            border-radius: 20px;
            overflow: hidden;
            padding: 5px 10px;
            margin-top: 0;
            margin-bottom: 0;
            width: 100%;
            max-width: 300px;
        }
        .search-container input[type="text"] {
            border: none;
            outline: none;
            padding: 5px 10px;
            font-size: 16px;
            flex-grow: 1;
        }
        .search-container input[type="text"]::placeholder {
            font-size: 16px;
            color: #aaa;
        }
        .search-container .search-icon {
            color: #6038b4;
            margin-right: 10px;
        }

        .cartInfo {
            display: flex;
            align-items: center;
            background-color: #fff;
            color: #6a1b9a;
            font-weight: bold;
            border-radius: 10px;
            overflow: hidden;
            margin-left: -300px;
        }
        .cartInfo a {
            text-decoration: none;
            color: inherit;
            display: flex;
            align-items: center;
        }
        .cartInfo .cart-icon-container {
            background-color: #ddd; /* Darker background for the icon */
            padding: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .cartInfo .cart-icon {
            font-size: 24px;
        }
        .cartInfo .price-container {
            padding: 15px;
            font-size: 16px;
        }

        .userInfo {
            display: flex;
            align-items: center;
            background-color: #fff;
            color: #6a1b9a;
            font-weight: bold;
            border-radius: 10px;
            overflow: hidden;
        }
        .userInfo a {
            text-decoration: none;
            color: inherit;
            display: flex;
            align-items: center;
        }
        .userInfo .profile-icon-container {
            padding: 10px;
            padding-right: 0px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .userInfo .profile-icon {
            font-size: 20px;
        }
        .userInfo .settings-container {
            background-color: #ddd; /* Darker background for the icon */
            padding: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .userInfo .logout_container {
            background-color: #d0d0d0; /* Darker background for the icon */
            padding: 12px;
            padding-left: 0px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .userInfo .user-name-container {
            padding: 12px;
            font-size: 16px;
            display: flex;
            align-items: center;
        }
        .settings-icon {
            font-size: 20px;
            color: grey;
        }
        .logout-icon {
            font-size: 20px;
            color: grey;
            margin-left: 10px;
        }
    </style>
    <title>Document</title>
</head>
<body>
    <header>
        <div class="logo">
            <a href="customer_main.php">xxmarkt</a>
        </div>
        <form action="customer_main.php?" method="GET" class="search-container">
            <i class="fas fa-search search-icon"></i>
            <input type="text" name="keyword" id="searchBar" placeholder="Search for a product..." 
            <?= isset($_GET["keyword"]) ? "value='{$_GET['keyword']}'" :""  ?>>
        </form>
        <div class="cartInfo">
            <a href="customer_cart.php">
                <div class="cart-icon-container">
                    <i class="fas fa-shopping-bag cart-icon"></i>
                </div>
                <div class="price-container">
                    <?php
                        $cartInfo = getCartInformation();
                        echo "₺{$cartInfo['total_price']}, {$cartInfo['item_cnt']}";
                    ?>
                </div>
            </a>
        </div>
        <div class="userInfo">
            <a href="customer_edit_profile.php">
                <div class="profile-icon-container">
                    <i class="fas fa-user profile-icon"></i>
                </div>
                <div class="user-name-container">
                    <span><?=$user["name"] ?></span>
                </div>
                <div class="settings-container">
                    <i class="fas fa-cog settings-icon"></i>
                </div>
            </a>
            <a href="logout.php?user=1">
                <div class="logout_container">
                <i class="fas fa-sign-out-alt logout-icon"></i>
                </div>
            </a>
        </div>
    </header>
</body>
</html>
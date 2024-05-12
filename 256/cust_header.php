<?php
if(isset($_SESSION["user"])){
    extract($_SESSION["user"]);
    // var_dump($_SESSION["user"]);
}
// var_dump($_COOKIE);

$cart=$_COOKIE["shoppingCart"] ?? [];

$cartItemCnt=0;
$cartPriceTotal=0;
$ar = getCartInformation();
var_dump($ar);
// $cartItemCnt=$ar['cart_itemCnt'];
// $cartPriceTotal=$ar['cart_total'];
// echo "price information: $cartItemCnt, $cartPriceTotal";
?>

<style>
    header{
        color:red;
        text-align: center;
        position: relative;
        border: 1px solid black;
        border-radius: 10px;
    }
    header .logo{ color: white; background-color: lightblue;}
    .logo a {text-decoration: none; color: blue; font-size: 30px; border: 1px solid black; border-radius: 10px;}
    #searchBar{border-radius: 10px; height: max-content; width: 300px;
    position: absolute; left: 200px; top: 10px;}
    #searchBar::placeholder{font-size: large;}
    .userInfo{position: absolute; right: 30px;}
    .userInfo div{border: 1px solid black; border-radius: 10px;}
    #profile{width: 30px;}
    .cartInfo{position: absolute; right: 150px; top: 10px;}


</style>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="path/to/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
</head>
<body>
    <header>
        <table>
            <tr>
                <td class="logo">
                    <div><span><a href="?">xxmarkt</a></span></div>
                </td>
                <td>
                    <form action="main.php" method="post">
                        <input type="text" name="searchVal" id="searchBar" placeholder="Apple">
                    </form>
                </td>
                <td class="cartInfo">
                        <?php
                            $itemCnt=getCartInformation()['cart_itemCnt'];
                             echo "<a href='checkout.php'>$itemCnt</a>";
                        ?>
                </td>
                
                <td class="userInfo">
                    <a href="">
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
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

    //generate shopping cart if it is not set
    if(!isset($_SESSION["customer_user"]["cart"])){
        $_SESSION["customer_user"]["cart"] = [];
    }
    $user = &$_SESSION["customer_user"];
    $cart =$_SESSION["customer_user"]["cart"];

    if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["remove"])){
        $remove = $_GET["remove"];
        removeFromCart($remove);
        header("location: ?");
    }

    if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["add"])){
        $add = $_GET["add"];
        incrementCartItemQuantity($add);
        header("location: ?");
    }

    if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["decrease"])){
        $decrease = $_GET["decrease"];
        decrementCartItemQuantity($decrease);
        header("location: ?");
    }

    if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["purchase"])){
        purchaseCart();
        header("location: customer_main.php");
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .market_products{max-width: 900px; position: relative;}
        .market_product{border: 1px solid black;  display: flex; padding: 10px;}
        .market_product:first-of-type{border-top-left-radius: 10px; border-top-right-radius: 10px;}
        .market_product:last-of-type{border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;}
        .market_product .imgdiv{width: 90px;}
        .market_prod_img{max-width: 90px; max-height: 90px;}
        /* .market_product_price{position: absolute; right: 50px;} */
        .market_product .stock{position: absolute; right: 50px;}
        /* .market_product .edit{} */
        .market_product_table_cell{margin: 50px;}
        /* .market_product .last{position: absolute; right: 10px;} */
        .market_product td{width: 120px;}
        .expired{background-color: lightcoral;}
        .safe{background-color: lightgreen;}
        #a{display: fl;}
    </style>
</head>
<body>
<div id="a">
<section class="market_products">
    <h3> Products</h3>
    <?php
    // var_dump($products);
    foreach ($cart as $productId => $count){ 
        $p = getProductDetailed($productId)?>
        <?php 
            // var_dump(strtotime($p["product_exp_date"]));
            // var_dump(time());
            // var_dump(time() > strtotime($p["product_exp_date"]));
            $t = time() + 60*60*24*4;
            // var_dump(strtotime($p["product_exp_date"]) -time());
            ?>
        <div class="market_product <?= strtotime($p["product_exp_date"]) >= $t ? "safe" : ""?>">
        <div class="imgdiv">
            <img src="./images/<?=$p["product_image"] ?>" alt="" class="market_prod_img">
        </div>
        <div>
            <table >
                <tr>
                    <td>
                        <p>Title</p>
                        <span class="market_product_title"><?=$p["product_title"] ?></span>
                    </td>
                    <td>
                        <p>Total Price</p>
                        <span class="market_product_price"> <?= isUpcomingProduct($productId) ? $p["product_disc_price"] * $count : $p["product_price"] *$count?>
                        TL <?= isUpcomingProduct($productId) ? "(discount applied)"  :""?> </span>
                        
                    </td>
                    <td>
                        <p>Expiration_date:</p>
                        <span class="market_product_exp_date"> <?=$p["product_exp_date"] ?></span>
                    </td>
                    <td >
                        <p>District</p>
                        <span class="market_product_disc_price"> <?=$p["district"] ?></span>
                    </td>
                    <td>
                        <p>Quanity</p>
                        <span><?= $count?></span>
                    </td>
                    <td class="last">
                        <p><a href="?remove=<?=$productId ?>"><span class="remove">Remove</span></a></p>
                        <p>
                            <a href="?add=<?=$p["product_id"] ?>"><span class="remove">+</span></a>
                            <a href="?decrease=<?=$p["product_id"] ?>"><span class="remove">-</span></a>
                        </p>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <?php  }?>
</section>
<div>
    <!-- checkout screen -->
    <h3>Total: <?= calculateTotal()?> TL</h3>
    <p><a href="?purchase=1">Purchase Items</a></p>
    <a href="customer_main.php">main</a>
</div>

</div>
</body>
</html>
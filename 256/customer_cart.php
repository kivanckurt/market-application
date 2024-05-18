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
    require_once "customer_header.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .market_products {
            max-width: 900px;
            margin: auto;
            margin-top: 100px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: #f9f9f9;
        }

        .market_products h3 {
            text-align: center;
            font-size: 2rem;
            margin-bottom: 20px;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .market_products h3::before,
        .market_products h3::after {
            content: '';
            flex: 1;
            border-bottom: 2px solid #333;
            margin: 0 20px;
        }

        .market_products table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .market_products table th,
        .market_products table td {
            padding: 10px;
            vertical-align: middle;
            text-align: center;
        }

        .market_products table th {
            background-color: #f1f1f1;
            font-weight: bold;
        }

        .market_product {
            border-bottom: 1px solid #ddd;
        }

        .market_product:last-of-type {
            border-bottom: none;
        }

        .market_prod_img {
            max-width: 90px;
            max-height: 90px;
            object-fit: cover;
        }

        .market_product_title {
            display: block;
            margin-top: 10px;
        }

        .market_product_price,
        .market_product_exp_date,
        .market_product_district,
        .market_product_stock {
            display: block;
        }

        .actions {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .actions a {
            margin: 0 5px;
            text-decoration: none;
            color: #333;
            font-size: 1.5rem;
        }

        .actions a:hover {
            color: #007BFF;
        }

        .quantity-adjust {
            display: inline-block;
            margin: 0 5px;
            cursor: pointer;
        }

        .quantity-adjust:hover {
            color: #007BFF;
        }

        .quantity {
            display: inline-block;
            width: 30px;
            text-align: center;
        }

        .remove {
            font-size: 1.5rem; /* Make the trash icon bigger */
            color: #ff0000;
            cursor: pointer;
            display: flex;
            justify-content: center; /* Center the icon */
            align-items: center;     /* Center the icon */
        }

        .remove:hover {
            color: #cc0000;
        }

        .total {
            text-align: center;
            font-size: 1.5rem;
            margin-top: 20px;
        }

        .purchase-button {
            display: block;
            text-align: center;
            margin-top: 10px;
            font-size: 1.2rem;
            margin-bottom: 30px;
        }

        .purchase-button a {
            text-decoration: none;
            color: #fff;
            background-color: #6038b4;
            padding: 10px 20px;
            border-radius: 5px;
        }

        .purchase-button a:hover {
            background-color: #301c5a;
        }


    </style>
</head>
<body>
<div id="a">
<section class="market_products">
    <h3>Shopping Cart</h3>
    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Total Price</th>
                <th>Expiration Date</th>
                <th>District</th>
                <th>Stock</th>
                <th>Quantity</th>
                <th>Remove</th>
            </tr>
        </thead>
        <tbody>
        <?php
        foreach ($cart as $productId => $count) { 
            $p = getProductDetailed($productId);
            $t = time() + 60*60*24*4;
            $isSafe = strtotime($p["product_exp_date"]) >= $t;
            ?>
            <tr class="market_product <?= $isSafe ? 'safe' : 'expired' ?>">
                <td>
                    <img src="./images/<?= $p["product_image"] ?>" alt="" class="market_prod_img">
                    <p class="market_product_title"><?= $p["product_title"] ?></p>
                </td>
                <td>
                    <p class="market_product_price"> <?= isUpcomingProduct($productId) ? $p["product_disc_price"] * $count : $p["product_price"] * $count ?>
                    TL <?= isUpcomingProduct($productId) ? "(discount applied)"  : "" ?> </p>
                </td>
                <td>
                    <p class="market_product_exp_date"><?= $p["product_exp_date"] ?></p>
                </td>
                <td>
                    <p class="market_product_district"><?= $p["district"] ?></p>
                </td>
                <td>
                    <p class="market_product_stock"><?= $p["stock"] ?></p>
                </td>
                <td>
                    <div class="actions">
                        <a href="?add=<?= $p["product_id"] ?>"  <?= $count >= getStock($productId) ? " hidden" : 'class="quantity-adjust"' ?>>+</a>
                        <span class="quantity"><?= $count ?></span>
                        <a href="?decrease=<?= $p["product_id"] ?>" class="quantity-adjust">-</a>
                    </div>
                </td>
                <td>
                    <a href="?remove=<?= $productId ?>"><i class="fa-solid fa-trash fa-xl"></i></a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</section>
<div class="total">
    <h3>Total: <?= calculateTotal() ?> TL</h3>
    <div class="purchase-button">
        <a href="?purchase=1">Purchase Items</a>
    </div>
    <div class="purchase-button">
        <a href="customer_main.php">Return To Homepage</a>
    </div>
</div>
</div>
</body>
</html>
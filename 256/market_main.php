<?php
    session_start();
    require "db.php";

    //if not authenticated, redirect to main page
    if(!isAuthenticated()){
        header("location: market_login.php");
        exit;
    }
    $user = $_SESSION["market_user"];
    $query_expired_products ="SELECT products.product_id, product_title, product_price, product_disc_price,
        product_exp_date, product_image, stock, market_name, market_user.email
        FROM products, stocks, market_user
        WHERE products.product_id = stocks.product_id
        AND stocks.email = market_user.email
        AND market_user.email = ?
        AND products.product_exp_date< sysdate()
        ORDER BY ?
        LIMIT 0,4;
        ";
    if($_SERVER["REQUEST_METHOD"]=="GET"){
        $stmt = $db->prepare($query_expired_products);
        $stmt->execute([$user["email"], "products.product_exp_date"]);
        $products = $stmt ->fetchAll();
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="app.css">
    <style>
        .market_products{max-width: 900px; position: relative;}
        .market_product{border: 1px solid black; border-radius: 10px; display: flex;}
        .market_prod_img{width: 90px;}
        /* .market_product_price{position: absolute; right: 50px;} */
        .market_product .stock{position: absolute; right: 50px;}
        /* .market_product .edit{} */
        .market_product_table_cell{margin: 50px;}
        .market_product .last{position: absolute; right: 10px;}
        .market_product td{width: 120px;}
        
    </style>
</head>
<body>
    <?php require_once "market_user_header.php"; ?>
    <div class="alert">
        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
        <strong>Danger!</strong> Indicates a dangerous or potentially negative action.
    </div>
    <p><a href="logout.php">Log out</a></p>

    <section class="market_products">
        <h3>Expired Products</h3>
        <?php foreach ($products as $p){ ?>
            <div class="market_product">
            <div >
                <img src="./images/<?=$p["product_image"] ?>" alt="" class="market_prod_img">
            </div>
            <div>
                <table>
                    <tr>
                        <td>
                            <p>Title</p>
                            <span class="market_product_title"><?=$p["product_title"] ?></span>
                        </td>
                        <td>
                            <p>Price</p>
                            <span class="market_product_price"> <?=$p["product_price"] ?>TL</span>
                        </td>
                        <td>
                            <p>Expiration_date:</p>
                            <span class="market_product_exp_date"> <?=$p["product_exp_date"] ?></span>
                        </td>
                        <td>
                            <p>Discounted Price:</p>
                            <span class="market_product_disc_price"> <?=$p["product_disc_price"] ?></span>
                        </td>
                        <td>
                            <p>Stock: </p>
                            <span>5</span>
                        </td>
                        <td class="last">
                            <p><a href=""><span class="remove">Remove</span></a></p>
                            <p><a href="market_edit_product.php?product_id=<?=$p["product_id"] ?>"><span class="edit">Edit</span></a></p>
                        </td>
                    </tr>
                </table>

            </div>
        </div>
        <?php  }?>
    </section>

</body>
</html>
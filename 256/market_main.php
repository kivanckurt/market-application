<?php
    session_start();
    require_once "db.php";

    //if not authenticated, redirect to main page
    if(!isAuthenticated()){
        header("location: market_login.php");
        exit;
    }

    $user = $_SESSION["market_user"];
    var_dump($user);

    //Getting the number of products & pages
    $query ="SELECT COUNT(*) FROM products, market_user where products.market_email = market_user.email AND market_user.email = ?;";
    $stmt = $db->prepare($query);
    $stmt->execute([$user["email"]]);
    $prodCnt = $stmt ->fetch()[0] ;
    $pageCnt = ceil($prodCnt /4);
    // var_dump($pageCnt);
    $page= $_GET["page"] ?? 1;
    $firstItemIndex = ($page-1)*4;
    // var_dump($firstItemIndex);

    //Get Query
    $order_by_param = "products.product_exp_date";
    $query_products ="SELECT * FROM products, market_user where products.market_email = market_user.email
        AND market_user.email = ? ORDER BY $order_by_param LIMIT ?,4 ;";
    if($_SERVER["REQUEST_METHOD"]=="GET"){
        $stmt = $db->prepare($query_products);
        $stmt->bindParam(1, $user["email"], PDO::PARAM_STR);
        $stmt->bindParam(2, $firstItemIndex, PDO::PARAM_INT);
        $stmt->execute();
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
        .market_product{border: 1px solid black;  display: flex; padding: 10px;}
        .market_product:first-of-type{border-top-left-radius: 10px; border-top-right-radius: 10px;}
        .market_product:last-of-type{border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;}
        .market_product .imgdiv{width: 90px;}
        .market_prod_img{max-width: 90px; max-height: 90px;}
        /* .market_product_price{position: absolute; right: 50px;} */
        .market_product .stock{position: absolute; right: 50px;}
        /* .market_product .edit{} */
        .market_product_table_cell{margin: 50px;}
        .market_product .last{position: absolute; right: 10px;}
        .market_product td{width: 120px;}
        .expired{background-color: lightcoral;}
        .safe{background-color: lightgreen;}
    </style>
</head>
<body>
    <?php require "market_user_header.php"; ?>
    <!-- <div class="alert">
        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
        <strong>Danger!</strong> Indicates a dangerous or potentialheanegative action.
    </div> -->
    <p><a href="logout.php?user=0">Log out</a></p>

    <section class="market_products">
        <h3> Products</h3>
        <?php foreach ($products as $p){ ?>
            <?php 
                // var_dump(strtotime($p["product_exp_date"]));
                // var_dump(time());
                // var_dump(time() > strtotime($p["product_exp_date"]));
                ?>
            <div class="market_product <?= strtotime($p["product_exp_date"]) <= time() ? "expired" : ""?>">
            <div class="imgdiv">
                <img src="./images/<?=$p["product_image"] ?>" alt="" class="market_prod_img">
            </div>
            <div>
                <table >
                    <tr >
                        <td>
                            <p>Title</p>
                            <span class="market_product_title"><?=$p["product_title"] ?></span>
                        </td>
                        <td>
                            <p>Price</p>
                            <span class="market_product_price"> <?=$p["product_price"] ?>TL</span>
                        </td>
                        <td <?= strtotime($p["product_exp_date"]) <= time() ? "class ='expired'" : ""?>>
                            <p>Expiration_date:</p>
                            <span class="market_product_exp_date"> <?=$p["product_exp_date"] ?></span>
                        </td>
                        <td >
                            <p>Discounted Price:</p>
                            <span class="market_product_disc_price"> <?=$p["product_disc_price"] ?></span>
                        </td>
                        <td>
                            <p>Stock: </p>
                            <span><?= $p["stock"]?></span>
                        </td>
                        <td class="last">
                            <p><a href="market_remove_product.php?product_id=<?=$p["product_id"] ?>"><span class="remove">Remove</span></a></p>
                            <span><a href="market_edit_product.php?product_id=<?=$p["product_id"] ?>"><span class="edit">Edit</span></a></span>
                        </td>
                    </tr>
                </table>

            </div>
        </div>
        <?php  }?>
        <div>
        <?php
            for($i=1; $i<$pageCnt+1; $i++){
                echo "  <a href='?page=$i'>$i</a>  ";
            }
        ?>
        </div>

    </section>

</body>
</html>
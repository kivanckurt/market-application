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

    //generate shopping cart if it is not set
    if(!isset($_SESSION["customer_user"]["shoppingCart"])){
        $_SESSION["customer_user"]["cart"] = [];
    }

    $query ="SELECT COUNT(*) FROM products, market_user where products.market_email = market_user.email
    AND market_user.email = ? AND products.product_exp_date> sysdate() AND stock>0;";
    $stmt = $db->prepare($query);
    $stmt->execute([$user["email"]]);
    $prodCnt = $stmt ->fetch()[0] ;
    $pageCnt = ceil($prodCnt /4);
    // var_dump($pageCnt);
    $page= $_GET["page"] ?? 1;
    $firstItemIndex = ($page-1)*4;

    $getQuery = "SELECT * FROM products, market_user
    WHERE products.market_email = market_user.email AND market_user.city = ?
    AND products.product_exp_date> sysdate() AND stock>0 
    ORDER BY (CASE district WHEN ? THEN 1 ELSE 0 END) DESC,
    district DESC LIMIT ?,4; ";
    var_dump($user);
    if($_SERVER["REQUEST_METHOD"]=="GET"){
        $stmt = $db->prepare($getQuery);
        $stmt->bindParam(1, $user["city"], PDO::PARAM_STR);
        $stmt->bindParam(2, $user["district"], PDO::PARAM_STR);
        $stmt->bindParam(3, $firstItemIndex, PDO::PARAM_INT);
        $stmt->execute();
        $products = $stmt ->fetchAll();
        // var_dump($products);
    }

    if($_SERVER["REQUEST_METHOD"]=="GET" && isset($addCart)){
        updateCart($addCart,1);
    }


    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* .navbar{
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
            
        } */
    </style>
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

<?php
if(isset($_SESSION["customer_user"])){
    extract($_SESSION["customer_user"]);
    // var_dump($_SESSION["market_user"]);
    $user = $_SESSION["customer_user"];
}
require_once "customer_header.php";
?>
<!-- <h1><?=$user["name"]?></h1>
<h1><?=$user["email"]?></h1>
<h1><?=$user["city"]?></h1>
<h1><?=$user["city"]?></h1>
<h1><?=$user["district"]?></h1>
<h1><?=$user["address"]?></h1>
<h1><?=$user["remember"]?></h1>
<h1><?=$user["profile"]?></h1> -->
<p><a href="logout.php">Log out</a></p>
<?php var_dump($_SESSION) ?>
<?php var_dump($_COOKIE) ?>
<p><a href="logout.php">Log out</a></p>

<section class="market_products">
    <h3> Products</h3>
    <?php
    var_dump($products);
    foreach ($products as $p){ ?>
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
                        <p>District</p>
                        <span class="market_product_disc_price"> <?=$p["district"] ?></span>
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
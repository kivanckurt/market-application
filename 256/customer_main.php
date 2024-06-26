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

    //get method operations
    if($_SERVER["REQUEST_METHOD"]=="GET"){
        //var_dump($_GET);    
        extract($_GET);
        $keyword = $keyword ?? "";
        $cleanedKeyword = str_replace('%', '', $keyword);
        $formedKeyword ='%'.$cleanedKeyword.'%';
        //var_dump($keyword);
        //var_dump($formedKeyword);
    }

    if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["decrease"])){
        $decrease = $_GET["decrease"];
        decrementCartItemQuantity($decrease);
        header("location: ?");
    }

    if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["increment"])){
        $add = $_GET["increment"];
        incrementCartItemQuantity($add);
        header("location: ?");
    }

    if($_SERVER["REQUEST_METHOD"]=="GET" && isset($_GET["add"])){
        echo "<h1>GET METHOD </h1>";
        $addCart = $_GET["add"];
        updateCart($addCart,1);
        header("location: customer_main.php");
    }

    //getting product count for pagination operations
    $queryProductCount ="SELECT COUNT(*) FROM products, market_user where products.market_email = market_user.email
    AND market_user.city = ? AND products.product_exp_date> sysdate() AND stock>0 and product_title LIKE ?; ";
    $stmt = $db->prepare($queryProductCount);
    $stmt->execute([$user["city"],$formedKeyword]);
    $prodCnt = $stmt ->fetch()[0];
    $pageCnt = ceil($prodCnt /4);
    $page= $_GET["page"] ?? 1;
    $firstItemIndex = ($page-1)*4;
    // var_dump($firstItemIndex);


    $getQuery = "SELECT * FROM products, market_user
    WHERE products.market_email = market_user.email AND market_user.city = ?
    AND products.product_exp_date> sysdate() AND stock>0 AND product_title LIKE ?
    ORDER BY (CASE district WHEN ? THEN 1 ELSE 0 END) DESC,
    district DESC LIMIT ?,4; ";

    if($_SERVER["REQUEST_METHOD"]=="GET"){
        $stmt = $db->prepare($getQuery);
        $stmt->bindParam(1, $user["city"], PDO::PARAM_STR);
        $stmt->bindParam(2, $formedKeyword, PDO::PARAM_STR);
        $stmt->bindParam(3, $user["district"], PDO::PARAM_STR);
        $stmt->bindParam(4, $firstItemIndex, PDO::PARAM_INT);
        $stmt->execute();
        $products = $stmt ->fetchAll();
        // var_dump($products);
    }


    //var_dump($cart);
    require_once "customer_header.php";


    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Page</title>
<style>
:root {
    --primary-color: #43a047;
    --secondary-color: #388e3c;
    --font-color: #333;
    --secondary-font-color: #757575;
    --background-color: #fff;
    --box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    --transition-duration: 0.3s;
}

.products-heading {
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: var(--font-color);
    margin: 40px 0 35px;
    position: relative;
}

.products-heading::before,
.products-heading::after {
    content: '';
    flex: 1;
    border-bottom: 2px solid var(--font-color);
    margin: 0 20px;
}

body {
    font-family: Arial, sans-serif;
}

.market_products {
    max-width: 1200px;
    margin: 20px auto;
    padding: 10px;
    background: var(--background-color);
    border-radius: 10px;
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
}

.market_product {
    border: 1px solid #ddd;
    border-radius: 10px;
    width: calc(25% - 20px);
    padding: 15px;
    box-sizing: border-box;
    box-shadow: var(--box-shadow);
    position: relative;
    text-align: center;
    transition: transform var(--transition-duration);
}

.market_product:hover {
    transform: translateY(-5px);
}

.market_product img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 10px;
}

.discount_tag {
    position: absolute;
    top: 0;
    right: 0;
    width: 100px;
    height: 100px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.discount_tag img {
    object-fit: contain;
}

.market_product h4 {
    margin: 15px 0 10px;
    font-size: 1.25rem;
    color: var(--font-color);
}

.market_product p {
    margin: 10px 0;
    color: var(--secondary-font-color);
}

.market_product .price {
    font-size: 1.125rem;
    color: #e53935;
}

.market_product .price .original_price {
    text-decoration: line-through;
    margin-right: 10px;
    color: var(--secondary-font-color);
}

.market_product .stock {
    font-size: 1rem;
    color: var(--primary-color);
}

.market_product .expiration_date,
.market_product .district {
    font-size: 0.875rem;
    color: var(--secondary-font-color);
}

.add_to_cart {
    display: inline-block;
    padding: 10px 20px;
    background: #38b460;
    color: #fff;
    border-radius: 5px;
    text-decoration: none;
    margin-top: 15px;
    transition: background var(--transition-duration);
}

.add_to_cart:hover {
    background: var(--secondary-color);
}

.pagination {
    text-align: center;
    margin-top: 20px;
}

.pagination a {
    display: inline-block;
    padding: 10px 15px;
    margin: 5px;
    background: #fff;
    border: 1px solid #ddd;
    color: var(--font-color);
    text-decoration: none;
    border-radius: 5px;
    transition: background var(--transition-duration), color var(--transition-duration);
}

.pagination a.active {
    background: var(--primary-color);
    color: #fff;
}

.pagination a:hover {
    background: #ddd;
    color: var(--font-color);
}

.arrow {
    display: inline-block;
    width: 30px;
    height: 30px;
    text-align: center;
    line-height: 30px;
    border-radius: 50%;
    background: var(--primary-color);
    color: #fff;
    text-decoration: none;
    margin: 0 10px;
    transition: background var(--transition-duration);
}

.arrow:hover {
    background: var(--secondary-color);
}

a.disabled {
  pointer-events: none;
  cursor: default;
}


.actions {
    display: inline-block;
    align-items: center;
    justify-content: center;
    background-color: #f0f0f0;
    border-radius: 5px;
    padding: 5px 10px;
    margin-top: 10px;
}

.add_to_decrease,
.add_to_increase {
    display: inline-block;
    background-color: #d3d3d3;
    color: #333;
    text-align: center;
    width: 30px;
    height: 30px;
    line-height: 30px;
    border-radius: 5px;
    text-decoration: none;
    margin: 0 5px;
    transition: background-color 0.3s ease;
    font-weight: bold;
}

.add_to_decrease:hover,
.add_to_increase:hover {
    background-color: #b3b3b3;
}

.quantity {
    font-size: 1.2em;
    padding: 0 10px;
    color: #333;
}


</style>


</head>
<body>
    <?php if (isset($_SESSION["customer_user"])): ?>
        <?php extract($_SESSION["customer_user"]); ?>
    <?php endif; ?>

    <h2 class="products-heading">
        <?php if (isset($keyword) && !empty($keyword)): ?>
            Displaying results for search term: "<?= htmlspecialchars($keyword) ?>"
        <?php else: ?>
            Products
        <?php endif; ?>
    </h2>

    <section class="market_products">
        <?php foreach ($products as $p): ?>
            <div class="market_product">
                <?php $productId = $p["product_id"]; ?>
                <?php $hasDiscount = isUpcomingProduct($productId); ?>
                <?php $isSafe = strtotime($p["product_exp_date"]) >= time() + 60*60*24*4; ?>
                <?php if ($hasDiscount): ?>
                    <div class="discount_tag">
                        <span class="discount_icon"><img src="./images/discount.png"></span>
                    </div>
                <?php endif; ?>
                <img src="./images/<?= $p["product_image"] ?>" alt="Product Image" class="market_prod_img">
                <h4><?= $p["product_title"] ?></h4>
                <p class="price">
                    <?php if ($hasDiscount): ?>
                        <span class="original_price"><?= $p["product_price"] ?> TL</span> <?= $p["product_disc_price"] ?> TL
                    <?php else: ?>
                        <?= $p["product_price"] ?> TL
                    <?php endif; ?>
                </p>
                <p class="expiration_date">Expires on: <?= $p["product_exp_date"] ?></p>
                <p class="stock">Stock: <?= $p["stock"] ?></p>
                <p class="district"><?= $p["market_name"] ?></p>
                <?php if (isInCart($p["product_id"])): ?>
                    <div class="actions">
                        <a href="?decrease=<?= $p["product_id"] ?>" class="add_to_decrease">-</a>
                        <span class="quantity"><?= $cart[$p["product_id"]] ?></span>
                        <a href="?increment=<?= $p["product_id"] ?>" class="add_to_increase" style="<?= $cart[$p["product_id"]] >= getStock($p["product_id"]) ? 'visibility:hidden;' : '' ?>">+</a>
                    </div>
                <?php else: ?>
                    <a href="?add=<?= $p["product_id"] ?>" class="add_to_cart">Add To Cart</a>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </section>

    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="?page=<?= $page - 1 ?><?=$keyword == "" ? "" :"&keyword=$cleanedKeyword"?>" class="arrow">&laquo;</a>
        <?php endif; ?>
        <?php for ($i = 1; $i <= $pageCnt; $i++): ?>
            <a href="?page=<?= $i ?><?=$keyword == "" ? "" :"&keyword=$cleanedKeyword"?>" class="<?= $i == $page ? "active" : "" ?>"><?= $i ?></a>
        <?php endfor; ?>
        <?php if ($page < $pageCnt): ?>
            <a href="?page=<?= $page + 1 ?><?=$keyword == "" ? "" :"&keyword=$cleanedKeyword"?>" class="arrow">&raquo;</a>
        <?php endif; ?>
    </div>
</body>
</html>
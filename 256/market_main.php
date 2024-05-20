<?php
    session_start();
    require_once "db.php";
    //if not authenticated, redirect to main page
    if(!isAuthenticated()){
        header("location: market_login.php");
        exit;
    }

    $user = $_SESSION["market_user"];
    //var_dump($user);

    //Getting the number of products & pages
    // $query ="SELECT COUNT(*) FROM products, market_user where products.market_email = market_user.email AND market_user.email = ?;";
    // $stmt = $db->prepare($query);
    // $stmt->execute([$user["email"]]);
    // $prodCnt = $stmt ->fetch()[0] ;
    // $pageCnt = ceil($prodCnt /4);
    // // var_dump($pageCnt);
    // $page= $_GET["page"] ?? 1;
    // $firstItemIndex = ($page-1)*4;
    // var_dump($firstItemIndex);

    //Get Query


    if($_SERVER["REQUEST_METHOD"]=="GET"){
        extract($_GET);
        $keyword = $keyword ?? "";
        $cleanedKeyword = str_replace('%', '', $keyword);
        $sanitizedKeyword = htmlspecialchars($cleanedKeyword);
        $formedKeyword ='%'.$sanitizedKeyword.'%';
        $ar = ["active" => "and product_exp_date > CURDATE()","expired" => "and product_exp_date <= CURDATE()", "all" => ""];
        $orderBy = isset($orderBy)? $orderBy : "product_exp_date";


        //Some security impovements
        if(isset($_GET["sort"]) && $_GET["sort"]!="" && !in_array($_GET["sort"], ["asc","desc"])){
          header("location: baited.php");
        }
        if(isset($_GET["filter"]) && !array_key_exists($filter,$ar) ){
          //injection
          header("location: baited.php");
          exit;
        }

        $sort = isset($sort) ? $sort : "desc";
        $queryFilter = isset($filter) ? $ar[$filter] : "";
        $query_products ="SELECT * FROM products, market_user where products.market_email = market_user.email
            AND market_user.email = ? and product_title LIKE ? $queryFilter ORDER BY $orderBy $sort;";
        $stmt = $db->prepare($query_products);
        $stmt->bindParam(1, $user["email"], PDO::PARAM_STR);
        $stmt->bindParam(2, $formedKeyword, PDO::PARAM_STR);
        if(in_array($sort,["asc","desc"])){
          $stmt->execute();
        }
        $products = $stmt ->fetchAll();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_product'])) {
      // Check if the user has confirmed deletion
      if (isset($_POST['confirm_delete'])) {
          // Process deletion of the product
          // You can add your deletion logic here
          // For example, you might delete the product from the database
          // Once deletion is done, you can redirect the user or display a success message
          // For demonstration purposes, I'll assume the product is deleted and redirect the user
          header("Location: market_main.php?message='Product deleted successfully'");
          exit;
      } else {
          // If the user hasn't confirmed deletion, redirect back to the main page
          header("Location: market_main.php");
          exit;
      }
  }



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/c3e04cab36.js" crossorigin="anonymous"></script>
    <title>Document</title>
    <link rel="stylesheet" href="marketmain.css">
</head>
<body>
<?php require "market_user_header.php"; ?>
<div class="app-container">
  
  <div class="app-content">
    <div class="app-content-header">
      <h1 class="app-content-headerText">Products</h1>
      <button class="app-content-headerButton" onclick="location.href='market_add_product.php'">Add Product</button>
    </div>
    <div class="app-content-actions">
      <form action="" method="get">
        <input class="search-bar" placeholder="Search..." type="text" name="keyword" value="<?=$keyword?>">
        <?php if(isset($_GET["filter"]) && array_key_exists($filter,$ar)){
          echo "<input type='hidden' name='filter' value='$filter'>";
        } ?>
      </form>
      <div class="app-content-actions-wrapper">
        <div class="filter-button-wrapper">
          <button class="action-button filter jsFilter"><span>Filter</span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-filter"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg></button>
          <div class="filter-menu">
            <label>Status</label>
            <form action="" method="get">
            <select name="filter">
              <option value="all">All Status</option>
              <option value="active">Active</option>
              <option value="expired">Expired</option>
            </select>
            <div class="filter-menu-buttons">
              <button class="filter-button apply" type="submit">
                Apply
              </button>
              <button class="filter-button reset">
                Reset
              </button>
              <?php if($keyword != ""){
                    echo "<input type='hidden' name='keyword' value='$cleanedKeyword'>";
                    } ?>
              </form>
              </form>
            </div>
          </div>
        </div>
        <button class="action-button list active" title="List View">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-list"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
        </button>
        <button class="action-button grid" title="Grid View">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-grid"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
        </button>
      </div>
    </div>
    <div class="products-area-wrapper tableView">
      <div class="products-header">
        <div class="product-cell image"> Items<a href="?orderBy=product_title&sort=<?=$sort=="desc" ? "asc" : "desc"?><?=isset($filter) == "" ? "" :"&filter=$filter"?><?=$keyword == "" ? "" :"&keyword=$cleanedKeyword"?>"><button class="sort-button">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 512 512"><path fill="currentColor" d="M496.1 138.3L375.7 17.9c-7.9-7.9-20.6-7.9-28.5 0L226.9 138.3c-7.9 7.9-7.9 20.6 0 28.5 7.9 7.9 20.6 7.9 28.5 0l85.7-85.7v352.8c0 11.3 9.1 20.4 20.4 20.4 11.3 0 20.4-9.1 20.4-20.4V81.1l85.7 85.7c7.9 7.9 20.6 7.9 28.5 0 7.9-7.8 7.9-20.6 0-28.5zM287.1 347.2c-7.9-7.9-20.6-7.9-28.5 0l-85.7 85.7V80.1c0-11.3-9.1-20.4-20.4-20.4-11.3 0-20.4 9.1-20.4 20.4v352.8l-85.7-85.7c-7.9-7.9-20.6-7.9-28.5 0-7.9 7.9-7.9 20.6 0 28.5l120.4 120.4c7.9 7.9 20.6 7.9 28.5 0l120.4-120.4c7.8-7.9 7.8-20.7-.1-28.5z"/></svg>
          </button></a>
        </div>
        <div class="product-cell price">Price<a href="?orderBy=product_price&sort=<?=$sort=="desc" ? "asc" : "desc"?><?=isset($filter) == "" ? "" :"&filter=$filter"?><?=$keyword == "" ? "" :"&keyword=$cleanedKeyword"?>"><button class="sort-button">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 512 512"><path fill="currentColor" d="M496.1 138.3L375.7 17.9c-7.9-7.9-20.6-7.9-28.5 0L226.9 138.3c-7.9 7.9-7.9 20.6 0 28.5 7.9 7.9 20.6 7.9 28.5 0l85.7-85.7v352.8c0 11.3 9.1 20.4 20.4 20.4 11.3 0 20.4-9.1 20.4-20.4V81.1l85.7 85.7c7.9 7.9 20.6 7.9 28.5 0 7.9-7.8 7.9-20.6 0-28.5zM287.1 347.2c-7.9-7.9-20.6-7.9-28.5 0l-85.7 85.7V80.1c0-11.3-9.1-20.4-20.4-20.4-11.3 0-20.4 9.1-20.4 20.4v352.8l-85.7-85.7c-7.9-7.9-20.6-7.9-28.5 0-7.9 7.9-7.9 20.6 0 28.5l120.4 120.4c7.9 7.9 20.6 7.9 28.5 0l120.4-120.4c7.8-7.9 7.8-20.7-.1-28.5z"/></svg>
          </button></div></a>
        <div class="product-cell status-cell">Status<a href="?orderBy=product_exp_date&sort=<?=$sort=="desc" ? "asc" : "desc"?><?=isset($filter) == "" ? "" :"&filter=$filter"?><?=$keyword == "" ? "" :"&keyword=$cleanedKeyword"?>"><button class="sort-button">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 512 512"><path fill="currentColor" d="M496.1 138.3L375.7 17.9c-7.9-7.9-20.6-7.9-28.5 0L226.9 138.3c-7.9 7.9-7.9 20.6 0 28.5 7.9 7.9 20.6 7.9 28.5 0l85.7-85.7v352.8c0 11.3 9.1 20.4 20.4 20.4 11.3 0 20.4-9.1 20.4-20.4V81.1l85.7 85.7c7.9 7.9 20.6 7.9 28.5 0 7.9-7.8 7.9-20.6 0-28.5zM287.1 347.2c-7.9-7.9-20.6-7.9-28.5 0l-85.7 85.7V80.1c0-11.3-9.1-20.4-20.4-20.4-11.3 0-20.4 9.1-20.4 20.4v352.8l-85.7-85.7c-7.9-7.9-20.6-7.9-28.5 0-7.9 7.9-7.9 20.6 0 28.5l120.4 120.4c7.9 7.9 20.6 7.9 28.5 0l120.4-120.4c7.8-7.9 7.8-20.7-.1-28.5z"/></svg>
          </button></div></a>
        <div class="product-cell sales">Expiration Date<a href="?orderBy=product_exp_date&sort=<?=$sort=="desc" ? "asc" : "desc"?><?=isset($filter) == "" ? "" :"&filter=$filter"?><?=$keyword == "" ? "" :"&keyword=$cleanedKeyword"?>"><button class="sort-button">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 512 512"><path fill="currentColor" d="M496.1 138.3L375.7 17.9c-7.9-7.9-20.6-7.9-28.5 0L226.9 138.3c-7.9 7.9-7.9 20.6 0 28.5 7.9 7.9 20.6 7.9 28.5 0l85.7-85.7v352.8c0 11.3 9.1 20.4 20.4 20.4 11.3 0 20.4-9.1 20.4-20.4V81.1l85.7 85.7c7.9 7.9 20.6 7.9 28.5 0 7.9-7.8 7.9-20.6 0-28.5zM287.1 347.2c-7.9-7.9-20.6-7.9-28.5 0l-85.7 85.7V80.1c0-11.3-9.1-20.4-20.4-20.4-11.3 0-20.4 9.1-20.4 20.4v352.8l-85.7-85.7c-7.9-7.9-20.6-7.9-28.5 0-7.9 7.9-7.9 20.6 0 28.5l120.4 120.4c7.9 7.9 20.6 7.9 28.5 0l120.4-120.4c7.8-7.9 7.8-20.7-.1-28.5z"/></svg>
          </button></div></a>
        <div class="product-cell category">Discounted Price<a href="?orderBy=product_disc_price&sort=<?=$sort=="desc" ? "asc" : "desc"?><?=isset($filter) == "" ? "" :"&filter=$filter"?><?=$keyword == "" ? "" :"&keyword=$cleanedKeyword"?>"><button class="sort-button">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 512 512"><path fill="currentColor" d="M496.1 138.3L375.7 17.9c-7.9-7.9-20.6-7.9-28.5 0L226.9 138.3c-7.9 7.9-7.9 20.6 0 28.5 7.9 7.9 20.6 7.9 28.5 0l85.7-85.7v352.8c0 11.3 9.1 20.4 20.4 20.4 11.3 0 20.4-9.1 20.4-20.4V81.1l85.7 85.7c7.9 7.9 20.6 7.9 28.5 0 7.9-7.8 7.9-20.6 0-28.5zM287.1 347.2c-7.9-7.9-20.6-7.9-28.5 0l-85.7 85.7V80.1c0-11.3-9.1-20.4-20.4-20.4-11.3 0-20.4 9.1-20.4 20.4v352.8l-85.7-85.7c-7.9-7.9-20.6-7.9-28.5 0-7.9 7.9-7.9 20.6 0 28.5l120.4 120.4c7.9 7.9 20.6 7.9 28.5 0l120.4-120.4c7.8-7.9 7.8-20.7-.1-28.5z"/></svg>
          </button></div></a>
        <div class="product-cell stock">Stock<a href="?orderBy=stock&sort=<?=$sort=="desc" ? "asc" : "desc"?><?=$keyword == "" ? "" :"&keyword=$cleanedKeyword"?>"><button class="sort-button">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 512 512"><path fill="currentColor" d="M496.1 138.3L375.7 17.9c-7.9-7.9-20.6-7.9-28.5 0L226.9 138.3c-7.9 7.9-7.9 20.6 0 28.5 7.9 7.9 20.6 7.9 28.5 0l85.7-85.7v352.8c0 11.3 9.1 20.4 20.4 20.4 11.3 0 20.4-9.1 20.4-20.4V81.1l85.7 85.7c7.9 7.9 20.6 7.9 28.5 0 7.9-7.8 7.9-20.6 0-28.5zM287.1 347.2c-7.9-7.9-20.6-7.9-28.5 0l-85.7 85.7V80.1c0-11.3-9.1-20.4-20.4-20.4-11.3 0-20.4 9.1-20.4 20.4v352.8l-85.7-85.7c-7.9-7.9-20.6-7.9-28.5 0-7.9 7.9-7.9 20.6 0 28.5l120.4 120.4c7.9 7.9 20.6 7.9 28.5 0l120.4-120.4c7.8-7.9 7.8-20.7-.1-28.5z"/></svg>
          </button></div></a>

      </div>
      <?php foreach ($products as $p){ ?>
      <div class="products-row">
         </button>
          <div class="product-cell image">
          <a href="./images/<?=$p["product_image"] ?>" ><img src="./images/<?=$p["product_image"] ?>" alt="product"></a>
            <span class="market_product_title"><?=$p["product_title"] ?></span>
          </div>
          <div class="product-cell price"><span class="cell-label">Price:</span><span class="market_product_price"> <?=$p["product_price"] ?>TL</span></div>
        <div class="product-cell status-cell">
          <span class="cell-label">Status:</span>
          <span class="status <?= strtotime($p["product_exp_date"]) <= time() ? "disabled" : "active"?>"><?= strtotime($p["product_exp_date"]) <= time() ? "Expired" : "Active"?></span>
        </div>
        <div class="product-cell sales"><span class="cell-label">Expiration Date:</span><span class="market_product_exp_date"> <?=$p["product_exp_date"] ?></span></div>
        <div class="product-cell category"><span class="cell-label">Discounted Price:</span><span class="market_product_disc_price"> <?=$p["product_disc_price"] ?></span></div>
        <div class="product-cell stock"><span class="cell-label">Stock:</span><span><?= $p["stock"]?></span></div>
        <button class="cell-edit" onclick='location.href="market_edit_product.php?product_id=<?= $p["product_id"] ?>"'>
            <i class="fa-solid fa-bars"></i>
            <button class="cell-remove" onclick="
              if (confirm('Are you sure you want to remove this item? <?=$p['product_title'] ?>')) {
                  window.location.href='market_remove_product.php?product_id=<?= $p['product_id'] ?>';
              }">
            <i class="fa-solid fa-trash"></i>

      </div>
      <?php  }?>
    </div>
  </div>
</div>
<script src="marketmain.js"></script>
</body>
</html>
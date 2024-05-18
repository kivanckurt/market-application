<?php
    session_start();
    require_once "db.php";
    $user = $_SESSION["market_user"];
    $upload_max_filesize = ini_get("upload_max_filesize");
    $post_max_size = ini_get("post_max_size") ;
  
    //echo "<p>Max Upload Filesize : $upload_max_filesize</p>" ;
  
    $error = [] ;
    if ( $_SERVER["REQUEST_METHOD"] == "POST" && empty($_POST)){
      $error[] = "Post Max Error" ;
    }

    if(!isset($_GET["product_id"]) or !isAuthenticated()){
        header("location: market_main.php");
        exit;
    }
    extract($_GET);
    extract(getProductDetailed($product_id));
    //var_dump((getProductDetailed($product_id)));
    if(!empty($_POST)){
        extract($_POST);
        //var_dump($_POST);
        $error=[];


        $product_title= htmlspecialchars($product_title);
        $product_id=htmlspecialchars($product_id);
        $product_disc_price=htmlspecialchars($product_disc_price);
        $product_price=htmlspecialchars($product_price);
        $stock=htmlspecialchars($product_price);

        if (!$product_title) {
            $error["product_title"]="Product title cannot be empty";
          }
          if (!$product_price) {
            $error["product_price"]="Product price cannot be empty";
          }
          if (!$product_disc_price) {
            $error["product_disc_price"]="Product discounted price cannot be empty";
          }
          if (!$stock) {
            $error["stock"]="Stock cannot be empty";
          }
          if ($product_price < $product_disc_price) {
            $error["price_comparison"]="Discounted price cannot be higher than default price";
          }



        if(empty($error)){

        
        foreach($_FILES as $fb => $file) {
            if ( $file["size"] == 0) {
                if ( empty($file["name"])) {
                    // var_dump($_POST);
                    updateProduct($user, $product_id, $product_title, $product_price, $product_disc_price,$product_exp_date,$product_stock, $product_image);
                } else {
                    $error["file"] = "{$file['name']} is greater than max upload size in '<b>$fb</b>'" ;
                } 
            } else {
                $allowedTypes = array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF);
                $detectedType = exif_imagetype($file['tmp_name']);
               if(in_array($detectedType, $allowedTypes)){
                move_uploaded_file($file["tmp_name"], "./images/" . $file["name"]) ;
                $product_image = $file["name"];
                updateProduct($user, $product_id, $product_title, $product_price, $product_disc_price,$product_exp_date,$product_stock, $product_image);
               }else{
                $error["file"]="Upload image file only!";
               }
            }
        } 
        }
    }
    //var_dump($error);
    

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="marketmain.css">
    <title>Document</title>
   <link rel="stylesheet" href="marketmain.css">
   
</head>
<body>
    <?php require "market_user_header.php"?>
    <section>
    <div style="margin: auto;  width: 90%; padding: 50px; ">

    <form action="" method="post" enctype="multipart/form-data">
        <h1>Edit Product</h1>
        <div class="nice-form-group">
          <label>Title</label>
          <input type="text" name="product_title" id=""value="<?= htmlspecialchars($product_title)?>">
        </div>

        <div class="nice-form-group">
          <label>Price</label>
          <input type="text" name="product_price" id=""value="<?= htmlspecialchars($product_price)?>" >
        </div>
        <div class="nice-form-group">
          <label>Discounted Price</label>
          <input type="text" name="product_disc_price" id=""value="<?= htmlspecialchars($product_disc_price)?>" >
        </div>

        <div class="nice-form-group">
                <label>Date</label>
                <input type="date" name="product_exp_date" id="" value="<?= htmlspecialchars($product_exp_date)?>">
        </div>

        <div class="nice-form-group">
          <label>Stock</label>
          <input type="number" name="product_stock" id="" maxlength="80px" value="<?= $product_stock ?? $stock ?>"/>
        </div>
        <div class="nice-form-group">
          <label>File upload</label>
          <input type="file" name="newImage" require />
        </div>
        <div class="app-content-submit">
            <button class="app-content-submitButton" type="submit">Submit</button>
        </div>
    </form>
        
        <?php if (isset($error)){ ?>
        <div class="errort">
            <?php if (isset($error["product_title"])){ ?>
                <p><?=$error["product_title"]?></p>
            <?php  }?>
            <?php if (isset($error["product_price"])){ ?>
                <p><?=$error["product_price"]?></p>
            <?php  }?>
            <?php if (isset($error["product_disc_price"])){ ?>
                <p><?=$error["product_disc_price"]?></p>
            <?php  }?>
            <?php if (isset($error["stock"])){ ?>
                <p><?=$error["stock"]?></p>
            <?php  }?>
            <?php if (isset($error["exist"])){ ?>
                <p><?=$error["exist"]?></p>
            <?php  }?>
            <?php if (isset($error["file"])){ ?>
                <p><?=$error["file"]?></p>
            <?php  }?>
        </div>
        <?php  }?>
        <?php if (isset($success)){ ?>
                <p><?=$success?></p>
        <?php  }?>



    </div>
    </section>

</body>
</html>
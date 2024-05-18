<?php
    session_start();
    require_once "db.php";
    $user = $_SESSION["market_user"];
    $upload_max_filesize = ini_get("upload_max_filesize");
    $post_max_size = ini_get("post_max_size") ;
  
    echo "<p>Max Upload Filesize : $upload_max_filesize</p>" ;
  
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
    var_dump($error);
    

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
   <link rel="stylesheet" href="app.css">
</head>
<body>
    <?php require "market_user_header.php"?>
    <section class="product">
    <div style="margin: auto;  width: 90%; padding: 50px; ">

    <form action="" method="post" enctype="multipart/form-data">
        <table>
        <tr>
            <td>Product ID</td>
            <td><input type="text" name="product_id" id="email" value="<?= $product_id ?>" readonly></td>
        </tr>
        <tr>    
            <td>Title</td>
            <td><input type="text" name="product_title" id=""value="<?= $product_title?>"></td>
        </tr>
        <tr>
            <td>Price</td>
            <td><input type="text" name="product_price" id=""value="<?= $product_price?>" ></td>
        </tr>
        <tr>
            <td>Discounted Price</td>
            <td><input type="text" name="product_disc_price" id=""value="<?= $product_disc_price?>" ></td>
        </tr>
        <tr>
            <td>Expiration Date</td>
            <td><input type="date" name="product_exp_date" id="" value="<?= $product_exp_date?>"></td>
        </tr>
        <tr>
            <td>Stock</td>
            <td><input type="number" name="product_stock" id="" value="<?= $product_stock ?? $stock?>"></td>
        </tr>

        <tr>
            <td>New Image:</td>
            <td><input type="file" name="newImage"></td>
        </tr>
        <tr>
            <td colspan="2"><button type="submit">Submit</button></td>
        </tr>
        </form>
        </table>
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
            <?php if (isset($error["file"])){ ?>
                <p><?=$error["file"]?></p>
            <?php  }?>
            <?php if (isset($error["price_comparison"])){ ?>
                <p><?=$error["price_comparison"]?></p>
            <?php  }?>
        </div>
        <?php  }?>
</body>
</html>
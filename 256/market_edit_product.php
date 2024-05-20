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
        foreach($_FILES as $fb => $file) {
            if ( $file["size"] == 0) {
                if ( empty($file["name"])) {
                    // var_dump($_POST);
                    updateProduct($user, $product_id, $product_title, $product_price, $product_disc_price,$product_exp_date,$product_stock, $product_image);
                } else {
                    $error[] = "{$file['name']} is greater than max upload size in '<b>$fb</b>'" ;
                } 
            } else {
                $allowedTypes = array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF);
                $detectedType = exif_imagetype($file['tmp_name']);
               if(in_array($detectedType, $allowedTypes)){
                move_uploaded_file($file["tmp_name"], "./images/" . $file["name"]) ;
                $product_image = $file["name"];
                updateProduct($user, $product_id, $product_title, $product_price, $product_disc_price,$product_exp_date,$product_stock, $product_image);
               }else{
                $error[]="Upload image file only!";
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
    <link rel="stylesheet" href="notification.css">
    <title>Document</title>

   
</head>
<body>
    <?php require "market_user_header.php"?>
    <style>
        body{overflow: visible;}
    </style>
    <section class="product">
    <div style="margin: auto;  width: 90%; padding: 50px; ">

        <form action="" method="post" enctype="multipart/form-data">
            <h1>Edit Product</h1>
            <div class="nice-form-group">
              <label>Title</label>
              <input type="text" name="product_title" id=""value="<?= htmlspecialchars($product_title)?>" required >
            </div>

            <div class="nice-form-group">
              <label>Price</label>
              <input type="text" name="product_price" id=""value="<?= htmlspecialchars($product_price)?>" required >
            </div>
            <div class="nice-form-group">
              <label>Discounted Price</label>
              <input type="text" name="product_disc_price" id=""value="<?= htmlspecialchars($product_disc_price)?>" required >
            </div>

            <div class="nice-form-group">
                    <label>Date</label>
                    <input type="date" name="product_exp_date" id="" value="<?= htmlspecialchars($product_exp_date)?>" required >
            </div>

            <div class="nice-form-group">
              <label>Stock</label>
              <input type="number" name="product_stock" id="" maxlength="80px" value="<?= $product_stock ?? $stock ?>" required />
            </div>
            <div class="nice-form-group">
              <label>File upload</label>
              <input type="file" name="newImage" />
            </div>
            <div class="app-content-submit">
                <button class="app-content-submitButton" type="submit">Submit</button>
            </div>
        </form>
    </div>
    </section>
    <div class="notf-container">
            <?php if (isset($error)) { ?>
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        <?php foreach ($error as $err) { ?>
                            var successMessage = "<?php echo $err; ?>";
                            flatNotify().error(successMessage, 5000);
                        <?php } ?>
                    });
                </script>
            <?php } ?>
            <?php if (isset($success)) { ?>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    var successMessage = "<?php echo $success; ?>";
                    flatNotify().success(successMessage, 2000);
                });
            </script>
            <?php } ?>
    </div>
    <script src="notification.js"></script>
</body>
</html>
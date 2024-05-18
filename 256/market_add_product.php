<?php
    require "db.php";
    session_start();
    if(!isAuthenticated()){
        header("location: market_main.php");
    }


    if($_SERVER["REQUEST_METHOD"] == "POST"){
        var_dump($_POST);
        extract($_POST);
        $error=[];

        $product_title= htmlspecialchars($product_title);
        $product_price= htmlspecialchars($product_price);
        $product_disc_price=htmlspecialchars($product_disc_price);
        $stock=htmlspecialchars($stock);
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
    }


    if(empty($error)){
    //create new product
    if($_SERVER["REQUEST_METHOD"]=="POST" && isset($product_title) && isset($product_price) && isset($product_disc_price)){
        //Form submitted
        if(getProductByTitle($product_title)){
            
            $error["exist"] = "Product already exists, please edit existing product";
        }else{
            foreach($_FILES as $fb => $file) {
                if ( $file["size"] == 0) {
                    if ( empty($file["name"])) {
                        // var_dump($_POST);
                        $error["file"] = "No file uploaded" ;
                    } else {
                        $error["file"] = "{$file['name']} is greater than max upload size in '<b>$fb</b>'" ;
                    } 
                } else {
                    $allowedTypes = array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF);
                    $detectedType = exif_imagetype($file['tmp_name']);
                   if(in_array($detectedType, $allowedTypes)){
                    move_uploaded_file($file["tmp_name"], "./images/" . $file["name"]) ;
                    $product_image = $file["name"];
                    $market_email = $_SESSION["market_user"]["email"];
                    createProduct($product_title,$product_price,$product_disc_price,$product_image,$product_exp_date,$stock,$market_email);
                    header("location: market_add_product.php");
                   }else{
                    $error["file"]="Upload image file only!";
                   
                   }
                }
             } 
        }
    }
    }
    // 
    // if($_SERVER["REQUEST_METHOD"]=="POST" && isset($select_product_id) && isset($product_exp_date) && isset($stock)){
    //     //If product already exists in market's inventory give alert. This section of the code may be changed in future.
    //     if(getProductDetailed($select_product_id)){
    //         $error[]= "Product already exists market's inventory";
    //     }else{
    //         createStock($select_product_id,$stock, $product_exp_date);
    //     }
    // }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .form{margin: 50px;}
        .formBody{display: flex;}
    </style>
</head>
<body>
<?php require "market_user_header.php"?>
    <section class="product">
    <div style="margin: auto;  width: 90%; padding: 50px; ">

    <form action="" method="post" enctype="multipart/form-data" >
        <h1>Add Product</h1>
        <div class="nice-form-group">
          <label>Title</label>
          <input type="text" name="product_title" id="" value="<?= isset($product_title) ? htmlspecialchars($product_title) : "" ?>"  />
        </div>

        <div class="nice-form-group">
          <label>Price</label>
          <input type="text" name="product_price" id="" value="<?=isset($product_price) ? htmlspecialchars($product_price) : "" ?>"  />
        </div>
        <div class="nice-form-group">
          <label>Discounted Price</label>
          <input type="text" name="product_disc_price" value="<?=isset($product_disc_price) ? htmlspecialchars($product_disc_price) : "" ?>" />
        </div>

        <div class="nice-form-group">
                <label>Date</label>
                <input type="date" name="product_exp_date" id="" value="<?=date('Y-m-d')?>" require />
        </div>

        <div class="nice-form-group">
          <label>Stock</label>
          <input type="number" name="stock" id="" maxlength="80px" value="<?=isset($stock) ? htmlspecialchars($stock): "" ?>"  />
        </div>
        <div class="nice-form-group">
          <label>File upload</label>
          <input type="file" />
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
            <?php if (isset($error["price_comparison"])){ ?>
                <p><?=$error["price_comparison"]?></p>
            <?php  }?>
        </div>
        <?php  }?>



    </div>

    <!-- Product selection form -->
    <!-- <div class="form">
        <form action="" method="post" enctype="multipart/form-data">
            <table>
                <tr>
                    <td colspan="2">
                    <label for="selectProduct">Choose a product:</label>
                    <select name="select_product_id" id="selectProduct">  
                    <?php
                        $products = getAllProductsAlphabetically();
                        foreach ($products as $p){
                            echo "<option value='{$p['product_id']}'>{$p['product_title']}</option>";
                        }
                    ?>
                    </select>

                    </td>
                </tr>
                    <td colspan="2"><button type="submit">Submit</button></td>
                </tr>
            </table>
        </form>
    </div> -->
    </section>
</body>
</html>
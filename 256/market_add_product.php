<?php
require "db.php";
session_start();
if (!isAuthenticated()) {
    header("location: market_main.php");
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["success"])) {
    $success = "Product is added successfully";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    extract($_POST);
    $error = [];
    if (!$product_title) {
        $error["product_title"] = "Product title cannot be empty";
    }
    if (!$product_price) {
        $error["product_price"] = "Product price cannot be empty";
    }
    if (!$product_disc_price) {
        $error["product_disc_price"] = "Product discounted price cannot be empty";
    }
    if (!$stock) {
        $error["stock"] = "Stock cannot be empty";
    }

    if (empty($error)) {
        if (isset($product_title) && isset($product_price) && isset($product_disc_price)) {
            if (getProductByTitle($product_title)) {
                $error["exist"] = "Product already exists, please edit existing product";
            } else {
                foreach ($_FILES as $fb => $file) {
                    if ($file["size"] == 0) {
                        if (empty($file["name"])) {
                            $error["file"] = "No file uploaded";
                        } else {
                            $error["file"] = "{$file['name']} is greater than max upload size in '<b>$fb</b>'";
                        }
                    } else {
                        $allowedTypes = [IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF];
                        $detectedType = exif_imagetype($file['tmp_name']);
                        if (in_array($detectedType, $allowedTypes)) {
                            move_uploaded_file($file["tmp_name"], "./images/" . $file["name"]);
                            $product_image = $file["name"];
                            $market_email = $_SESSION["market_user"]["email"];
                            createProduct($product_title, $product_price, $product_disc_price, $product_image, $product_exp_date, $stock, $market_email);
                            header("location: market_add_product.php?success=1");
                        } else {
                            $error["file"] = "Upload image file only!";
                        }
                    }
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="notification.css">
    <title>Document</title>
    <style>
        .form { margin: 50px; }
        .formBody { display: flex; }
    </style>
</head>
<body>
    <?php require "market_user_header.php"?>
    <style>
        body{overflow: visible;}
    </style>
    <section class="product">
        <div style="margin: auto; width: 90%; padding: 50px;">
            <form action="" method="post" enctype="multipart/form-data">
                <h1>Add Product</h1>
                <div class="nice-form-group">
                    <label>Title</label>
                    <input type="text" name="product_title" value="<?= isset($product_title) ? htmlspecialchars($product_title) : "" ?>"  />
                </div>
                <div class="nice-form-group">
                    <label>Price</label>
                    <input type="number" name="product_price" value="<?= isset($product_price) ? htmlspecialchars($product_price) : "" ?>" />
                </div>
                <div class="nice-form-group">
                    <label>Discounted Price</label>
                    <input type="number" name="product_disc_price" value="<?= isset($product_disc_price) ? htmlspecialchars($product_disc_price) : "" ?>" />
                </div>
                <div class="nice-form-group">
                    <label>Date</label>
                    <input type="date" name="product_exp_date" value="<?= date('Y-m-d') ?>" />
                </div>
                <div class="nice-form-group">
                    <label>Stock</label>
                    <input type="number" name="stock" value="<?= isset($stock) ? htmlspecialchars($stock) : "" ?>" />
                </div>
                <div class="nice-form-group">
                    <label>File upload</label>
                    <input type="file" name="file" />
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

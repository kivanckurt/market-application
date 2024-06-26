<?php

const DSN = "mysql:host=localhost;dbname=marketapplication;charset=utf8mb4" ;
const USER = "root" ;
const PASSWORD = "" ;

try {
   $db = new PDO(DSN, USER, PASSWORD) ; 
} catch(PDOException $e) {
     echo "Set username and password in 'db.php' appropriately" ;
     exit ;
}

function validateMarketUser($email, $password, &$user){
    global $db;
    $stmt = $db->prepare("SELECT * FROM `market_user` WHERE market_user.email = ?;") ;
    $stmt->execute([$email]);
    $user = $stmt->fetch() ;
    // var_dump($user);
    if ($user) {
        if (sha1($password)== $user['password']){
            return $user;
        }else{
            return false;
        }
   }
}

function validateCustomerUser($email, $password, &$user){
    global $db;
    $stmt = $db->prepare("SELECT * FROM `customers` WHERE customers.email = ?;") ;
    $stmt->execute([$email]);
    $user = $stmt->fetch() ;
    if ($user) {
        if (sha1($password)== $user['password']){
            return $user;
        }else{
            return false;
        }
   }
}
function setMarketPassword($user, $password_new){
    global $db ;
    $email = $user["email"];
    $stmt = $db->prepare("update market_user set password = ? where email = ?") ;
    $stmt->execute([sha1($password_new), $email]);
}

function getMarketPassword($user){
    global $db;
    $email = $user["email"];
    $stmt = $db->prepare("SELECT password FROM `market_user` WHERE market_user.email = ?;") ;
    $stmt->execute([$email]);
    return $stmt->fetch()[0] ;
}

function getMarketProducts($user){
    global $db;
    $email = $user["email"];
    $stmt = $db->prepare("SELECT * FROM `market_user` WHERE market_user.email = ?;") ;
    $stmt->execute([$email]);
    return $stmt->fetch()[0] ;
}

function getAllProductsAlphabetically(){
    global $db;
    $stmt = $db->prepare("SELECT * FROM products order by product_title;") ;
    $stmt->execute();
    return $stmt->fetchAll() ;
}

function updateMarketInfo($email, $market_name, $city, $district, $address){
    // var_dump($email,$address,$city,$district, $market_name);
    global $db ;
    $stmt = $db->prepare("UPDATE market_user set market_name = ?, city=?, district=?, `address`=? where email = ?") ;
    $stmt->execute([$market_name,$city,$district,$address,$email]);
}

function updateProduct($user, $product_id, $product_title, $product_price, $product_disc_price, $product_exp_date, $product_stock, $product_image){
    // var_dump($email,$address,$city,$district, $market_name);
    global $db ;
    $email = $user["email"];
    $stmt = $db->prepare(
    "UPDATE products 
    SET 
        product_title = ?, 
        product_price = ?, 
        product_disc_price = ?,
        product_exp_date = ?,
        product_image =?,
        stock = ?
    WHERE products.product_id = ?");

    // Bind parameters with their respective data types for improved security
    $product_stock = (int)$product_stock;
    // var_dump($product_stock);
    // $stmt->bindParam(':product_title',  PDO::PARAM_STR);
    // $stmt->bindParam(':product_price', , PDO::PARAM_STR);  // Consider PDO::PARAM_INT if price is purely numeric
    // $stmt->bindParam(':product_disc_price', , PDO::PARAM_STR);  // Consider PDO::PARAM_INT if price is purely numeric
    // $stmt->bindParam(':product_exp_date',, PDO::PARAM_STR);
    // $stmt->bindParam(':product_stock', , PDO::PARAM_INT);   // Change to PDO::PARAM_STR if stock allows non-numeric values
    // $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    // $stmt->bindParam(':product_id', , PDO::PARAM_INT);
    // $stmt->bindParam(':product_image', , PDO::PARAM_STR);
    // // Change to PDO::PARAM_STR if product_id allows non-numeric values
    $stmt->execute([$product_title,$product_price,$product_disc_price, $product_exp_date,$product_image,$product_stock,$product_id]);
}

function getProductByTitle($product_title){
    global $db;
    $stmt = $db->prepare("SELECT * FROM products where product_title =?;") ;
    $stmt->execute([$product_title]);
    return $stmt->fetch() ;
}



function getProductDetailed($id){
    global $db ;
    $query ="SELECT * FROM products, market_user
    WHERE products.market_email = market_user.email
    AND products.product_id= ?;";
    $stmt = $db->prepare($query);
    $stmt->execute([$id]);
    return $stmt->fetch();
  }

function isAuthenticated(){
    return isset($_SESSION["market_user"]);
}

function isAuthenticatedCusto(){
    return isset($_SESSION["customer_user"]);
}

function getUserByToken($token){
    global $db;
    $stmt = $db->prepare("select * from market_user where remember = ?") ;
    $stmt->execute([$token]) ;
    return $stmt->fetch() ;
}

function getCustoUserByToken($token){
    global $db;
    $stmt = $db->prepare("select * from customers where remember = ?") ;
    $stmt->execute([$token]) ;
    return $stmt->fetch() ;
}

function setTokenByEmail($email, $token){
    global $db;
    $stmt = $db->prepare("update market_user set remember = ? where email = ?") ;
    $stmt->execute([$token, $email]) ;
}

function setCustoTokenByEmail($email, $token){
    global $db;
    $stmt = $db->prepare("update customers set remember = ? where email = ?") ;
    $stmt->execute([$token, $email]) ;
}

function verifyPassword($password, $hash){
    return sha1($password) == $hash;
}

function createProduct($product_title, $product_price, $product_disc_price, $product_image,$product_exp_date, $product_stock, $market_email){
    global $db;
    $stmt = $db->prepare("insert into products (product_title, product_price, product_disc_price,product_image, product_exp_date, stock, market_email)
     values(?,?,?,?,?,?,?)");
     $stmt->execute([$product_title, $product_price, $product_disc_price, $product_image, $product_exp_date, $product_stock, $market_email]);
}

 
function market_register($email,$market_name,$password,$city,$district,$address){
    global $db ;
    $stmt = $db->prepare("INSERT INTO market_user VALUES (?, ?, ?, ?, ?, ?, NULL);") ;
    $stmt->execute([$email,$market_name,sha1($password),$city,$district,$address]);
}

function customer_register($email,$password,$fullname,$city,$district,$address){
    global $db ;
    $stmt = $db->prepare("INSERT INTO customers (email,password,name,remember,profile,city,district,address)VALUES (?, ?, ?,NULL,NULL, ?, ?, ?);") ;
    $stmt->execute([$email,sha1($password),$fullname,$city,$district,$address]);
}

function updateCustomerInfo($id, $email, $name, $city, $district, $address){
    // var_dump($email,$address,$city,$district, $market_name);
    global $db ;
    $stmt = $db->prepare("UPDATE customers set name = ?, city=?, district=?, `address`=? ,email = ? where customer_id=?") ;
    $stmt->execute([$name,$city,$district,$address,$email,$id]);
}

function setCustomerPassword($user, $password_new){
    global $db ;
    $id = $user["customer_id"];
    $stmt = $db->prepare("update customers set password = ? where customer_id = ?") ;
    $stmt->execute([sha1($password_new), $id]);
}
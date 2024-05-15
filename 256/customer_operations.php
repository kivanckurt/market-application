<?php
require_once "db.php";
$user = &$_SESSION["customer_user"];
$cart = &$_SESSION["customer_user"]["cart"];

//consumer operations
function updateCustomerProfile($email,$fullname, $city, $district, $address, $profile) {
    global $db ;
    $stmt = $db->prepare("update customers set name = ?, profile=?, city=?, district=?,address=?
    where email = ?") ;
    $stmt->execute([$fullname, $profile, $city, $district, $address, $email]);
}

function updateCustomerPassword($email, $password){
    global $db ;
    $stmt = $db->prepare("update customers set password = ? where email = ?") ;
    $stmt->execute([$password, $email]);
}
function searchProducts($keyword, $city, $district) {
    global $db ;
    $query = "SELECT *
    FROM products,  market_user
    WHERE stocks.email = market_user.email AND market_user.city = ?
    AND products.product_exp_date> sysdate() AND stock>0 AND product_title LIKE '%?%'
    ORDER BY (CASE district WHEN ? THEN 1 ELSE 0 END) DESC,
    district DESC;";
    $stmt = $db->prepare($query);
    $stmt->execute([$city,$keyword,$district]);
    return $stmt->fetchAll();
}

function updateCart($product_id, $quantity) {
    global $cart;
    // var_dump($cart);
    if(array_key_exists($product_id,$cart) && getStock($product_id) >= $quantity){
        $cart[$product_id] += $quantity;
    }else{
        if(getStock($product_id) >= $quantity){
            $cart[$product_id] = $quantity;
        }
    }
}
function removeFromCart($item_id) {
    global $cart; 
   if(array_key_exists($item_id, $cart)) {
        unset($cart[$item_id]);
    }
    $_SESSION["customer_user"]["cart"] =$cart;

}
function purchaseCart() {
    global $cart;    
    foreach ($cart as $productId => $count){
        if(checkStock($productId, $count)){
            //we can buy
            updateItemQuantity($productId,getStock($productId) - $count);
        }else{
            $error[] = "Not enough stock error";
        }
        removeFromCart($productId);
    }
    $_SESSION["customer_user"]["cart"] =$cart;
}

//product operations

function checkStock($product_id,$count) {
    return $count <= getStock($product_id);
}

function getStock($product_id){
    global $db ;
    $query = "SELECT stock FROM products WHERE product_id = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$product_id]);
    return $stmt->fetch()[0];   
}

function updateItemQuantity($product_id, $quantity) {
    global $db ;
    $stmt = $db->prepare("update products set stock = ? where product_id = ?") ;
    $stmt->execute([$quantity, $product_id]);
}

function calculateTotal() {
    $total =0;
    global $cart;  
    foreach ($cart as $product_id => $count){
        $p = getProductDetailed($product_id);
        // if(strtotime($p["product_exp_date"]) <= (time() - 60*60*24*5)){
            //expire date upcoming product
            if(getStock($product_id) < $count){
                $error[] = "Not enough stock";
                removeFromCart($product_id);
            }
            $total += $p["product_disc_price"] * $count;
        // }
    }

    return $total;
}

function getCartInformation(){
    $total = calculateTotal();
    return ["total_price" => calculateTotal(),"item_cnt" => getCartItemCount()];
}

function getCartItemCount(){
    $cnt =0;
    global $cart;    
    foreach ($cart as $product_id => $count){
        $cnt += $count;
    }
    return $cnt;
}
function clearCart() {
    global $cart;    
    foreach ($cart as $product_id => $count){
        removeFromCart($product_id);
    }
    $_SESSION["customer_user"]["$cart"] =$cart;
}
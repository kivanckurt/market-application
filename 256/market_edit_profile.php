<?php
session_start();
require "db.php";

function message($message){
  $msg = "<div class='alert'>
  <span class='closebtn' onclick='this.parentElement.style.display=none;'>&times;</span> 
  $message.</div>";
  echo $msg;
}

if(!isset($_SESSION["market_user"])){
    header("location: index.php");
    exit;
}
$user = $_SESSION["market_user"];

if(!empty($_POST)){
  extract($_POST);
  var_dump($_POST);
}
//change password
if(!empty($_POST) && isset($_POST["password"]) && isset($_POST["password_new"])){
  // echo "<h1>READS PASSWORDS</h1>";
  $password_old = getMarketPassword($user);
  if(verifyPassword($password, $password_old)){
    
    //password verified
    setMarketPassword($user, $password_new);
    $message="password updated";
    header("location: logout.php");
  }else{
    $message="Password does not match with old password";
    header("location: ?message=$message");
  }
}

// change account information
if(!empty($_POST) && isset($email) && isset($market_name) && isset($city) && isset($district) && isset($address)){
  updateMarketInfo($email, $market_name, $city, $district, $address);
  //update session user with new values
  validateMarketUser($email, $user["password"], $user);
  $_SESSION["market_user"]=$user;

  //remember me options
  var_dump(isset($user["remember"]));
  var_dump(isset($_POST["remember"]));

  if(isset($user["remember"]) && isset($_POST["remember"]));
  if(isset($user["remember"]) && !isset($_POST["remember"])){
    //destroy cookie
    setTokenByEmail($_SESSION["market_user"]["email"], null) ;
    setcookie("access_token", "", 1) ;
    setcookie("PHPSESSID", "", 1 , "/") ;
  }
  if(!isset($user["remember"]) && isset($_POST["remember"])){
    //create cookie
    $token = sha1(uniqid()."PRIVATE KEY IS HERE" . time());
    setcookie("access_token", $token, time() + 60*60*2, '/');
    setTokenByEmail($email,$token);
  }
  if(!isset($user["remember"]) && !isset($_POST["remember"]));
  $message="Market Information Updated";
  // header("location: logout.php");
}



if(isset($_GET["message"])){
  message($_GET["message"]);
}
// var_dump($user);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        section{display: flex;}
        section div{margin: 50px;}
    </style>
    <link rel="stylesheet" href="app.css">
</head>
<body>
  <?= require_once "market_user_header.php"; ?>
  <section>
    <div>
    <form action="" method="post">
  <table>
    <tr>
      <td>Email</td>
      <td><input type="text" name="email" id="email" value="<?= htmlspecialchars($user['email']) ?>" readonly></td>
    </tr>

    <tr>
      <td>Market Name</td>
      <td><input type="text" name="market_name" id="market_name" value="<?= htmlspecialchars($user['market_name']) ?>"></td>
    </tr>
    <tr>
      <td>City</td>
      <td><input type="text" name="city" id="city" value="<?= htmlspecialchars($user['city']) ?>"></td>
    </tr>

    <tr>
      <td>District</td>
      <td><input type="text" name="district" id="district" value="<?= htmlspecialchars($user['district']) ?>"></td>
    </tr>

    <tr>
      <td>Address</td>
      <td><input type="text" name="address" id="address" value="<?= htmlspecialchars($user['address']) ?>"></td>
    </tr>

      <tr>
        <td>Remember Me</td>
        <td><input type="checkbox" name="remember" id="remember" <?= isset($user["remember"]) ? "checked" : ""?>></td>
      </tr>
    <tr>
      <td></td>
      <td><input type="submit" value="Submit"></td>
    </tr>
  </table>
  </form>

    </div>

    <!-- PASSWORD FORM BEGINS -->
    <div>
        <table>
            <form action="" method="post">
                <tr>
                    <td>Enter Old Password</td>
                    <td><input type="text" name="password" id=""></td>
                </tr>
                <tr>
                    <td>Enter New Password</td>
                    <td><input type="password" name="password_new" id=""></td>
                </tr>
                <tr>
                    <td colspan="2"><button type="submit">Change Password</button></td>
                </tr>
            </form>
        </table>
    </div>
    </section>
</body>
</html>

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
  $error=[];
  if(array_key_exists('email',$_POST)){
    if (filter_var($email, FILTER_VALIDATE_EMAIL)===false) {
      $error["email"]="Email is in a incorrect format";
    }
    if (!$market_name) {
      $error["market_name"]="Market name cannot be empty";
    }
    if (!$city) {
      $error["city"]="City cannot be empty";
    }
    if (!$district) {
      $error["district"]="District cannot be empty";
    }
    if (!$address) {
      $error["address"]="Address cannot be empty";
    }
  }

  if(array_key_exists('password_new',$_POST)){
    if(!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,20}$/', $password_new)) {
      $error["password"]="Password does not satify requirements";

      /*
      at least one lowercase char
      at least one uppercase char
      at least one digit
      password lenght must be between 8-20
      */
    }
  }




  var_dump($_POST);
}

if(empty($error)){

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

}
// var_dump($user);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="marketmain.css">
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

    <?php if (isset($error)){ ?>
        <div class="errort">
            <?php if (isset($error["email"])){ ?>
                <p><?=$error["email"]?></p>
            <?php  }?>
            <?php if (isset($error["market_name"])){ ?>
                <p><?=$error["market_name"]?></p>
            <?php  }?>
            <?php if (isset($error["password"])){ ?>
                <p><?=$error["password"]?></p>
            <?php  }?>
            <?php if (isset($error["city"])){ ?>
                <p><?=$error["city"]?></p>
            <?php  }?>
            <?php if (isset($error["district"])){ ?>
                <p><?=$error["district"]?></p>
            <?php  }?>
            <?php if (isset($error["address"])){ ?>
                <p><?=$error["address"]?></p>
            <?php  }?>
        </div>
    <?php  }?>

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

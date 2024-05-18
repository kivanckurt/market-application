<?php
    if(!isset($_SESSION)){
        session_start();
    }
    require_once "db.php";
    require_once "customer_operations.php";
    //if not authenticated, redirect to main page
    if(!isAuthenticatedCusto()){
        header("location: customer_login.php");
        exit;
    }
    var_dump($_SESSION);

    //generate shopping cart if it is not set
    $user = &$_SESSION["customer_user"];
    $cart =$_SESSION["customer_user"]["cart"];
    if($_SERVER["REQUEST_METHOD"] == "POST"){
      var_dump($_POST);
      extract($_POST);
      $customer_id = $user["customer_id"];
      if(!empty($_POST) && isset($customer_id) && isset($email) && isset($name) && isset($city) && isset($district) && isset($address)){
        var_dump($_SERVER);
        updateCustomerInfo($customer_id, $email, $name, $city, $district, $address);
        validateCustomerUser($email, $user["password"], $user);
        $_SESSION["customer_user"]=$user;
        $_SESSION["customer_user"]["cart"]=$cart;
      }
    }

  //change password
  if(!empty($_POST) && isset($_POST["password"]) && isset($_POST["password_new"])){
    // echo "<h1>READS PASSWORDS</h1>";
    $password_old = $user["password"];
    if(verifyPassword($password, $password_old)){      
      //password verified
      setCustomerPassword($user, $password_new);
      $message="password updated";
      header("location: logout.php");
    }else{
      $message="Password does not match with old password";
      header("location: ?message=$message");
    }
  }

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
</head>
<body>
<?= require_once "customer_header.php"; ?>
  <section>
    <div>
    <form action="" method="post">
  <table>
    <tr>
      <td>Name</td>
      <td><input type="text" name="name" id="email" value="<?= htmlspecialchars($user['name']) ?>"></td>
    </tr>
    <tr>
      <td>Email</td>
      <td><input type="text" name="email" id="email" value="<?= htmlspecialchars($user['email']) ?>"></td>
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
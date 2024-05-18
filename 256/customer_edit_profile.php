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
    //var_dump($_SESSION);
    $error=[];
    //generate shopping cart if it is not set
    $user = &$_SESSION["customer_user"];
    $cart =$_SESSION["customer_user"]["cart"];
    if($_SERVER["REQUEST_METHOD"] == "POST"){
      //var_dump($_POST);
      extract($_POST);
      if(array_key_exists('email',$_POST)){
      $name=htmlspecialchars($name);
      $city=htmlspecialchars($city);
      $district=htmlspecialchars($district);
      $address=htmlspecialchars($address);
      $email=htmlspecialchars($email);

      if (filter_var($email, FILTER_VALIDATE_EMAIL)===false) {
      $error["email"]="Email is in a incorrect format";
      }
      if (!$name) {
          $error["name"]="Name cannot be empty";
      }
      if (!$city) {
          $error["city"]="District cannot be empty";
      }
      if (!$district) {
          $error["district"]="District cannot be empty";
      }
      if (!$address) {
          $error["address"]="Address cannot be empty";
      }
      }



      if(empty($error)){
      $customer_id = $user["customer_id"];
      if(!empty($_POST) && isset($customer_id) && isset($email) && isset($name) && isset($city) && isset($district) && isset($address)){
        //var_dump($_SERVER);
        updateCustomerInfo($customer_id, $email, $name, $city, $district, $address);
        validateCustomerUser($email, $user["password"], $user);
        $_SESSION["customer_user"]=$user;
        $_SESSION["customer_user"]["cart"]=$cart;
        $message="Informations Updated";
      }
      }
    }

  //change password
  if(!empty($_POST) && isset($_POST["password"]) && isset($_POST["password_new"])){

    if(!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,20}$/', $password_new)) {
      $error["password"]="Password does not satify requirements";
      /*
      at least one lowercase char
      at least one uppercase char
      at least one digit
      password lenght must be between 8-20
      */
    }else{
      // echo "<h1>READS PASSWORDS</h1>";
    $password_old = $user["password"];
    if(verifyPassword($password, $password_old)){      
      //password verified
      setCustomerPassword($user, $password_new);
      $message="Password Updated";
      //header("location: logout.php");
    }else{
      $error["password"]="Old password is not correct";
    }

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
      <td><input type="text" name="name" id="email" value="<?= isset($name) ? $name : htmlspecialchars($user['name']) ?>"></td>
    </tr>
    <tr>
      <td>Email</td>
      <td><input type="text" name="email" id="email" value="<?=isset($email) ? $email : htmlspecialchars($user['email']) ?>"></td>
    </tr>
    <tr>
      <td>City</td>
      <td><input type="text" name="city" id="city" value="<?=isset($city) ? $city : htmlspecialchars($user['city']) ?>"></td>
    </tr>
    <tr>
      <td>District</td>
      <td><input type="text" name="district" id="district" value="<?=isset($district) ? $district : htmlspecialchars($user['district']) ?>"></td>
    </tr>
    <tr>
      <td>Address</td>
      <td><input type="text" name="address" id="address" value="<?=isset($address) ? $address : htmlspecialchars($user['address']) ?>"></td>
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

    <?php if (isset($error)){ ?>
        <div class="errort">
            <?php if (isset($error["email"])){ ?>
                <p><?=$error["email"]?></p>
            <?php  }?>
            <?php if (isset($error["name"])){ ?>
                <p><?=$error["name"]?></p>
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
    <?php if (isset($error)){ ?>
      <div class="message">
      <?php if (isset($message)){ ?>
                <p><?=$message?></p>
            <?php  }?>
      </div>
    <?php  }?>
    </section>
</body>
</html>
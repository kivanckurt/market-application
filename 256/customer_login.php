<?php
    session_start();
    require_once "db.php";
    // var_dump($_SESSION); 
    if(!empty($_POST)){
        extract($_POST);
        //Validation
        $error=[];
        if (filter_var($email, FILTER_VALIDATE_EMAIL)===false) {
            $error["email"]="Email is in a incorrect format";
        }

        if ( empty($error)){
        //echo "IsValidated: "; 
        if(validateCustomerUser($email, $password, $user)){
            //now user is authenticated
            
            //remember me part
            if(isset($rememberme)){
                $token = sha1(uniqid()."PRIVATE KEY IS HERE" . time());
                setcookie("custo_access_token", $token, time() + 60*60*2, '/');
                setCustoTokenByEmail($email,$token);
            }
            $_SESSION["customer_user"] = $user; // MAKING AN ACTIVE SESSION
            header("location: customer_main.php");
            exit;
        }
        else{
            $error["password"]="Password is incorrect";
        }

        }
    }

    //remember me auto log in part
    if($_SERVER["REQUEST_METHOD"]=="GET" && isset($_COOKIE["custo_access_token"])){
        $token = $_COOKIE["custo_access_token"];
        $user = getCustoUserByToken($token);
        if($user){
            $_SESSION["customer_user"] = $user;
            header("Location: customer_main.php");
            exit;
        }
    }

    //if already logged in skip login.php
    if($_SERVER["REQUEST_METHOD"]=="GET" && isset($_COOKIE["custo_access_token"])){
        $user = getCustoUserByToken($token);
        if($user){
            $_SESSION["customer_user"]=$user;
            header("location: customer_main.php");
            exit;
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="customer_login.css">
    <title>Document</title>
</head>
<body>
    <div class="background">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    <form action="" method="post">
        <table>
            <tr>
                <td>Email: </td>
                <td><input type="text" name="email" id="" value=<?= isset($email) ? "$email" : "" ?>></td>
                <?php if (isset($error["email"])){ ?>
                <td><?=$error["email"]?></td>
                <?php  }?>
            </tr>
            <tr>
                <td>Password:</td>
                <td><input type="password" name="password" id=""></td>
                <?php if (isset($error["password"])){ ?>
                <td><?=$error["password"]?></td>
                <?php  }?>
            </tr>
            <tr>
                <td><button type="submit">Log In</button></td>
                <td>Remember Me<input type="checkbox" name="rememberme" id="" <?= isset($rememberme) ? "checked" : "" ?>></td>
            </tr>
            <tr>
                <td><p><a href="customer_register.php">Register</a></p></td>
            </tr>
        </table>
    </form>
    
</body>
</html>
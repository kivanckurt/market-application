<?php
    session_start();
    require_once "db.php";
    // var_dump($_SESSION); 
    if(!empty($_POST)){
        extract($_POST);
        // var_dump($_POST);

        $error=[];
        if (filter_var($email, FILTER_VALIDATE_EMAIL)===false) {
            $error["email"]="Email is in a incorrect format";
        }

        if ( empty($error)){
        //echo "IsValidated: "; 
        var_dump(validateMarketUser($email, $password, $user));
        if(validateMarketUser($email, $password, $user)){
            //now user is authenticated

            //remember me part
            if(isset($rememberme)){
                $token = sha1(uniqid()."PRIVATE KEY IS HERE" . time());
                setcookie("market_access_token", $token, time() + 60*60*2, '/');
                setTokenByEmail($email,$token);
            }
            $_SESSION["market_user"] = $user; // MAKING AN ACTIVE SESSION
            header("location: market_main.php");
            exit;
        }
        //asdasdasd
        else{
            $error["password"]="Password is incorroect";
        }
        }
    }

    //remember me auto log in part
    if($_SERVER["REQUEST_METHOD"]=="GET" && isset($_COOKIE["market_access_token"])){
        $token = $_COOKIE["market_access_token"];
        $user = getUserByToken($token);
        if($user){
            $_SESSION["market_user"] = $user;
            header("Location: market_main.php");
            exit;
        }
    }

    //if already logged in skip login.php
    if($_SERVER["REQUEST_METHOD"]=="GET" && isset($_COOKIE["market_access_token"])){
        $user = getUserByToken($token);
        if($user){
            $_SESSION["market_user"]=$user;
            header("location: market_main.php");
            exit;
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./marketloginpage.css">
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
                <td>Wrong Email</td>
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
                <td><p><a href="market_register.php">Register</a></p></td>
            </tr>
        </table>
    </form>
</body>
</html>
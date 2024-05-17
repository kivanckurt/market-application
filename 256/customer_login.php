<?php
    session_start();
    require_once "db.php";
    // var_dump($_SESSION); 
    if(!empty($_POST)){
        extract($_POST);
        // var_dump($_POST);
        echo "IsValidated: "; 
        if(validateCustomerUser($email, $password, $user)){
            //now user is authenticated

            //remember me part
            if(isset($rememberme)){
                $token = sha1(uniqid()."PRIVATE KEY IS HERE" . time());
                setcookie("access_token", $token, time() + 60*60*2, '/');
                setCustoTokenByEmail($email,$token);
            }
            $_SESSION["customer_user"] = $user; // MAKING AN ACTIVE SESSION
            header("location: customer_main.php");
            exit;
        }
        else{
            echo "ENTER NUMBER CORRECT";
        }
    }

    //remember me auto log in part
    if($_SERVER["REQUEST_METHOD"]=="GET" && isset($_COOKIE["access_token"])){
        $token = $_COOKIE["access_token"];
        $user = getCustoUserByToken($token);
        if($user){
            $_SESSION["user"] = $user;
            header("Location: customer_main.php");
            exit;
        }
    }

    //if already logged in skip login.php
    if($_SERVER["REQUEST_METHOD"]=="GET" && isset($_COOKIE["access_token"])){
        $user = getCustoUserByToken($token);
        if($user){
            $_SESSION["user"]=$user;
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
        <h3>Login Here</h3>

        <label for="username">Email</label>
        <input type="text" placeholder="Email" name="email" id="">

        <label for="password">Password</label>
        <input type="password" placeholder="Password" name="password" id="">

        <div class="rebme">
            <span>Remember Me</span>
            <div class="checkbox-wrapper-31">
                <input type="checkbox" name="rememberme" id=""/>
                <svg viewBox="0 0 35.6 35.6">
                    <circle class="background" cx="35.6" cy="35.6" r="17.8"></circle>
                    <circle class="stroke" cx="17.8" cy="17.8" r="14.37"></circle>
                    <polyline class="check" points="11.78 18.12 15.55 22.23 25.17 12.87"></polyline>
                </svg>
            </div>
        </div>
        <button type="submit">Log In</button>
        
        
        

    </form>
</body>
</html>
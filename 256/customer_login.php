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
            $_SESSION["customer_user"] = $user;
            header("Location: customer_main.php");
            exit;
        }
    }

    //if already logged in skip login.php
    if($_SERVER["REQUEST_METHOD"]=="GET" && isset($_COOKIE["access_token"])){
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
    <title>Document</title>
</head>
<body>
    <form action="" method="post">
        <table>
            <tr>
                <td>Email: </td>
                <td><input type="text" name="email" id=""></td>
            </tr>
            <tr>
                <td>Password:</td>
                <td><input type="password" name="password" id=""></td>
            </tr>
            <tr>
                <td><button type="submit">Log In</button></td>
                <td>Remember Me<input type="checkbox" name="rememberme" id=""></td>
            </tr>
            <tr>
                <td><p><a href="customer_register.php">Register</a></p></td>
            </tr>
        </table>
    </form>
</body>
</html>
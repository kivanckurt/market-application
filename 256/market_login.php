<?php
    session_start();
    require_once "db.php";
    // var_dump($_SESSION); 
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        extract($_POST);

        if(count($_POST)<=3)
        {
            echo "IsValidated: "; 
            var_dump(validateMarketUser($email, $password, $user));
            if(validateMarketUser($email, $password, $user)){
            //now user is authenticated

            //remember me part
            if(isset($rememberme)){
                $token = sha1(uniqid()."PRIVATE KEY IS HERE" . time());
                setcookie("access_token", $token, time() + 60*60*2, '/');
                setTokenByEmail($email,$token);
            }
            $_SESSION["market_user"] = $user; // MAKING AN ACTIVE SESSION
            header("location: market_main.php");
            exit;
            }
            else{
            echo "ENTER NUMBER CORRECT";
        }
        }
        else{
            global $db;
            $stmt = $db->prepare("INSERT INTO market_user VALUES (?, ?, ?, ?, ?, ?);") ;
            $stmt->execute([$email,$market_name,sha1($password),$city,$district,$address]) ;
            echo "<h3>You hava succesfully registered</h3>";
            echo "<p><a href='?'>Sign in</a></p>";
            exit;
        }
       
        
    }
    else{
        
    }

    //remember me auto log in part
    if($_SERVER["REQUEST_METHOD"]=="GET" && isset($_COOKIE["access_token"])){
        $token = $_COOKIE["access_token"];
        $user = getUserByToken($token);
        if($user){
            $_SESSION["user"] = $user;
            header("Location: market_main.php");
            exit;
        }
    }

    //if already logged in skip login.php
    if($_SERVER["REQUEST_METHOD"]=="GET" && isset($_COOKIE["access_token"])){
        $user = getUserByToken($token);
        if($user){
            $_SESSION["user"]=$user;
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
    <title>Document</title>
</head>
<body>
    <form action="" method="post">
        <table>
            <tr></tr>
            <?php 

            if($_SERVER["REQUEST_METHOD"]=="GET" && isset($_GET["register"])){
                echo " <tr>";
                echo "<td>Email: </td>";
                echo "<td><input type='text' name='email' id=''></td>";
                echo "</tr>";
                echo " <tr>";
                echo "<td>Market Name: </td>";
                echo "<td><input type='text' name='market_name' id=''></td>";
                echo "</tr>";
                echo " <tr>";
                echo "<td>Password: </td>";
                echo "<td><input type='password' name='password' id=''></td>";
                echo "</tr>";
                echo " <tr>";
                echo "<td>City: </td>";
                echo "<td><input type='text' name='city' id=''></td>";
                echo "</tr>";
                echo " <tr>";
                echo "<td>District:</td>";
                echo "<td><input type='text' name='district' id=''></td>";
                echo "</tr>";
                echo " <tr>";
                echo "<td>Address: </td>";
                echo "<td><input type='text' name='address' id=''></td>";
                echo "</tr>";
                echo " <tr>";
                echo "<td><button type='submit'>Register</button></td>";
                echo " </tr>";
                echo " <tr>";
                echo "<td><a href='?'>Back</a></td>";
                echo " </tr>";
                exit;
            }
            
            ?>
            
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
                <td><a href="?register=1">Register</a></td>
            </tr>
            <select name="" id="">
                <option value=""></option>
                <option value=""></option>
                <option value=""></option>
                <option value=""></option>
                <option value=""></option>
                <option value=""></option>
            </select>
        </table>
    </form>
</body>
</html>
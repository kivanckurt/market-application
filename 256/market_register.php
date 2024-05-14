<?php
    session_start();
    require_once "db.php";
    require_once './vendor/autoload.php' ;
    require_once './Mail.php' ;
    // var_dump($_SESSION); 
    /*if(!empty($_POST)){
        extract($_POST);
        
            market_register($email,$market_name,$password,$city,$district,$address);
            if(validateMarketUser($email, $password, $user)){

            $_SESSION["market_user"] = $user; // MAKING AN ACTIVE SESSION
            header("location: market_main.php");
            exit;
        }
        else{
            echo "ENTER NUMBER CORRECT";
        }
    }*/

    $_SESSION["ok"]=false;
    if(!empty($_POST)){
        if(array_key_exists('code',$_POST)){
            $random=$_SESSION["random"];
            extract($_POST);
            $code=intval($code);
            if($random==$code){
                $post=$_SESSION["post"];
                $_SESSION["ok"]=false;
                extract($post);
                market_register($email,$market_name,$password,$city,$district,$address);
                if(validateMarketUser($email, $password, $user)){

                    $_SESSION["market_user"] = $user; // MAKING AN ACTIVE SESSION
                    header("location: market_main.php");
                    exit;
                }
                else{
                    echo "ENTER NUMBER CORRECT";
                   
                }
            }
            else{
                $error=true;
                $_SESSION["ok"]=true;
            }
        }
        else{
            $_SESSION["post"]=$_POST;
            extract($_POST);
            $subject="Customer Mail Verification";
            $random = rand(10000,99999);
            Mail::send($email,$subject, $random) ;
            $_SESSION["random"]=$random;
            $_SESSION["ok"]=true;
            $error=false;
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
    
    <h2>Market Registration</h2>
    <?php if (isset($_SESSION["ok"]) && $_SESSION["ok"]){ ?>
    <form action="" method="post">
    <table>
        <tr>
            <td>CODE: </td>
            <td><input type='text' name='code' id=''></td>
            <td>
            <?php if ($error){ ?>
                WRONG CODE
            <?php  }?>
            </td>
        </tr>
        <tr>
            <td><button type='submit'>Register</button></td>
        </tr>
    </table>
    </form>
    <?= exit;?>
    <?php  }?>
    <form action="" method="post">
    <table>
        <tr>
            <td>Email: </td>
            <td><input type='text' name='email' id=''></td>
        </tr>
        <tr>
            <td>Market Name: </td>
            <td><input type='text' name='market_name' id=''></td>
        </tr>
        <tr>
            <td>Password: </td>
            <td><input type='password' name='password' id=''></td>
        </tr>
        <tr>
            <td>City: </td>
            <td><input type='text' name='city' id=''></td>
        </tr>
            <tr>
            <td>District:</td>
            <td><input type='text' name='district' id=''></td>
        </tr>
            <tr>
            <td>Address: </td>
            <td><input type='text' name='address' id=''></td>
        </tr>
            <tr>
            <td><button type='submit'>Register</button></td>
        </tr>
        </table>
    </form>
</body>
</html>
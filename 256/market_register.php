<?php
    session_start();
    require_once "db.php";
    // var_dump($_SESSION); 
    if(!empty($_POST)){
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
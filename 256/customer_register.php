<?php
    session_start();
    require_once "db.php";
    // var_dump($_SESSION); 
    if(!empty($_POST)){
        extract($_POST);
        
            customer_register($email,$password,$fullname,$city,$district,$address);
            if(validateCustomerUser($email, $password, $user)){

            $_SESSION["customer_user"] = $user; // MAKING AN ACTIVE SESSION
            header("location: customer_main.php");
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
    
    <h2>Customer Registration</h2>

    <form action="" method="post">
    <table>
        <tr>
            <td>Email: </td>
            <td><input type='text' name='email' id=''></td>
        </tr>
        <tr>
            <td>Fullname: </td>
            <td><input type='text' name='fullname' id=''></td>
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
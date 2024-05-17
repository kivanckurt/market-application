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
    <link rel="stylesheet" href="customer_register.css">
    <title>Document</title>
</head>
<body>
    
    <form action="" method="post">
        <h3>Customer Registration</h3>

        <label for="username">Email</label>
        <input type="text" placeholder="Email" name="email" id="">

        <label for="fullname">Full Name</label>
        <input type="text" placeholder="Name Surname" name="fullname" id="">

        <label for="password">Password</label>
        <input type="password" placeholder="Password" name="password" id="">

        <label for="city">City</label>
        <input type="text" placeholder="City" name="city" id="">

        <label for="district">District</label>
        <input type="text" placeholder="District" name="district" id="">

        <label for="address">Address</label>
        <input type="text" placeholder="Address" name="address" id="">

        <button type="submit">Register</button>
    </form>
</body>
</html>
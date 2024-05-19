<?php
    // Start PHP session
    if (!isset($_SESSION)) {
        session_start();
    }

    // Include required files
    require_once "db.php";
    require_once "customer_operations.php";

    // Check if authenticated
    if (!isAuthenticatedCusto()) {
        header("location: customer_login.php");
        exit;
    }

    // Generate shopping cart if not set
    $user = &$_SESSION["customer_user"];
    $cart = $_SESSION["customer_user"]["cart"];

    // Handle form submissions
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        extract($_POST);
        $customer_id = $user["customer_id"];

        if (!empty($_POST) && isset($customer_id) && isset($email) && isset($name) && isset($city) && isset($district) && isset($address)) {
            updateCustomerInfo($customer_id, $email, $name, $city, $district, $address);
            validateCustomerUser($email, $user["password"], $user);
            $_SESSION["customer_user"] = $user;
            $_SESSION["customer_user"]["cart"] = $cart;
        }
    }

    // Change password
    if (!empty($_POST) && isset($_POST["password"]) && isset($_POST["password_new"])) {
        $password_old = $user["password"];

        if (verifyPassword($password, $password_old)) {
            setCustomerPassword($user, $password_new);
            $message = "password updated";
            header("location: logout.php");
        } else {
            $message = "Password does not match with old password";
            header("location: ?message=$message");
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Info</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f0f0f0;
            display: flex;
            flex-direction: column;
            align-items: center;
            color: #333;
        }

        header {
            width: 100%;
            padding: 20px;
            background-color: #4A148C; /* Match header color */
            color: white;
            text-align: center;
        }

        .main-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
            gap: 80px; 
        }

        .card {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        .card-small {
            width: 250px; 
        }

        form {
            width: 100%;
            margin-bottom: 20px;
        }

        form table {
            width: 100%;
        }

        form td {
            padding: 10px;
        }

        form input[type="text"],
        form input[type="password"],
        form input[type="submit"],
        form button {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }

        form input[type="submit"],
        form button {
            background-color: #4A148C; /* Match button color to header */
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        form input[type="submit"]:hover,
        form button:hover {
            background-color: #6A1B9A;
        }

        h2 {
            margin-bottom: 20px;
            color: #4A148C;
            text-align: center;
        }
        .card {
    width: 450px;
        }

.card-small {
    width: 400px;
        }

    </style>
</head>
<body>
    <?= require_once "customer_header.php"; ?>
    <div class="main-container">
        <div class="card">
            <h2>Edit Profile</h2>
            <form action="" method="post">
                <table>
                    <tr>
                        <td>Name</td>
                        <td><input type="text" name="name" id="name" value="<?= htmlspecialchars($user['name']) ?>"></td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td><input type="text" name="email" id="email" value="<?= htmlspecialchars($user['email']) ?>"></td>
                    </tr>
                    <tr>
                        <td>City</td>
                        <td><input type="text" name="city" id="city" value="<?= htmlspecialchars($user['city']) ?>"></td>
                    </tr>
                    <tr>
                        <td>District</td>
                        <td><input type="text" name="district" id="district" value="<?= htmlspecialchars($user['district']) ?>"></td>
                    </tr>
                    <tr>
                        <td>Address</td>
                        <td><input type="text" name="address" id="address" value="<?= htmlspecialchars($user['address']) ?>"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" value="Submit"></td>
                    </tr>
                </table>
            </form>
        </div>

        <div class="card card-small">
            <h2>Change Password</h2>
            <form action="" method="post">
                <table>
                    <tr>
                        <td>Enter Old Password</td>
                        <td><input type="password" name="password" id="password"></td>
                    </tr>
                    <tr>
                        <td>Enter New Password</td>
                        <td><input type="password" name="password_new" id="password_new"></td>
                    </tr>
                    <tr>
                        <td colspan="2"><button type="submit">Change Password</button></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</body>
</html>

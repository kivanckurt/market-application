<?php
    session_start();
    require_once "db.php";
    require_once './vendor/autoload.php' ;
    require_once './Mail.php' ;
    // var_dump($_SESSION); 

    $_SESSION["ok"]=false;
    if(!empty($_POST)){
        $error=[];
        if(array_key_exists('code',$_POST)){
            $random=$_SESSION["random"];
            extract($_POST);

            $code=filter_var($code, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if(!$code){
                $error["code"]="Code cannot be empty";
            }

            if(empty($error)){

                $code=intval($code);
            if($random==$code){
                $post=$_SESSION["post"];
                $_SESSION["ok"]=false;
                extract($post);
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
            else{
                $error["code"]="Code is wrong, Try Again";
                $_SESSION["ok"]=true;
            }
            }
            else{
                $_SESSION["ok"]=true;
            }
            
        }
        else{

            $_SESSION["post"]=$_POST;
            extract($_POST);
            //BURDA GICIK SEYLER DÖNDÜ. FAZLADAN GÜVENLİK OLARAK DÜŞÜN.
            
            $fullname=htmlspecialchars($fullname);
            $city=htmlspecialchars($city);
            $district=htmlspecialchars($district);
            $address=htmlspecialchars($address);
            $email=htmlspecialchars($email);

            if (filter_var($email, FILTER_VALIDATE_EMAIL)===false) {
            $error["email"]="Email is in a incorrect format";
            }
            if(!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,20}$/', $password)) {
                $error["password"]="Password does not satify requirements";
                /*
                at least one lowercase char
                at least one uppercase char
                at least one digit
                password lenght must be between 8-20
                */
            }
            if (!$fullname) {
                $error["fullname"]="Fullname cannot be empty";
            }
            if (!$city) {
                $error["city"]="District cannot be empty";
            }
            if (!$district) {
                $error["district"]="District cannot be empty";
            }
            if (!$address) {
                $error["address"]="Address cannot be empty";
            }

            if(empty($error)){
                $subject="Customer Mail Verification";
                $random = rand(10000,99999);
                Mail::send($email,$subject, $random) ;
                $_SESSION["random"]=$random;
                $_SESSION["ok"]=true;
            }
            else{
                
            }
               
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
    
    <?php if (isset($_SESSION["ok"]) && $_SESSION["ok"]){ ?>
    <form action="" method="post">
    <h3>Customer Registration</h3>
    <table>
        <tr>
            <td>CODE: </td>
            <td><input type='text' name='code' id=''></td>
            <td>
            <?php if (isset($error["code"])){ ?>
                <?=$error["code"]?>
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
        <h3>Customer Registration</h3>

        <label for="email">Email</label>
        <input type='text' name='email' id='' value="<?= isset($email) ? $email: "" ?>">
            

        <label for="fullname">Full Name</label>
        <input type='text' name='fullname' id='' value="<?= isset($fullname) ? $fullname: "" ?>">
            

        <label for="password">Password</label>
        <input type='password' name='password' id='' value="<?= isset($password) ? $password: "" ?>">
           

        <label for="city">City</label>
        <input type='text' name='city' id='' value="<?= isset($city) ? $city : "" ?>">


        <label for="district">District</label>
        <input type='text' name='district' id='' value="<?= isset($district) ? $district: "" ?>">
            

        <label for="address">Address</label>
        <input type='text' name='address' id='' value="<?= isset($address) ? $address: "" ?>">


        <button type="submit">Register</button> 

    
    </form>
    <?php if (isset($error)){ ?>
        <div class="errort">
            <?php if (isset($error["email"])){ ?>
                <p><?=$error["email"]?></p>
            <?php  }?>
            <?php if (isset($error["fullname"])){ ?>
                <p><?=$error["fullname"]?></p>
            <?php  }?>
            <?php if (isset($error["password"])){ ?>
                <p><?=$error["password"]?></p>
            <?php  }?>
            <?php if (isset($error["city"])){ ?>
                <p><?=$error["city"]?></p>
            <?php  }?>
            <?php if (isset($error["district"])){ ?>
                <p><?=$error["district"]?></p>
            <?php  }?>
            <?php if (isset($error["address"])){ ?>
                <p><?=$error["address"]?></p>
            <?php  }?>
        </div>
    <?php  }?>

   
</body>
</html>
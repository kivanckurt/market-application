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
            $fullname=filter_var($fullname, FILTER_SANITIZE_STRING);
            $fullname=filter_var($fullname, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $city=filter_var($city, FILTER_SANITIZE_STRING);
            $city=filter_var($city, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $district=filter_var($district, FILTER_SANITIZE_STRING);
            $district=filter_var($district, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $address=filter_var($address, FILTER_SANITIZE_STRING);
            $address=filter_var($address, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $email=filter_var($email, FILTER_SANITIZE_STRING);
            $email=filter_var($email, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
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
                var_dump($error);
                var_dump($fullname);
                var_dump($city);
                var_dump($district);
                var_dump($address);
            }
               
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
    <?php if (isset($_SESSION["ok"]) && $_SESSION["ok"]){ ?>
    <form action="" method="post">
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
    <table>
        <tr>
            <td>Email: </td>
            <td><input type='text' name='email' id='' value="<?= isset($email) ? filter_var($email, FILTER_SANITIZE_STRING) : "" ?>"></td>
            <?php if (isset($error["email"])){ ?>
                <td><?=$error["email"]?></td>
            <?php  }?>
        </tr>
        <tr>
            <td>Fullname: </td>
            <td><input type='text' name='fullname' id='' value=<?= isset($fullname) ? "$fullname" : "" ?>></td>
            <?php if (isset($error["fullname"])){ ?>
            <td><?=$error["fullname"]?></td>
            <?php  }?>
        </tr>
        <tr>
            <td>Password: </td>
            <td><input type='password' name='password' id='' ></td>
            <?php if (isset($error["password"])){ ?>
            <td><?=$error["password"]?></td>
            <?php  }?>
        </tr>
        <tr>
            <td>City: </td>
            <td><input type='text' name='city' id='' value="<?= isset($city) ? "$city" : "" ?>"></td>
            <?php if (isset($error["city"])){ ?>
            <td><?=$error["city"]?></td>
            <?php  }?>
        </tr>
            <tr>
            <td>District:</td>
            <td><input type='text' name='district' id='' value=<?= isset($district) ? "$district" : "" ?>></td>
            <?php if (isset($error["district"])){ ?>
            <td><?=$error["district"]?></td>
            <?php  }?>
        </tr>
            <tr>
            <td>Address: </td>
            <td><input type='text' name='address' id='' value=<?= isset($address) ? "$address" : "" ?>></td>
            <?php if (isset($error["address"])){ ?>
            <td><?=$error["address"]?></td>
            <?php  }?>
        </tr>
            <tr>
            <td><button type='submit'>Register</button></td>
        </tr>
        </table>
    </form>
</body>
</html>
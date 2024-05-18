<?php
if(isset($_SESSION["market_user"])){
    extract($_SESSION["market_user"]);
    // var_dump($_SESSION["market_user"]);
    $user = $_SESSION["market_user"];
}

if($_SERVER["REQUEST_METHOD"]=="GET"){
    extract($_GET);
    $keyword = $keyword ?? "";
    $cleanedKeyword = str_replace('%', '', $keyword);
    $formedKeyword ='%'.$cleanedKeyword.'%';
}
?>

<style>

</style>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="path/to/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="app.css">
    <style>
                header{
        color:red;
        text-align: center;
        position: relative;
        border: 1px solid black;
        border-radius: 10px;
        }
        header .logo{ color: white; background-color: lightblue;  border-radius: 10px;}
        .logo a {text-decoration: none; color: blue; font-size: 30px;}
        #searchBar{border-radius: 10px; height: max-content; width: 300px;
        position: absolute; left: 200px; top: 10px;}
        #searchBar::placeholder{font-size: large;}
        .userInfo{position: absolute; right: 30px;}
        #profile{width: 30px;}
        .cartInfo{position: absolute; right: 150px; top: 10px;}
    </style>
</head>
<body>
    <header>
        <table>
            <tr>
                <td class="logo">
                    <div><span><a href="market_main.php">xxmarkt</a></span></div>
                </td>
                <td>
                    <form action="market_main.php" method="GET">
                        <input type="text" name="keyword" id="searchBar" placeholder="Apple" value="<?=isset($keyword) ? htmlspecialchars($keyword) : "" ?>">
                    </form>
                </td>
                <td class="addProduct">
                    <a href="market_add_product.php">+</a>
                </td>

                <td class="userInfo">
                    <a href="market_edit_profile.php">
                    <div>
                        <img src="./images/apples.jpeg" alt="" id="profile">
                        <span><?=$user["market_name"] ?></span>
                    </div>
                    </a>
                </td>
            </tr>

        </table>
    </header>
</body>
</html>
<?php
if(isset($_SESSION["market_user"])){
    extract($_SESSION["market_user"]);
    // var_dump($_SESSION["market_user"]);
    $user = $_SESSION["market_user"];
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
</head>
<body>
    <header>
        <table>
            <tr>
                <td class="logo">
                    <div><span><a href="market_main.php">xxmarkt</a></span></div>
                </td>
                <td>
                    <form action="market_main.php" method="post">
                        <input type="text" name="searchVal" id="searchBar" placeholder="Apple">
                    </form>
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
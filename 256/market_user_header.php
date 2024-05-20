<?php
if(isset($_SESSION["market_user"])){
    extract($_SESSION["market_user"]);
    // var_dump($_SESSION["market_user"]);
    $user = $_SESSION["market_user"];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://kit.fontawesome.com/c3e04cab36.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="marketmain.css">
</head>
<body>
<div class="sidebar">
    <div class="sidebar-header">
      <div class="app-icon">
        <div><span><a href="market_home.php"><h2>XXMarkt</h2></a></span></div>
      </div>
    </div>
    <ul class="sidebar-list">
      <li class="sidebar-list-item" data-id="item1">
        <a href="market_home.php">
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
          <span>Home</span>
        </a>
      </li>
      <li class="sidebar-list-item" data-id="item2">
        <a href="market_main.php">
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-bag"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
          <span>Products</span>
        </a>
      </li>
    </ul>
    
    <div class="account-info" role="button">
      <div onclick="location.href='logout.php?user=0'">
          <i class="fa-solid fa-right-from-bracket fa-flip-horizontal" style="color: #ffffff;"></i>
      </div>
      <div class="account-info-name" onclick="location.href='market_edit_profile.php'"><?=$user["market_name"] ?></div>
    </div>

</div>
<script src="market_user_header.js"></script>
</body>
</html>

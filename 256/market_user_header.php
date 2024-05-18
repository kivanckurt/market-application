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
      <li class="sidebar-list-item" data-id="item3">
        <a href="#">
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-pie-chart"><path d="M21.21 15.89A10 10 0 1 1 8 2.83"/><path d="M22 12A10 10 0 0 0 12 2v10z"/></svg>
          <span>Statistics</span>
        </a>
      </li>
      <li class="sidebar-list-item" data-id="item4">
        <a href="#">
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-inbox"><polyline points="22 12 16 12 14 15 10 15 8 12 2 12"/><path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/></svg>
          <span>Inbox</span>
        </a>
      </li>
      <li class="sidebar-list-item" data-id="item5">
        <a href="#">
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
          <span>Notifications</span>
        </a>
      </li>
    </ul>
    
    <div class="account-info" role="button" tabindex=0 onclick="location.href='market_edit_profile.php'">
      <div class="account-info-picture">
        <img src="./images/apples.jpeg" alt="" id="profile">
      </div>
      <div class="account-info-name"><?=$user["market_name"] ?></div>
    </div>

</div>
<script src="market_user_header.js"></script>
</body>
</html>

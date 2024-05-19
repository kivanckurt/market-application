<?php
    session_start();
    //var_dump($_SESSION);
?>
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>XX-Market</title>
  <link rel="stylesheet" href="./loginpage.css">
  <script src="https://kit.fontawesome.com/c3e04cab36.js" crossorigin="anonymous"></script>

</head>
<body>


<main>
  <section class="Hero">
    <div class="Hero__content">
      <h2 class="Hero__title">XX-Market</h2>
      <p class="Hero__subtitle">Lorem ipsum dolor sit amet consectetur adipisicing elit. Mollitia ad est dolor, maiores minima sunt corrupti delectus voluptas eaque autem expedita inventore hic ipsam. Id reprehenderit cupiditate placeat accusantium beatae!</p>
      <div class="Hero__action" role="button" tabindex=0 onclick="location.href='market_login.php'"><span class="Hero__actionText"> MarketLogin</span></div>
      <div class="Hero__action" role="button" tabindex=0 onclick="location.href='customer_login.php'"><span class="Hero__actionText">Log in</span></div>
    </div>
    <div class="Hero__image" id="Hero__image"></div>
    <div class="Hero__mask"></div>
    <canvas id="canvas" class="Hero__snowfall"></canvas>
  </section>
</main>
<!-- partial -->
  <script src='./snow.js'></script><script  src="./loginpage.js"></script>

</body>
</html>

<?php
    session_start();
    require_once "db.php";

    //if not authenticated, redirect to main page
    if(!isAuthenticated()){
        header("location: market_login.php");
        exit;
    }

    $user = $_SESSION["market_user"];
    //var_dump($user);

    //get method operations
    if($_SERVER["REQUEST_METHOD"]=="GET"){
        // var_dump($_GET);    
        extract($_GET);
        $keyword = $keyword ?? "";
        $cleanedKeyword = str_replace('%', '', $keyword);
        $formedKeyword ='%'.$cleanedKeyword.'%';
        // var_dump($keyword);
        // var_dump($formedKeyword);
    }

    //Getting the number of products & pages
    $query ="SELECT COUNT(*) FROM products, market_user 
    where products.market_email = market_user.email
    AND market_user.email = ? AND product_title LIKE ?;";
    $stmt = $db->prepare($query);
    $stmt->execute([$user["email"],$formedKeyword]);
    $prodCnt = $stmt ->fetch()[0] ;
    $pageCnt = ceil($prodCnt /4);
    // var_dump($pageCnt);
    $page= $_GET["page"] ?? 1;
    $firstItemIndex = ($page-1)*4;
    // var_dump($firstItemIndex);

    $getQuery = "SELECT * FROM products, market_user 
    where products.market_email = market_user.email
    AND market_user.email = ? AND product_title LIKE ?
    ORDER BY product_exp_date LIMIT ?,4; ";

    if($_SERVER["REQUEST_METHOD"]=="GET"){
        $stmt = $db->prepare($getQuery);
        $stmt->bindParam(1, $user["email"], PDO::PARAM_STR);
        $stmt->bindParam(2, $formedKeyword);
        $stmt->bindParam(3, $firstItemIndex, PDO::PARAM_INT);
        $stmt->execute();
        $products = $stmt ->fetchAll();
        // var_dump($products);
    }

    //Get Query





?>
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Document</title>
  <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css'><link rel="stylesheet" href="./style.css">


  <style>
    @import url("https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&display=swap");
* {
  box-sizing: border-box;

}

html,
body {
  background: #efefef;
  color: #212121;
  font-family: "Montserrat", sans-serif;
  font-size: 16px;
  height: 100%;
}

::selection {
  background: #efefef;
  color: #212121;
  mix-blend-mode: difference;
}

::-moz-selection {
  background: #efefef;
  color: #212121;
}

h1, h2, h3, h4, h5 {
  font-weight: 900;
}

h1 {
  font-size: 3em;
}

.hero-title {
  font-size: 8vw;
  line-height: 1em;
  font-weight: 900;
}



.gradient-overlay {
  bottom: 0;
  height: 50%;
  background: -moz-linear-gradient(top, rgba(33, 33, 33, 0) 0%, #212121 50%);
  background: -webkit-linear-gradient(top, rgba(33, 33, 33, 0) 0%, #212121 50%);
  background: linear-gradient(to bottom, rgba(33, 33, 33, 0) 0%, #212121 50%);
  filter: progid:DXImageTransform.Microsoft.gradient( startColorstr="#00212121", endColorstr="#212121",GradientType=0 );
  z-index: 1;
  border-bottom-right-radius: 15vw;
  pointer-events: none;
}

.video-wrap {
  position: absolute;
  width: 100%;
  height: 100%;
  overflow: hidden;
  border-bottom-right-radius: 15vw;
  pointer-events: none;
}

#video-bg {
  position: absolute;
  width: 100%;
  height: 100%;
  min-width: 100%;
  background-position: center center;
  background-size: cover;
  object-fit: cover;
  transform: rotate(180deg);
}

section {
  min-height: 800px;
  height: 800px;
  width: 100%;
}
section.hero {
  background-color: #212121;
  border-bottom-right-radius: 15vw;
  position: relative;
}
section.hero:before {
  content: "";
  background-color: #212121;
  position: absolute;
  top: 100%;
  left: 0;
  width: 15vw;
  height: 15vw;
}
section.hero:after {
  content: "";
  background-color: #efefef;
  position: absolute;
  top: 100%;
  left: 0;
  width: 15vw;
  height: 15vw;
  border-top-left-radius: 15vw;
}


@media screen and (min-width: 1200px) {
  .hero {
    height: 75vh;
  }
  .hero #video-bg {
    object-position: 0 5vw;
  }
}
@media screen and (max-width: 1199px) {
  .hero #video-bg {
    object-position: 0 15vw;
  }
}
@media screen and (max-width: 767px) {
  #takeover-nav .nav-menu {
    min-height: 500px;
  }
  #takeover-nav .nav-menu a {
    color: #212121;
  }
  #takeover-nav .nav-menu a:hover {
    color: #efefef;
  }
  #takeover-nav .nav-contact {
    min-height: 600px;
  }
  #takeover-nav .nav-contact .nav-title {
    font-size: 2.5em;
  }
}
@media screen and (max-width: 575px) {
  header .swoosh {
    width: 165px;
    height: 35px;
    top: 10px;
  }
  header .sticky-nav {
    top: 10px;
  }
  header .sticky-nav .logo {
    width: 150px;
    height: 35px;
  }
  header .sticky-nav #nav-btn {
    width: 40px;
  }
  header #takeover-nav .contact-items {
    font-size: 1em;
  }

  .hero {
    min-height: 600px;
    height: 600px;
  }
  .hero .hero-title {
    font-size: 12vw;
  }
  .hero #video-bg {
    object-position: 0 30vw;
  }
}
  </style>
</head>
<body>
<?php require "market_user_header.php"; ?>
<!-- partial:index.partial.html -->
<div class='page'>
  <section class='hero d-flex align-items-center justify-content-center'>
    <div class='video-wrap'>
      <video autoplay="" playsinline="" loop="" muted="" id="video-bg">
      <source src="https://tactusmarketing.com/wp-content/uploads/tactus-waves-hero.mp4" type="video/mp4">
      <source src="https://tactusmarketing.com/wp-content/uploads/tactus-waves-hero.mp4" type="video/mp4">
      </video>
    </div>
    <div class='position-absolute w-100 gradient-overlay'></div>
    <div class='content position-relative text-center mb-5'>
      <h1 class='hero-title blend'>
        Welcome Back
        <br>
        
      </h1>
    </div>

</div>

</body>
</html>

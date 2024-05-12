<?php
   session_start() ;
   require "db.php" ;

   if ( !isAuthenticated()) {
      header("Location: index.php") ;
      exit ;
   }

   //market user logout
   // delete remember me part
   if(isset($_SESSION["market_user"])){
      setMarketTokenByEmail($_SESSION["market_user"]["email"], null) ;
   }
   setcookie("access_token", "", 1) ;
   
   //customer logout
   if(isset($_COOKIE["shoppingCart"])){
    setcookie("shoppingCart", "",1);
   }
   
   // delete session file
   session_destroy() ;
   // delete session cookie
   setcookie("PHPSESSID", "", 1 , "/") ; // delete memory cookie 

   // redirect to login page.
   header("Location: index.php") ;
<?php
   session_start() ;
   require "db.php" ;

   if ( !isAuthenticated()) {
      header("Location: index.php") ;
      exit ;
   }

   // delete remember me part
   setTokenByEmail($_SESSION["user"]["email"], null) ;
   setcookie("access_token", "", 1) ;
   
   if(isset($_COOKIE["shoppingCart"])){
    setcookie("shoppingCart", "",1);
   }
   
   // delete session file
   session_destroy() ;
   // delete session cookie
   setcookie("PHPSESSID", "", 1 , "/") ; // delete memory cookie 

   // redirect to login page.
   header("Location: index.php") ;
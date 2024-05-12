<?php
   session_start() ;
   require "db.php" ;

   if (isAuthenticated()) {
      setTokenByEmail($_SESSION["market_user"]["email"], null) ;
   }
   elseif(isAuthenticatedCusto()){
      setCustoTokenByEmail($_SESSION["customer_user"]["email"], null) ;
   }
   else{
      header("Location: index.php") ;
      exit ;
   }

   // delete remember me part
   #setTokenByEmail($_SESSION["market_user"]["email"], null) ;
   #setCustoTokenByEmail($_SESSION["customers"]["email"], null) ;
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
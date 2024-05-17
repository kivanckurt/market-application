<?php
   session_start() ;
   require "db.php" ;

   if (isAuthenticated() && $_GET["user"]==0) {
      setTokenByEmail($_SESSION["market_user"]["email"], null) ;
      setcookie("market_access_token", "", 1) ;
   }
   elseif(isAuthenticatedCusto() && $_GET["user"]==1){
      setCustoTokenByEmail($_SESSION["customer_user"]["email"], null) ;
      setcookie("custo_access_token", "", 1) ;
      if(isset($_COOKIE["shoppingCart"])){
         setcookie("shoppingCart", "",1);
        }
   }
   else{
      header("Location: index.php") ;
      exit ;
   }

   // delete remember me part
   #setTokenByEmail($_SESSION["market_user"]["email"], null) ;
   #setCustoTokenByEmail($_SESSION["customers"]["email"], null) ;  
   
   // delete session file
   session_destroy() ;
   // delete session cookie
   setcookie("PHPSESSID", "", 1 , "/") ; // delete memory cookie 

   // redirect to login page.
   header("Location: index.php") ;
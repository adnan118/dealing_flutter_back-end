<?php

 $dsn="mysql:host=localhost;dbname=dealing";
 $user="root";
 $pass="";

/* $dsn="mysql:host=mysql11.serv00.com;dbname=m1241_smc";
 $user="m1241_smc";
 $pass="l#^yVeC2PQgQ!Wd@rPxd";
 */
$option=array( ///support arabic
PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES UTF8"
);

   
try {
   include "functions.php";
   $con = new PDO($dsn, $user, $pass, $option);
   $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   header("Access-Control-Allow-Origin: *");
   header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With, Access-Control-Allow-Origin");
   header("Access-Control-Allow-Methods: POST, OPTIONS , GET");
  
 
   if (!isset($notAuth)) {     
       // checkAuthenticate();   
      }
} catch (PDOException $e) {
   echo $e->getMessage();
}
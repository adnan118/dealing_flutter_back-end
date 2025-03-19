<?php
include "../connect.php";


$email =    htmlspecialchars(strip_tags($_POST["user_email"]));
$user_code =      rand(10000,99999);


$data=array(
    "user_code"=>$user_code
);
updateData("user_dealing",$data,"user_email='$email'");
sentMail($email,"Hello we happy foe enjoy you to us " ,  "your Verify Code is :  $user_code  ");


 
 



 

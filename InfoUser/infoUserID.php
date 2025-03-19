<?php  

include "../connect.php";  
$user_id=  htmlspecialchars(strip_tags($_POST["user_id"]));  


getAllData("user_dealing","user_id = $user_id");
 

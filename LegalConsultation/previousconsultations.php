<?php  

include "../connect.php";  
 
$consultation_userId = htmlspecialchars(strip_tags($_POST["consultation_userId"]));


getAllData("consultation_dealing","consultation_userId =$consultation_userId");
 

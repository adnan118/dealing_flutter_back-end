<?php

include "../connect.php";

$users_name = htmlspecialchars(strip_tags($_POST["user_name"]));  
$users_location = htmlspecialchars(strip_tags($_POST["user_location"]));  
$users_email = htmlspecialchars(strip_tags($_POST["user_email"]));  
$users_phone = htmlspecialchars(strip_tags($_POST["user_phone"]));  
$users_code = rand(00000,99999);  
 

ini_set('display_errors',1);  
ini_set('display_startup_errors',1);  
error_reporting(E_ALL);  

// Check if email or phone already exists
$stmt = $con->prepare("SELECT * FROM `user_dealing` WHERE `user_email`=? OR `user_phone`=?");  
$stmt->execute(array($users_email, $users_phone));  
$count = $stmt->rowCount();  

if ($count >0) {  
 echo json_encode(array("status" => "fail", "message" => "Email or phone already exists"));  
} else {  
  

 // Insert new user 
 $stmt = $con->prepare("INSERT INTO `user_dealing`(`user_name`, `user_location`, `user_email`, `user_phone`, `user_code`) VALUES (:USER,:LOCATIONE, :EMAIL, :PHONE, :CODE  )");  
 $stmt->execute(array(  
 ":USER" => $users_name,  
 ":LOCATIONE" => $users_location, 
 ":EMAIL" => $users_email,  
 ":PHONE" => $users_phone,   
 ":CODE" => $users_code,   
 ));  

 $count = $stmt->rowCount();  

 if ($count >0) {  
 // Send verification email 
 $headerFrom = "From: adnanbarakat111@gmail.com" . "\n" . "CC: manager@gmail.com";  
 sentMail($users_email, "Welcome!", "Your verification code is: '$users_code'");  
 echo json_encode(array("status" => "success"));  
 } else {  
 echo json_encode(array("status" => "fail", "message" => "Registration failed"));  
 }  
}  
?>



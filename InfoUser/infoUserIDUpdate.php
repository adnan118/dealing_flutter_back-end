
<?php  

include "../connect.php";  
 
$user_id=  htmlspecialchars(strip_tags($_POST["user_id"]));  
$user_name=  htmlspecialchars(strip_tags($_POST["user_name"]));  
$user_location=  htmlspecialchars(strip_tags($_POST["user_location"]));  
$user_email=  htmlspecialchars(strip_tags($_POST["user_email"]));  
$user_phone=  htmlspecialchars(strip_tags($_POST["user_phone"]));  
$user_img=  htmlspecialchars(strip_tags($_POST["user_img"]));  

  


if(isset($_FILES['file'])){
    deleteFile("images/" , $user_img);
    $user_img=imageUpload("file");
}

$data = array(  
    "user_name" => $user_name,   
    "user_location" => $user_location,   
    "user_email" => $user_email,   
    "user_phone" => $user_phone,   
    "user_img" => $user_img,   
);  



updateData("user_dealing",$data,"user_id = $user_id");
  
 

 


















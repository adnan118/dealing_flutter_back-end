<?php  

include "../connect.php";  
$users_code=  htmlspecialchars(strip_tags($_POST["user_code"]));  
 
  
 
$stmt = $con->prepare("SELECT * FROM `user_dealing` WHERE user_code = :CODE ");  
$stmt->execute(array(   
    ":CODE"  => $users_code,   
));  


 
$data = $stmt->fetch(PDO::FETCH_ASSOC);
$count = $stmt->rowCount(); 


if ($count > 0) {  
    echo json_encode(array("status" => "success", "data" => $data));  
} else {  
    echo json_encode(array("status" => "failure"));  
}  



////////////////////////////////////////////////////////////////////////
 

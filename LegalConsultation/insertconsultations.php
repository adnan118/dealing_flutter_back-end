
<?php  

include "../connect.php";  
 
$consultation_userId = htmlspecialchars(strip_tags($_POST["consultation_userId"]));
$consultation_title = htmlspecialchars(strip_tags($_POST["consultation_title"]));
$consultation_body =    htmlspecialchars(strip_tags($_POST["consultation_body"]));
$consultation_lawyer =    htmlspecialchars(strip_tags($_POST["consultation_lawyer"]));
$currentDateTime = date('Y-m-d H:i:s');  

 
 

$data = array(  
    "consultation_userId"=>$consultation_userId, 
    "consultation_title" => $consultation_title,   
    "consultation_body" => $consultation_body,   
    "consultation_lawyer" => $consultation_lawyer,   
 
);  

 insertData("consultation_dealing", $data, true);  




 $notification_bodyEn   = "Your consultation has been submitted.";  
 $notification_bodyAr= "لقد تم تقديم استشارتك."; 

 $notification_titleAr="معاملات-استشارة";
 $notification_titleEn="Dealings-consultation";
sendGCM("Dealings", "Your consultation has been submitted.", "users$consultation_userId", "none", "none");  

$dataN = array(  
    "notification_bodyAr" => $notification_bodyAr,  
    "notification_bodyEn" => $notification_bodyEn,  
    "notification_titleAr" => $notification_titleAr, 
    "notification_titleEn" => $notification_titleEn,  
    "notification_user" => $consultation_userId,  
    "notification_dateInsert"=>$currentDateTime,
    "notification_namePage" => "/LegalConsultation",  
);  

insertData("notification_dealing", $dataN, false);  

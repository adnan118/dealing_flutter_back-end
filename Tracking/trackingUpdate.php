<?php  
include "../connect.php";  

$tracking_userId = htmlspecialchars(strip_tags($_POST["tracking_userId"]));  
$tracking_id = htmlspecialchars(strip_tags($_POST["tracking_id"]));  

$tracking_descAr = htmlspecialchars(strip_tags($_POST["tracking_descAr"]));  
$tracking_descEn = htmlspecialchars(strip_tags($_POST["tracking_descEn"]));  
$currentDateTime = date('Y-m-d H:i:s');  

try {  
    // إعداد استعلام التحديث  
    $sql = "  
        UPDATE tracking_dealing   
        SET   
            tracking_descAr = CONCAT(IFNULL(tracking_descAr, ''),   
                                      IF(IFNULL(tracking_descAr, '') = '', '', '\n'),   
                                      :tracking_descAr,   
                                      IF(IFNULL(tracking_descAr, '') = '', '', ' '),   
                                      :tracking_date),  

            tracking_descEn = CONCAT(IFNULL(tracking_descEn, ''),   
                                      IF(IFNULL(tracking_descEn, '') = '', '', '\n'),   
                                      :tracking_descEn,   
                                      IF(IFNULL(tracking_descEn, '') = '', '', ' '),   
                                      :tracking_date),  

             tracking_date =  

            CONCAT(IFNULL(tracking_date, ''),   
                                      IF(IFNULL(tracking_date, '') = '', '', '\n\n\n'),   
                                      :tracking_date)
        WHERE   
            tracking_userId = :tracking_userId AND tracking_id = :tracking_id  
    ";  

    // تحضير الاستعلام  
    $stmt = $con->prepare($sql);  

    // ربط القيم  
    $stmt->bindParam(':tracking_descAr', $tracking_descAr);  
    $stmt->bindParam(':tracking_descEn', $tracking_descEn);  
    $stmt->bindParam(':tracking_date', $currentDateTime);  
    $stmt->bindParam(':tracking_userId', $tracking_userId);  
    $stmt->bindParam(':tracking_id', $tracking_id);  

    // تنفيذ الاستعلام  
    $stmt->execute();  
     
    $count = $stmt->rowCount();  
    
    if ($count > 0) {  
        echo json_encode(array("status" => "success"));  
    } else {  
        echo json_encode(array("status" => "failure"));  
    }  
    
} catch (PDOException $e) {  
    echo "error " . $e->getMessage();  
}

$notification_bodyEn   = "New update on your request";  
$notification_bodyAr= "تحديث جديد على طلبك"; 

$notification_titleAr="معاملات-تتبع";
$notification_titleEn="Dealings-Tracking";
sendGCM("Dealings", "New update on your request.", "users$tracking_userId", "none", "none");  

$dataN = array(  
   "notification_bodyAr" => $notification_bodyAr,  
   "notification_bodyEn" => $notification_bodyEn,  
   "notification_titleAr" => $notification_titleAr, 
   "notification_titleEn" => $notification_titleEn,  
   "notification_user" => $tracking_userId ,  
   "notification_dateInsert"=>$currentDateTime,
   "notification_namePage" => "/Tracking",  
);  

insertData("notification_dealing", $dataN, false);  




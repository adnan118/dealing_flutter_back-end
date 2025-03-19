<?php  
include "../connect.php";  

$lawyer_id = htmlspecialchars(strip_tags($_POST["lawyer_id"]));   
$starsRate = htmlspecialchars(strip_tags($_POST["starsRate"]));   
$tracking_id =htmlspecialchars(strip_tags($_POST["tracking_id"]));
// جلب جميع التقييمات الحالية للمحامي  
$query = "SELECT COUNT(*) as count, SUM(lawyr_rate) as total FROM lawyer_dealing WHERE lawyr_id = :lawyer_id";  

$stmt = $con->prepare($query);  // استخدم $con بدلاً من $pdo  
$stmt->execute(['lawyer_id' => $lawyer_id]);  
$result = $stmt->fetch();  

$currentCount = $result['count'];  
$totalRating = $result['total'];  

// حساب المتوسط الجديد  
$newCount = $currentCount + 1;  
$newTotalRating = $totalRating + $starsRate;  
$newAverageRating = $newTotalRating / $newCount;  

// تحديث حقل lawyr_rate  
$updateQuery = "UPDATE lawyer_dealing SET lawyr_rate = :newRate WHERE lawyr_id = :lawyer_id";  
$updateStmt = $con->prepare($updateQuery);  // استخدم $con بدلاً من $pdo  
$updateStmt->execute([  
    'newRate' => round($newAverageRating, 1),  
    'lawyer_id' => $lawyer_id  
]);  

$count = $updateStmt->rowCount();
if ($count > 0) {
    echo json_encode(array("status" => "success"));
} else {
    echo json_encode(array("status" => "failure"));
}
 
 
 
$dataN = array(    
    "tracking_isRating"=>1
 );  
 
updateData("tracking_dealing",$dataN ,"tracking_id = $tracking_id ",false)
 
?>
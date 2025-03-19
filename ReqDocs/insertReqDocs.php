
<?php  

include "../connect.php";  
 
$docs_userId = htmlspecialchars(strip_tags($_POST["docs_userId"]));
$docs_nameAr = htmlspecialchars(strip_tags($_POST["docs_nameAr"]));
$docs_nameEn =    htmlspecialchars(strip_tags($_POST["docs_nameEn"]));
$docs_nationalNumber =    htmlspecialchars(strip_tags($_POST["docs_nationalNumber"]));
$docs_birthDate = htmlspecialchars(strip_tags($_POST["docs_birthDate"]));
$docs_birthCity = htmlspecialchars(strip_tags($_POST["docs_birthCity"]));
$docs_typeDocsId = htmlspecialchars(strip_tags($_POST["docs_typeDocsId"]));
$docs_lawyrId = htmlspecialchars(strip_tags($_POST["docs_lawyrId"]));
$docs_countryDestinationId = htmlspecialchars(strip_tags($_POST["docs_countryDestinationId"]));
$docs_translationDocsId = htmlspecialchars(strip_tags($_POST["docs_translationDocsId"]));
$docs_imgId = htmlspecialchars(strip_tags($_POST["docs_imgId"]));
$currentDateTime = date('Y-m-d H:i:s');  

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if(isset($_FILES['file'])){
    deleteFile("images/" , $docs_imgId);
    $docs_imgId=imageUpload("file");
}

$data = array(  
    "docs_nameAr" => $docs_nameAr,   
    "docs_nameEn" => $docs_nameEn,   
    "docs_nationalNumber" => $docs_nationalNumber,   
    "docs_birthDate" => $docs_birthDate,   
    "docs_birthCity" => $docs_birthCity,   
    "docs_typeDocsId" => $docs_typeDocsId,   
    "docs_lawyrId" => $docs_lawyrId,   
    "docs_countryDestinationId" => $docs_countryDestinationId,   
    "docs_translationDocsId" => $docs_translationDocsId,   
    "docs_imgId" => $docs_imgId,  
    "docs_userId"=>$docs_userId,
    "docs_dateInsert"=>$currentDateTime,
);  

$tracking_docPassID =insertData("docs_dealing", $data, true);  




 $notification_bodyEn   = "Your request($docs_nameEn) has been submitted successfully, please pay.";  
 $notification_bodyAr= " لقد تم تقديم طلبك($docs_nameAr) بنجاح، يرجى الدفع.";  

 $notification_titleAr="معاملات-وثيقة($docs_nameAr)";
 $notification_titleEn="Dealings-Document($docs_nameEn)";
sendGCM("Dealings", "Your order($docs_nameEn) has been submitted successfully, please pay.", "users$docs_userId", "none", "none");  

$dataN = array(  
    "notification_bodyAr" => $notification_bodyAr,  
    "notification_bodyEn" => $notification_bodyEn,  
    "notification_titleAr" => $notification_titleAr,
    "notification_titleEn" => $notification_titleEn,  
    "notification_user" => $docs_userId,  
    "notification_dateInsert"=>$currentDateTime,
    "notification_namePage" => "/PaymentsPage",  
);  

insertData("notification_dealing", $dataN, false);  





 
 // تحقق إذا تمت العملية بنجاح  
if ($tracking_docPassID !== false) {  
    // استخدم $tracking_docPassID كمعرف الوثيقة التي تم إنشاؤها  
    $dataT = array(  
        "tracking_docPassID" => $tracking_docPassID,  
        "tracking_userId" => $docs_userId, 
        "tracking_docPassType" => "Documents",
        "tracking_date"=> $currentDateTime, 
        "tracking_nameOwnerAr" => $docs_nameAr,   
        "tracking_nameOwnerEn" => $docs_nameEn,     
        "tracking_typeDocsID" => $docs_typeDocsId,     
    );  
    insertData("tracking_dealing", $dataT, false);  
    
} else {  
    // معالجة الخطأ هنا  
    http_response_code(500); // تعيين رمز الحالة إلى 500 (خطأ في الخادم)  
    exit;  // إنهاء السكربت بعد إرسال الخطأ  
}




















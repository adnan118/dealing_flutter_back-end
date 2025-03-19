
<?php  

include "../connect.php";  
 
$passports_userId = htmlspecialchars(strip_tags($_POST["passports_userId"]));
$passports_relation = htmlspecialchars(strip_tags($_POST["passports_relation"]));
$passports_nameAr =    htmlspecialchars(strip_tags($_POST["passports_nameAr"]));
$passports_nameEn =    htmlspecialchars(strip_tags($_POST["passports_nameEn"]));

$passports_surnameAr = htmlspecialchars(strip_tags($_POST["passports_surnameAr"]));
$passports_surnameEn = htmlspecialchars(strip_tags($_POST["passports_surnameEn"]));

$passports_fatherNameAr = htmlspecialchars(strip_tags($_POST["passports_fatherNameAr"]));
$passports_fatherNameEn = htmlspecialchars(strip_tags($_POST["passports_fatherNameEn"]));

$passports_motherNameAr = htmlspecialchars(strip_tags($_POST["passports_motherNameAr"]));
$passports_motherNameEn = htmlspecialchars(strip_tags($_POST["passports_motherNameEn"]));

$passports_nationality = htmlspecialchars(strip_tags($_POST["passports_nationality"]));
$passports_gender = htmlspecialchars(strip_tags($_POST["passports_gender"]));
$passports_birthDate = htmlspecialchars(strip_tags($_POST["passports_birthDate"]));
$passports_placeOfBirthAr = htmlspecialchars(strip_tags($_POST["passports_placeOfBirthAr"]));
$passports_placeOfBirthEn = htmlspecialchars(strip_tags($_POST["passports_placeOfBirthEn"]));
$passports_typePassport = htmlspecialchars(strip_tags($_POST["passports_typePassport"]));
$passports_placePassportRcv = htmlspecialchars(strip_tags($_POST["passports_placePassportRcv"]));
$passports_nationalNumber = htmlspecialchars(strip_tags($_POST["passports_nationalNumber"]));

$passports_Oldpassportnumber = htmlspecialchars(strip_tags($_POST["passports_Oldpassportnumber"]));
$passports_OldpassportDate = htmlspecialchars(strip_tags($_POST["passports_OldpassportDate"]));
$passports_OldpassportExpiryDate = htmlspecialchars(strip_tags($_POST["passports_OldpassportExpiryDate"]));
$passports_imgid = htmlspecialchars(strip_tags($_POST["passports_imgid"]));
$passports_haveoldpassport = htmlspecialchars(strip_tags($_POST["passports_haveoldpassport"]));
$passports_lawyer = htmlspecialchars(strip_tags($_POST["passports_lawyer"]));
$passports_Totalcoast = htmlspecialchars(strip_tags($_POST["passports_Totalcoast"]));
$currentDateTime = date('Y-m-d H:i:s');  

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if(isset($_FILES['file'])){
    deleteFile("images/" , $passports_imgid);
    $passports_imgid=imageUpload("file");
}

$data = array(  
    "passports_userId"=>$passports_userId, 
    "passports_relation" => $passports_relation,   
    "passports_nameAr" => $passports_nameAr,   
    "passports_nameEn" => $passports_nameEn,   
    "passports_surnameAr" => $passports_surnameAr,   
    "passports_surnameEn" => $passports_surnameEn,   
    "passports_fatherNameAr" => $passports_fatherNameAr,   
    "passports_fatherNameEn" => $passports_fatherNameEn,   
    "passports_motherNameAr" => $passports_motherNameAr,   
    "passports_motherNameEn" => $passports_motherNameEn,   
    "passports_nationality" => $passports_nationality,   
    "passports_gender" => $passports_gender,   
    "passports_birthDate" => $passports_birthDate,   
    "passports_placeOfBirthAr" => $passports_placeOfBirthAr,       
    "passports_placeOfBirthEn" => $passports_placeOfBirthEn,   
    "passports_typePassport" => $passports_typePassport,   
    "passports_placePassportRcv" => $passports_placePassportRcv,   
    "passports_nationalNumber" => $passports_nationalNumber,   
    "passports_Oldpassportnumber" => $passports_Oldpassportnumber,   
    "passports_OldpassportDate" => $passports_OldpassportDate,   
    "passports_OldpassportExpiryDate" => $passports_OldpassportExpiryDate,   
    "passports_imgid" => $passports_imgid,  
    "passports_haveoldpassport" => $passports_haveoldpassport,  
    "passports_lawyer" => $passports_lawyer,  
    "passports_Totalcoast" => $passports_Totalcoast,  
    "passports_dateInsert"=>$currentDateTime,
);  

$tracking_docPassID =insertData("passports_dealing", $data, true);  




 $notification_bodyEn   = "Your request($passports_nameEn) has been submitted successfully, please pay.";  
 $notification_bodyAr= " لقد تم تقديم طلبك($passports_nameAr) بنجاح، يرجى الدفع."; 

 $notification_titleAr="معاملات-جواز سفر($passports_nameAr)";
 $notification_titleEn="Dealings-Passport($passports_nameEn)";
sendGCM("Dealings", "Your order($passports_nameEn) has been submitted successfully, please pay.", "users$passports_userId", "none", "none");  

$dataN = array(  
    "notification_bodyAr" => $notification_bodyAr,  
    "notification_bodyEn" => $notification_bodyEn,  
    "notification_titleAr" => $notification_titleAr, 
    "notification_titleEn" => $notification_titleEn,  
    "notification_user" => $passports_userId,  
    "notification_dateInsert"=>$currentDateTime,
    "notification_namePage" => "/PaymentsPage",  
);  

insertData("notification_dealing", $dataN, false);  


 // تحقق إذا تمت العملية بنجاح  
 if ($tracking_docPassID !== false) {  
    // استخدم $tracking_docPassID كمعرف الوثيقة التي تم إنشاؤها  
    $dataT = array(  
        "tracking_docPassID" => $tracking_docPassID,  
        "tracking_userId" => $passports_userId ,    
        "tracking_docPassType" => "Passports",   
        "tracking_date"=> $currentDateTime, 
        "tracking_nameOwnerAr" => $passports_nameAr."".$passports_fatherNameAr."".$passports_surnameAr,   
        "tracking_nameOwnerEn" => $passports_nameEn."".$passports_fatherNameEn."".$passports_surnameEn,   
     );  
    insertData("tracking_dealing", $dataT, false);  
    
} else {  
    // معالجة الخطأ هنا  
    http_response_code(500); // تعيين رمز الحالة إلى 500 (خطأ في الخادم)  
    exit;  // إنهاء السكربت بعد إرسال الخطأ  
}

 
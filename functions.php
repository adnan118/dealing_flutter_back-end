<?php

 
function printFailure($msg="none"){
   echo json_encode(array("status" => "failure","msg" => $msg));
}
 

function printSuccess($msg="none"){
    echo json_encode(array("status" => "success","msg" => $msg));
 }

 
function result($count){
    if($count >0){
        printSuccess();
    }else{
        printFailure();
    }
 }


function sentMail($to , $subjectTitle , $msgBody){
 
    $headerFrom="From: adnanbarakat111@gmail.com"."\n"."CC: manager@gmail.com";
    mail($to , $subjectTitle , $msgBody , $headerFrom );
    
    }
// ==========================================================

// ==========================================================

define("MB", 1048576);

function filterRequest($requestname)
{
  return  htmlspecialchars(strip_tags($_POST[$requestname]));
}

function getAllData($table, $where = null, $values = null,$json =true)
{
    global $con;
    $data = array();
    if($where == null){
        $stmt = $con->prepare("SELECT  * FROM $table  ");
    }else{
        $stmt = $con->prepare("SELECT  * FROM $table WHERE   $where ");
    }
  
    $stmt->execute($values);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $count  = $stmt->rowCount();
    if($json == true){
        if ($count > 0){
            echo json_encode(array("status" => "success", "data" => $data));
        } else {
            echo json_encode(array("status" => "failure"));
        }
        return $count;
    }else{

        if($count>0){
            return (array("status" => "success", "data" => $data));
        }else{
            return (array("status" => "failure"));
        }
    }
}

function getData($table, $where = null, $values = null,$json = true)
{
    global $con;
    $data = array();
    $stmt = $con->prepare("SELECT  * FROM $table WHERE   $where ");
    $stmt->execute($values);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    $count  = $stmt->rowCount();
    if($json == true){
                    if ($count > 0){
                        echo json_encode(array("status" => "success", "data" => $data));
                    } else {
                        echo json_encode(array("status" => "failure"));
                    }
                    
    }else{

        return $count;
    }
    
}

function insertData($table, $data, $json = true)
{
    global $con;
    foreach ($data as $field => $v)
        $ins[] = ':' . $field;
    $ins = implode(',', $ins);
    $fields = implode(',', array_keys($data));
    $sql = "INSERT INTO $table ($fields) VALUES ($ins)";

    $stmt = $con->prepare($sql);
    foreach ($data as $f => $v) {
        $stmt->bindValue(':' . $f, $v);
    }
    $stmt->execute();
    $count = $stmt->rowCount();
        // استرجاع معرف السجل الجديد إذا تم الإدخال بنجاح  
        $lastInsertId = $count > 0 ? $con->lastInsertId() : null;  

    if ($json == true) {
    if ($count > 0) {
        echo json_encode(array("status" => "success"));
    } else {
        echo json_encode(array("status" => "failure"));
    }
  }
  // إرجاع معرف السجل إذا تمت العملية بنجاح، وإلا ارجع 0  
  return $count > 0 ? $lastInsertId : false; 
}


function updateData($table, $data, $where, $json = true)
{
    global $con;
    $cols = array();
    $vals = array();

    foreach ($data as $key => $val) {
        $vals[] = "$val";
        $cols[] = "`$key` =  ? ";
    }
    $sql = "UPDATE $table SET " . implode(', ', $cols) . " WHERE $where";

    $stmt = $con->prepare($sql);
    $stmt->execute($vals);
    $count = $stmt->rowCount();
    if ($json == true) {
    if ($count > 0) {
        echo json_encode(array("status" => "success"));
    } else {
        echo json_encode(array("status" => "failure"));
    }
    }
    return $count;
}

function deleteData($table, $where, $json = true)
{
    global $con;
    $stmt = $con->prepare("DELETE FROM $table WHERE $where");
    $stmt->execute();
    $count = $stmt->rowCount();
    if ($json == true) {
        if ($count > 0) {
            echo json_encode(array("status" => "success"));
        } else {
            echo json_encode(array("status" => "failure"));
        }
    }
    return $count;
}


function imageUpload($imageRequest)
{
    global $msgError;
    $imagename = rand(1000, 10000) . $_FILES[$imageRequest]['name'];
    $imagetmp = $_FILES[$imageRequest]['tmp_name'];
    $imagesize = $_FILES[$imageRequest]['size'];
    $allowExt = array("jpg", "png", "gif", "mp3", "pdf");
    $strToArray = explode(".", $imagename);
    $ext = end($strToArray);
    $ext = strtolower($ext);

    if (!in_array($ext, $allowExt)) {
        $msgError[] = "EXT";
    }
    if ($imagesize > 20 * 1024 * 1024) {
        $msgError[] = "size";
    }
    if (empty($msgError)) {
        move_uploaded_file($imagetmp, "images/" . $imagename);
        return $imagename;
    }
    return "fail";
}
 function checkActiveSubscription($table, $where = null, $values = null, $json = true) {
    global $con;
    $data = array();

    // إنشاء نص الاستعلام بناءً على ما إذا كان يوجد شرط أم لا
    if ($where == null) {
        $stmt = $con->prepare("SELECT * FROM $table");
    } else {
        $stmt = $con->prepare("SELECT * FROM $table WHERE $where");
    }

    // تنفيذ الاستعلام
    $stmt->execute($values);
    $data = $stmt->fetch(PDO::FETCH_ASSOC); // استخدم fetch بدلاً من fetchAll للحصول على صف واحد
    $count = $stmt->rowCount();

    // التحقق من وجود تسجيل نشط
    if ($count > 0) {
        $sub_course = $data['sub_course']; // الحصول على sub_course
        $sub_endDate = $data['sub_endDate'];
        
        // التحقق مما إذا كانت الاشتراك فعال اليوم
        $currentDate = date('Y-m-d');
        $active = ($sub_endDate >= $currentDate) ? 1 : 0;

        echo json_encode(array("status" => "success", "active" => $active, "sub_course" => $sub_course));
    } else {
        echo json_encode(array("status" => "failure", "active" => 0, "sub_course" => null));
    }
    return $count;
}

function imageUploadPath($path,$imageRequest)
{
    if(isset($_FILES[$imageRequest])){
  global $msgError;
  $imagename  = rand(1000, 10000) . $_FILES[$imageRequest]['name'];
  $imagetmp   = $_FILES[$imageRequest]['tmp_name'];
  $imagesize  = $_FILES[$imageRequest]['size'];
  $allowExt   = array("jpg", "png", "gif", "mp3", "pdf");
  $strToArray = explode(".", $imagename);
  $ext        = end($strToArray);
  $ext        = strtolower($ext);

  if (!empty($imagename) && !in_array($ext, $allowExt)) {
    $msgError[] = "EXT";
  }
  if ($imagesize > 20 * MB) {
    $msgError[] = "size";
  }
  if (empty($msgError)) {
    move_uploaded_file($imagetmp,  $path ."/". $imagename);
   
    return $imagename;
  } else {
      
    return "fail";
  }
}
else{
    return "empty";
}
}



function deleteFile($dir, $imagename)
{
    if (file_exists($dir . "/" . $imagename)) {
        unlink($dir . "/" . $imagename);
    }
}

function checkAuthenticate()
{
    if (isset($_SERVER['PHP_AUTH_USER'])  && isset($_SERVER['PHP_AUTH_PW'])) {
        if ($_SERVER['PHP_AUTH_USER'] != "wael" ||  $_SERVER['PHP_AUTH_PW'] != "wael12345") {
            header('WWW-Authenticate: Basic realm="My Realm"');
            header('HTTP/1.0 401 Unauthorized');
            echo 'Page Not Found';
            exit;
        }
    } else {
        exit;
    }

    // End 
}


//notifications
function sendGCM($title, $message, $topic, $pageid, $pagename)
{


    $url = 'https://fcm.googleapis.com/fcm/send';

    $fields = array(
        "to" => '/topics/' . $topic,
        'priority' => 'high',
        'content_available' => true,

        'notification' => array(
            "body" =>  $message,
            "title" =>  $title,
            "click_action" => "FLUTTER_NOTIFICATION_CLICK",
            "sound" => "default"

        ),
        'data' => array(
            "pageid" => $pageid,
            "pagename" => $pagename
        )

    );


    $fields = json_encode($fields);
    $headers = array(
        'Authorization: key=' . "AAAAGp_OHeQ:APA91bEwLOWLXFLHP85hDNiA405DoemOep-sLdKb4ao-XoH-cYCELAXmbsb3QQYkRZ9UOxvScZ9Sr1pG04IhlRhWuZ_CTCCTmWCszaskX3ipgoTj7UUnV3NO3_nuFgo7jHdMWiKjV3mP",
        
        'Content-Type: application/json'
    );
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

    $result = curl_exec($ch);
    return $result;
    curl_close($ch);
}







 function insertNotify(
 $notification_title,
 $notification_titleAr,
 $notification_body,
 $notification_bodyAr,
 $notification_users,
 $topic,
 $pageid,
 $pagename,
 ){
    global $con;
    $stmt = $con->prepare("
    INSERT INTO `notification`( `notification_title`, `notification_titleAr`, `notification_body`, `notification_bodyAr`, `notification_users`) 
    VALUES 
    (?,?,?,?,?) 
    ");
    $stmt ->execute(
        array(
            $notification_title,
            $notification_titleAr,
            $notification_body,
            $notification_bodyAr,
            $notification_users,
        )
    );
    sendGCM($notification_title,$notification_body,$topic,$pageid,$pagename);
     $count = $stmt->rowCount();
     return $count;
 }
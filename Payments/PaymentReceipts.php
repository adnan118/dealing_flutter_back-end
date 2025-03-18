<?php
include "../connect.php";

$PaymentReceipts_userId = htmlspecialchars(strip_tags($_POST["PaymentReceipts_userId"]));
$PaymentReceipts_invoicNumber=htmlspecialchars(strip_tags($_POST["PaymentReceipts_invoicNumber"]));
$PaymentReceipts_imgID = htmlspecialchars(strip_tags($_POST["PaymentReceipts_imgID"]));
$PaymentReceipts_totalCoast = htmlspecialchars(strip_tags($_POST["PaymentReceipts_totalCoast"]));
$docsPass_id = htmlspecialchars(strip_tags($_POST["docsPass_id"]));
$typeReq = htmlspecialchars(strip_tags($_POST["typeReq"]));

if(isset($_FILES['file'])){
    deleteFile("images/" , $PaymentReceipts_imgID);
    $PaymentReceipts_imgID=imageUpload("file");
}


$data=array(
    "PaymentReceipts_userId"=>$PaymentReceipts_userId,
    "PaymentReceipts_invoicNumber"=>$PaymentReceipts_invoicNumber,
    "PaymentReceipts_imgID"=>$PaymentReceipts_imgID,
    "PaymentReceipts_totalCoast"=>$PaymentReceipts_totalCoast,
);
  insertData("PaymentReceipts_dealing", $data, true);  


  
if($typeReq =="Documents"){
    $dataT=array(
        "docs_trakingPay"=>4, 
    );
  updateData("docs_dealing",$dataT ,"docs_id =$docsPass_id",false);
}

if($typeReq =="Passports"){
    $dataT=array(
        "passports_trakingPay"=>4, 
    );
    updateData("passports_dealing",$dataT ,"passports_id =$docsPass_id",false);
  }
 

  
<?php
include "../connect.php";

$passports_id = htmlspecialchars(strip_tags($_POST["passports_id"]));
$passports_trakingPay=htmlspecialchars(strip_tags($_POST["passports_trakingPay"]));
$passports_paied=htmlspecialchars(strip_tags($_POST["passports_paied"]));
$data=array(
    "passports_trakingPay"=>$passports_trakingPay,
    "passports_paied"=>$passports_paied,
);
updateData("passports_dealing",$data ,"passports_id =$passports_id");

 


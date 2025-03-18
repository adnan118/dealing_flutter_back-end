<?php
include "../connect.php";

$docs_id = htmlspecialchars(strip_tags($_POST["docs_id"]));
$docs_trakingPay=htmlspecialchars(strip_tags($_POST["docs_trakingPay"]));
$docs_paied=htmlspecialchars(strip_tags($_POST["docs_paied"]));
$data=array(
    "docs_trakingPay"=>$docs_trakingPay,
    "docs_paied"=>$docs_paied,
);
updateData("docs_dealing",$data ,"docs_id =$docs_id");

 


<?php
include "../connect.php";


$email =    htmlspecialchars(strip_tags($_POST["users_email"]));

$vfc =      htmlspecialchars(strip_tags($_POST["users_verflyCode"]));


$stmt=$con->prepare("SELECT * FROM `users` WHERE `users_email`='$email' And `users_verflyCode`='$vfc' ");
$stmt->execute();

$count=$stmt->rowCount();//0 or 1


if($count >0){
    $data=array("users_approve" => "1");
   


    $stmt=$con->prepare("UPDATE `users`  SET  `users_approve`=   '$data[users_approve]' WHERE `users_email` ='$email'"    );
    $stmt->execute();
    echo json_encode(array("status" => "success" ));
    sentMail($email,"Hello we happy foe enjoy you to us " ,  "your Verify Code is :  $vfc  ");







}else{

    printFailure("Error: VFC is Wrong");

}

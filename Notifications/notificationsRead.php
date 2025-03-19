<?php
include "../connect.php";

$user_id = htmlspecialchars(strip_tags($_POST["user_id"]));
$notification_id =htmlspecialchars(strip_tags($_POST["notification_id"]));
$data=array(
    "notification_read"=>1,
); 
updateData("notification_dealing", $data, "notification_user = $user_id And notification_id =$notification_id");

 







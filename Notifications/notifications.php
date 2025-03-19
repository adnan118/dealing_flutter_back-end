<?php
include "../connect.php";

$user_id = htmlspecialchars(strip_tags($_POST["user_id"]));
 
getAllData("notification_dealing", "notification_user = $user_id   
ORDER BY notification_dateInsert DESC");

 







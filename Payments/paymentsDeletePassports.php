<?php
include "../connect.php";

$passports_id = htmlspecialchars(strip_tags($_POST["passports_id"]));

deleteData("passports_dealing" ,"passports_id =$passports_id");

 
 

 
<?php
include "../connect.php";

$tracking_userId = htmlspecialchars(strip_tags($_POST["tracking_userId"]));
$tracking_docPassType= htmlspecialchars(strip_tags($_POST["tracking_docPassType"]));
getAllData("tracking_dealing", " tracking_userId = $tracking_userId and tracking_docPassType='$tracking_docPassType' ORDER BY  tracking_date DESC");

 

 

 

 
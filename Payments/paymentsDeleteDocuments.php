<?php
include "../connect.php";

$docs_id = htmlspecialchars(strip_tags($_POST["docs_id"]));
 
deleteData("docs_dealing","docs_id =$docs_id");

 


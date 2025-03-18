<?php
include "../connect.php";

$idUser = htmlspecialchars(strip_tags($_POST["idUser"]));

getAllData("payment_dealingView", "idUser=$idUser");

 







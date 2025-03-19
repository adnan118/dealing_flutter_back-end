<?php
include "../connect.php";

$searchType = htmlspecialchars(strip_tags($_POST["search_Type"]));
getAllData("typeDocsId_dealing", "(typeDocsId_nameAr LIKE '%$searchType%' OR typeDocsId_nameEn LIKE '%$searchType%') AND typeDocsId_active !=0 
");

 


 
<?php  

include "../connect.php";  
$lawyr_typeDealing= htmlspecialchars(strip_tags($_POST["lawyr_typeDealing_PassOrDocsOrBoth"]));  

// for user ui  
// Pass->2, Docs->1, Both->0  
 

$stmt=$con->prepare(
            
    "SELECT DISTINCT * FROM `lawyer_dealing`   WHERE (lawyr_typeDealing_PassOrDocsOrBoth = 0 OR lawyr_typeDealing_PassOrDocsOrBoth = :TYPEe) ORDER BY   lawyr_rate DESC" 


);
      
 $stmt->execute(
     array(
         
         ":TYPEe"  =>$lawyr_typeDealing,
         
         )
 );
     
 $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
 
 $count=$stmt->rowCount();
 
 if($count >0){
      echo json_encode(array("status" => "success", "data" => $data));
 }else{
     echo json_encode(array("status" => "fail"));
 }
?>

 
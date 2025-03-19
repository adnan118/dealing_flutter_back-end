<?php

include "connect.php";


$i="delet";

////////////SELECT

if($i == "select"){
    $stmt=$con->prepare("SELECT * FROM `users`");
$stmt->execute();

//for save data in users var
$users=$stmt->fetchAll(PDO::FETCH_ASSOC);//fetch first row //fetchAll  all users   //fetchColumn() يعطي قيم عمود معين يتم تحديده بعبارة select

$count=$stmt->rowCount();//0 or 1

if($count >0){
    echo json_encode($users);//json
}else{
   echo("NO Data");
}

}

/////////INSERT

if($i == "insert"){

    $stmt=$con->prepare("INSERT INTO `users`(
         `users_name`, `users_email`, `users_phone`, `users_verflyCode`, `users_approve`, `users_createTime`, `users_image`
         )
         VALUES 
         (
            :USER,:EMAIL,:PHONE,:VFC,:APPROVE,:DATE ,:IMG)"
            );
$stmt->execute(
    array(
    ":USER"  =>"alias",
    ":EMAIL" =>"alias@gmail.com",
    ":PHONE"  =>"0987356265",    
    ":VFC"  =>1524,
    ":APPROVE"  =>0,
    ":DATE" =>"2023-09-18 19:21:44",
    ":IMG"  =>"img10",
    )
);

 
$count=$stmt->rowCount();

if($count >0){
    echo("success");
}else{
   echo("failed");
}


}


/////////UPDATE

if($i == "update"){

    $stmt=$con->prepare("UPDATE `users` SET
    `users_approve`=?, `users_image`=?   WHERE `users_id`=3" 
     );
$stmt->execute(array(
   1,"img102"
));

$count=$stmt->rowCount();

if($count >0){
    echo("success");
}else{
   echo("failed");
}


}


/////////DELETE

if($i == "delet"){

    $stmt=$con->prepare("DELETE FROM `users`  WHERE `users_id`=5");
$stmt->execute();


$count=$stmt->rowCount();

if($count >0){
    echo("success");
}else{
   echo("failed");
}


}
<?php

include "connect.php";

sendGCM(
    "Hello",
    "We are happy for you back",
    "users",
    "",
    ""
);
echo "Send";
sentMail("adnanbarakat111@gmail.com","Hello user " ,  "test:   ");
sendGCM("SMC Test","Dear TestTestTest.","users12","none","none");

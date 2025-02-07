<?php
 
require "init.php";
 
$st_name= $_POST["st_name"];
$st_email= $_POST["st_email"]; 
$st_mobileno= $_POST["st_mobileno"];
$st_message= $_POST["st_message"];

$sql_query ="INSERT
INTO
  `contact_us`(
    `st_name`,
    `st_email`,
    `st_mobileno`,
    `st_message`
  )
 
  VALUES(
  '$st_name',
  '$st_email',
  '$st_mobileno',
  '$st_message'
 
);";

if(mysqli_query($con,$sql_query))
 {

echo "Request Sent Successfully";
 }
 else
 {
 echo "Failed... Please Try Again Thankyou!";
 }
 ?>
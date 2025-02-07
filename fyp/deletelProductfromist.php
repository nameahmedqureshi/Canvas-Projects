<?php
if($_SERVER['REQUEST_METHOD']=='POST'){
 $id= $_POST['id'];
//  $l_id= $_POST['l_id'];
//  $p_name= $_POST['p_name'];
 

//  date_default_timezone_set('Asia/Karachi');
//  $date = date('d-M-Y');
 
 require_once('init.php');

 $sql = "DELETE FROM `usersProductsList` WHERE `id`= '$id'";
 
 
 if(mysqli_query($con,$sql)){
 echo 'Deleted';
 }
 else{
 
 echo 'Something went wrong! You can not Delete.';
 }
 
 
 mysqli_close($con);
 

}
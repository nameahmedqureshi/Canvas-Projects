<?php
if($_SERVER['REQUEST_METHOD']=='POST'){
 $u_id= $_POST['u_id'];
 $l_id= $_POST['l_id'];
 $p_name= $_POST['p_name'];
 

//  date_default_timezone_set('Asia/Karachi');
//  $date = date('d-M-Y');
 
 require_once('init.php');

 $sql = "INSERT INTO usersProductsList (u_id,l_id,p_name) VALUES('$u_id','$l_id','$p_name')";
 if(mysqli_query($con,$sql)){
 echo 'Add';
 }
 else{
 
 echo 'Something went wrong! You can not Add.';
 }
 
 
 mysqli_close($con);
 

}
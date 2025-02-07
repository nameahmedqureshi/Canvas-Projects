<?php
if($_SERVER['REQUEST_METHOD']=='POST'){
$l_name= $_POST['l_name'];
  $u_id= $_POST['u_id'];
  
 require_once('init.php');


 $sql = "INSERT INTO buyer_lists (l_name,u_id) VALUES('$l_name','$u_id')";
 
 if(mysqli_query($con,$sql)){
     
 echo 'Successfully Register';
 }
 else{
 
 echo 'Something went wrong! You are not Registered';
 }

 
 mysqli_close($con);
 
}


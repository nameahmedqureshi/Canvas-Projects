<?php 
 if($_SERVER['REQUEST_METHOD']=='POST'){
 //Getting values 
  $user_email= $_POST["user_email"];
 $user_password= $_POST["user_password"];
 
 
  
 require_once('init.php');
  
 
 $sql = "UPDATE
  tta_users
  SET 
  user_password= '$user_password'
  WHERE user_email= '$user_email';";


 //Updating database table 
 if(mysqli_query($con,$sql)){
 
  echo 'Password Reset Successfully';
}
else

{
 echo 'Something Went Wrong! Could Not Reset Password Try Again';
 }
  
 
 //closing connection 
 mysqli_close($con);
 }
 else{

echo 'error';
}
<?php 
 if($_SERVER['REQUEST_METHOD']=='POST'){
 //Getting values 
  $user_email= $_POST["user_email"];
 $user_name= $_POST["user_name"];
 $user_mbl= $_POST["user_mbl"];
 $user_password= $_POST["user_password"];
// $user_image= $_POST["user_image"];
 
 
 //importing database connection script 
 require_once('init.php');
  
//  $path = "profileimages/".$user_id.".png";
 
//  $actualpath = "http://www.thetutor.pk/thetutor/$path";
 
 //Creating sql query 
 $sql = "UPDATE
  tta_users
  SET 
  user_name = '$user_name',
  user_mbl= '$user_mbl',
  user_password= '$user_password'
  
  WHERE user_email= '$user_email';";


 //Updating database table 
 if(mysqli_query($con,$sql)){
//  file_put_contents($path,base64_decode($user_image));
  echo 'User Updated Successfully';
}
else

{
 echo 'Something Went Wrong! Could Not Update User Try Again';
 }
 
 
 //closing connection 
 mysqli_close($con);
 }
 else{

echo 'error';
}
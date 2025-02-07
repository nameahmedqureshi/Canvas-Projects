<?php
if($_SERVER['REQUEST_METHOD']=='POST'){
 $name= $_POST['name'];
 $email= $_POST['email'];
 $ph_no= $_POST['ph_no'];
 $password= $_POST['password'];
 $u_type= $_POST['u_type'];

//  date_default_timezone_set('Asia/Karachi');
//  $date = date('d-M-Y');
 
 require_once('init.php');
 $sql = "SELECT * FROM users WHERE  ph_no ='$ph_no'";

 $check = mysqli_fetch_array(mysqli_query($con,$sql));
 
 if(isset($check)){
 
 echo 'User Mobile Number Already Exist';
 }
 
 else{

 $sql = "INSERT INTO users (name,email,ph_no,password,u_type) VALUES('$name','$email','$ph_no','$password','$u_type')";
 
 if(mysqli_query($con,$sql)){
     
 echo 'Successfully Register';
 }
 else{
 
 echo 'Something went wrong! You are not Registered';
 }
 }
 
 mysqli_close($con);
 
}
else{

echo 'error';
}
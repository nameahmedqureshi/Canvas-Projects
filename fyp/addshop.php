<?php
if($_SERVER['REQUEST_METHOD']=='POST'){
 $shop_name= $_POST['shop_name'];
  $u_id= $_POST['u_id'];
$shop_lat= $_POST['shop_lat'];
 $shop_longt= $_POST['shop_longt'];
 
 require_once('init.php');


 $sql = "INSERT INTO shops (shop_name,u_id,shop_lat,shop_longt) VALUES('$shop_name','$u_id','$shop_lat','$shop_longt')";
 
 if(mysqli_query($con,$sql)){
     
 echo 'Successfully Register';
 }
 else{
 
 echo 'Something went wrong! You are not Registered';
 }

 
 mysqli_close($con);
 
}

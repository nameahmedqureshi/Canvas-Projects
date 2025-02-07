
<?php
if($_SERVER['REQUEST_METHOD']=='POST'){
$s_name= $_POST['supplier_name'];
  $contact= $_POST['contact_name'];
  
 require_once('init.php');


 $sql = "INSERT INTO suppliers (supplier_name,contact_name) VALUES('$s_name','$contact')";
 
 if(mysqli_query($conn,$sql)){
     
 echo 'Successfully Register';
 }
 else{
 
 echo 'Something went wrong! You are not Registered';
 }

 
 mysqli_close($con);
 
}
?>
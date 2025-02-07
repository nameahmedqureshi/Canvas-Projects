<?php

 if($_SERVER['REQUEST_METHOD']=='GET'){

 
$user_email= $_GET['user_email'];

require_once('init.php');
 $sql = "SELECT * FROM tta_users WHERE user_email='$user_email'";

 $r = mysqli_query($con,$sql);

 $res = mysqli_fetch_array($r);

 $result = array();
 array_push($result,array(
  	'user_email'=>$res['user_email'],
       'user_name'=>$res['user_name'],
       'user_mbl'=>$res['user_mbl'],
       'user_password'=>$res['user_password']
        // 'img'=>$res['img']
 )
 );

 echo json_encode(array("result"=>$result));

 mysqli_close($con);

 }
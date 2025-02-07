<?php

 if($_SERVER['REQUEST_METHOD']=='POST'){

 
$u_id= $_POST['u_id'];
$l_id= $_POST['l_id'];


require_once('init.php');
 $sql = "SELECT * FROM usersProductsList WHERE u_id='$u_id'&& l_id='$l_id'";

 $r = mysqli_query($con,$sql);

$result = array();
while($res = mysqli_fetch_array($r)){
    array_push($result,array(
       'id'=>$res['id'],
  	'p_name'=>$res['p_name']
  	));
}
 echo json_encode(array("result"=>$result));

 mysqli_close($con);

 }
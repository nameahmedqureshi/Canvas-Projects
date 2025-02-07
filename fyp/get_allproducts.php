<?php

 if($_SERVER['REQUEST_METHOD']=='GET'){

 
// $u_id= $_POST['u_id'];

require_once('init.php');
 $sql = "SELECT * FROM products";

 $r = mysqli_query($con,$sql);

$result = array();
while($res = mysqli_fetch_array($r)){
    array_push($result,array(
       'id'=>$res['id'],
  	'p_name'=>$res['p_name'],
       'p_price'=>$res['p_price'],
       'p_category'=>$res['p_category']
    ));

}


 echo json_encode(array("result"=>$result));

 mysqli_close($con);

 }
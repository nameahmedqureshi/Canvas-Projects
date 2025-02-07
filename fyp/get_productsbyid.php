<?php

 if($_SERVER['REQUEST_METHOD']=='POST'){

 
$u_id= $_POST['u_id'];

require_once('init.php');
 $sql = "SELECT * FROM products WHERE u_id='$u_id'";

 $r = mysqli_query($con,$sql);

//  $res = mysqli_fetch_array($r);

//  $result = array();
//  array_push($result,array(
//      'id'=>$res['id'],
//   	'p_name'=>$res['p_name'],
//       'p_price'=>$res['p_price'],
//       'p_category'=>$res['p_category']
//     //   'user_password'=>$res['user_password']
//         // 'img'=>$res['img']
//  )
//  );



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
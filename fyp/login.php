
<?php 
require "init.php";

 if($_SERVER['REQUEST_METHOD']=='POST'){
//Getting values
	$ph_no = $_POST['ph_no'];
 	$password = $_POST['password'];

 //Creating sql query
 $sql = "SELECT * FROM users WHERE ph_no='$ph_no' AND password='$password'";
 
 $r = mysqli_query($con,$sql);

 $res = mysqli_fetch_array($r);

 $result = array();
 array_push($result,array(
       	
   'u_id'=>$res['u_id'],
   'name'=>$res['name'],
      'email'=>$res['email'],
      'ph_no'=>$res['ph_no'],
      'u_type'=>$res['u_type']
        // 'img'=>$res['img']
        
        
 )
 );
 
//  echo $res['user_type'];

if($res['u_type']=="buyer")
 {

 echo json_encode(array("result"=>$result));
}

else if($res['u_type']=="seller")
 {

 echo json_encode(array("result"=>$result));
}
else
echo "error";
 mysqli_close($con);

 
 
 }
 
 
 


?>
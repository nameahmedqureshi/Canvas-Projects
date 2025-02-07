<?php

 if($_SERVER['REQUEST_METHOD']=='POST'){
 //Getting values
	$userLat= $_POST['userLat'];
 	$userLong= $_POST['userLong'];


 //Creating sql query
 $sql = "SELECT
    *,
    6371 * 2 * ASIN(
        SQRT(
            POWER(
                SIN(
                    ($userLat - ABS(`shop_lat`)) * PI() / 180 / 2),
                    2
                ) + COS($userLat * PI() / 180) * COS(ABS(`shop_lat`) * PI() / 180) * POWER(
                    SIN(
                        ($userLong-`shop_longt`) * PI() / 180 / 2),
                        2
                    )
                )) AS DISTANCE
            FROM
                shops
            
            ORDER BY
                DISTANCE
            LIMIT 10; ";

 require "init.php";
 //executing query
 $r = mysqli_query($con,$sql);
 $result = array();
while($row = mysqli_fetch_array($r)){
    array_push($result,array(
        'DISTANCE'=>$row['DISTANCE'],
     'shop_name'=>$row['shop_name']
    ));
 
     
     
if($row['DISTANCE']<= 21)
 {
 	$shop_name=$row['shop_name'];
//  	$doc_exp_date=$row['doc_exp_date'];
  $msg="You are Near to $shop_name,Please check your lists may be you selected some produtcs to buy." ;
    
    }
}

// echo json_encode(array('result'=>$result));
echo $msg;

mysqli_close($con);

}

 
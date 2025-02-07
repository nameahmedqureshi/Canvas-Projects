<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #bd9b6e;
            color: #ffffff;
            text-align: center;
            padding: 20px;
        }
        .header h1 {
            margin: 0;
        }
        .content {
            padding: 20px;
            text-align: left;
        }
        .content h2 {
            color: #333333;
        }
        .content p {
            color: #666666;
            line-height: 1.6;
        }
        .button {
            display: block;
            width: 200px;
            margin: 20px auto;
            padding: 10px;
            background-color: #bd9b6e;
            color: #ffffff;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
        }
        .footer {
            background-color: #f4f4f4;
            text-align: center;
            padding: 10px;
            font-size: 12px;
            color: #999999;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h3>Luxury Detailing</h3>
        </div>
        <div class="content">
            <h5>Thank you for ordering</h5>
            <h6>Order Details</h6>
            <p> Service: <?= $type == 'special' ? $titlesString :  get_the_title($_POST['service_id'])  ?> </p>
           
            <p> Vehicle Information: <?= str_replace('_', '', ucwords($_POST['type'], '_'));  ?> </p>
            <p>Garage location: <?= $_POST['garage_location']  ?> </p>
            <p>License Plate: <?= $_POST['vehicle_license_plate']  ?> </p>
            <p>Make: <?= $_POST['make']  ?> </p>
            <p>Model: <?= $_POST['model']  ?> </p>
            <p>Year: <?= $_POST['year']  ?> </p>
            <?php if( !empty($_POST['order_summary']) ) { ?>
            <p>Order Summary: <?=  $_POST['order_summary']  ?> </p>
            <?php } ?>
            <p>Service Date: <?= $_POST['date'] ?> </p>
            <p>Pickup Time: <?= $_POST['pickup_time'] ?> </p>

            <?php if($isAdmin) { ?>
            <h6>User Details</h6>
            <p>Name: <?= $u_name  ?> </p>
            <p>Email: <?= $u_email  ?> </p>
            <p>Phone#: <?= $u_num  ?> </p>
          
            <?php } ?>

        </div>
        <div class="footer">
            <p>&copy; <?= date("Y") ?> Luxury Detailing. All rights reserved.</p>
        </div>
    </div>
</body>
</html>


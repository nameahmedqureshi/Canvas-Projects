
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <title>Account Registration Confirmation</title> -->
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
            <h3>Merv Air</h3>
        </div>
        <div class="content">
            <h4>Order Details</h4>
            <p>Order#: <?= $post_id ?></p>
            <p>Filter Type: <?= $filter_type ?></p>
            <p>No of Filters: <?= $filter_num ?></p>
            <p>Subscription Start Date: <?= date('Y-m-d') ?></p>
            <p>Subscription End Date: <?= date('Y-m-d', strtotime('+1 year', strtotime(date('Y-m-d')))) ?></p>
            <p>Total: $<?= $plan_price ?></p>
            <p>Thank you for ordering our services.</p>
        </div>
        <div class="footer">
            <p>&copy; <?= date("Y") ?> Merv Air. All rights reserved.</p>
        </div>
    </div>
</body>
</html>


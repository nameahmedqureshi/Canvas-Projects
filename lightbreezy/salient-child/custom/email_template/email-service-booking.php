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
            <h3>Light and Breezy Coaching</h3>
        </div>
        <div class="content">

            <h4>Service Booking Order</h4>
            <p>Service: <?= get_the_title($form_data['service'])  ?></p>
            <?= !empty($form_data['client_requests']) ? '<p>Client Requests: ' . esc_html($form_data['client_requests']) . '</p>' : ''; ?>
            <p>Service Type: <?= $meta['servic_type'][0]  ?></p>
            <p>Service Price: $<?= $total_price ?></p>
            <?= !empty($form_data['slots']) ? '<p>Slots: ' . esc_html($form_data['slots']) . '</p>' : ''; ?>
            <?= !empty($form_data['date']) ? '<p>Date: ' . esc_html($form_data['date']) . '</p>' : ''; ?>
        </div>
        <div class="footer">
            <p>&copy; <?= date("Y") ?> Light and Breezy Coaching. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
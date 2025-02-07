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
        .brand-logo {
            max-width: 40px !important;
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
            <img class="brand-logo" alt="Kainamo" src="<?= home_url('/wp-content/uploads/2024/12/M-Logo-003.png') ?>">

        </div>
        <div class="content">
            <h4>Welcome to Our Newsletter!</h4>
            <p>Thank you for subscribing to our newsletter! We are excited to have you on board. Here are some things you can look forward to</p>
            <ul>
                <li>Latest updates and news</li>
                <li>Exclusive offers and promotions</li>
                <li>Insights and tips</li>
            </ul>
            <p>We hope you enjoy our content. If you have any questions, feel free to reply to this email. We are always here to help.</p>
            <p>Best regards,</p>
            <p>The Kainamo Team</p>
        </div>
        <div class="footer">
            <p>&copy; <?= date("Y") ?> Kainamo | ALL RIGHT RESERVED.</p>
        </div>
    </div>
</body>
</html>


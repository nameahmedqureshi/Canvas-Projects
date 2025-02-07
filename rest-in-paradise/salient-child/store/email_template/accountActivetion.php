<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
            max-width: 500px;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin: auto;
        }
        .header {
            font-size: 24px;
            font-weight: bold;
            color: #2c3e50;
        }
        .message {
            font-size: 16px;
            color: #555;
            margin-top: 10px;
        }
        .button {
            display: inline-block;
            padding: 12px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #007bff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        .footer {
            font-size: 14px;
            color: #777;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <p class="header">🎉 Congratulations! Your Account is Activated</p>
        <p class="message">Dear <?= $fullName ?>,</p>
        <p class="message">We are excited to inform you that your account has been successfully activated. You can now log in and start using our services.</p>
        <a href="<?= home_url( 'login' ) ?>" class="button">Login to Your Account</a>
        <p class="footer">If you did not request this account activation, please contact our support team immediately.</p>
    </div>
</body>
</html>

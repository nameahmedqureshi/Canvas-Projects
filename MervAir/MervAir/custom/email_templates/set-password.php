<!DOCTYPE html>
<html>
<head>
	<title>Password Reset</title>
</head>
<body>
<h3>
    <h4>Please Enter Below Code To Reset Your Password</h4>
    <center><?= $code ?></center>
    <a href="<?= home_url('/reset-password/') ?>">Set Password</a>
</h3>
</body>
</html>
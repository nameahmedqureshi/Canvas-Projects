<!DOCTYPE html>
<html>

<head>
    <title>Welcome</title>
</head>

<body>
    <h3>
        <h4>Your account has been created</h4>
        <center>First Name: <?= $_POST['f_name'] ?></center>
        <center>Last Name: <?= $_POST['l_name'] ?></center>
        <center>Email: <?= $_POST['user_email'] ?></center>
        <center>Role: <?= $_POST['user_role'] ?></center>
        <center>Password: <?= $_POST['password'] ?></center>
        <center><a href=" <?= home_url('login') ?>">Login</a></center>
    </h3>
</body>

</html>
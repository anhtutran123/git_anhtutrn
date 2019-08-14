<?php
session_start();
//Check session and cookie
if (isset($_SESSION['mailAddress']) || isset($_COOKIE['status'])) {
    //delete session & coookie
    if (!empty($_POST['btn_submit'])) {
        session_destroy();
        if (isset($_COOKIE['status'])) {
            setcookie('status', '', time() - 3600, '/', '', 0, 0);
        }
        header('Location: LoginPdo.php');
    }
} else {
    header('Location: LoginPdo.php');
}
?>
<html>
<head>
    <title>LogOut Page</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="vendor/twbs/bootstrap/dist/js/bootstrap.js">
    <link rel="stylesheet" href="vendor/twbs/bootstrap/dist/css/bootstrap.css">
</head>
<title>LoginSuccess!</title>
<body>
<div class="container">
    <form method="post" action="LoginSuccessPdo.php">
        <legend>Login Success</legend>
        <div class="col-6">
            <div class="form-group">
                <div class="text-success">
                    <?php
                    echo 'Welcome ';
                    echo $_SESSION['mailAddress'] ?? '';
                    ?>
                </div>
            </div>
            <input type="submit" name="btn_submit" value="Log Out">
        </div>
    </form>
</div>
</body>
</html>

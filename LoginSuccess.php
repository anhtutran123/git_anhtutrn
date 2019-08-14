<?php
session_start();
//Check session and cookie
if (isset($_SESSION['mail_address']) || isset($_COOKIE['status'])) {
    echo 'Đăng nhập thành công!';
    //delete session & coookie
    if (!empty($_POST['btn_submit'])) {
        session_destroy();
        if (isset($_COOKIE['status'])) {
            setcookie('status', '', time() - 3600, '/', '', 0, 0);
        }
        header('Location: Login.php');
    }
} else {
    header('Location: Login.php');
}

?>
<html>
<head>
    <title>LogOut Page</title>
    <meta charset="utf-8">
</head>
<title>LoginSuccess!</title>
<body>
    <form method="post" action="LoginSuccess.php">
        <input type="submit" name="btn_submit" value="Log Out">
    </form>
</body>
</html>

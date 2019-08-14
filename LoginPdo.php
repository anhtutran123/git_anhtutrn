<?php
session_start();
//Check cookie or session
if (isset($_COOKIE['status'])) {
    $_SESSION['mailAddress'] = $_COOKIE['status'];
    header('Location: LoginSuccessPdo.php');
}
if (isset($_SESSION['mailAddress'])) {
    header('Location: LoginSuccessPdo.php');
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Login Page</title>
    <link rel="stylesheet" href="vendor/twbs/bootstrap/dist/js/bootstrap.js">
    <link rel="stylesheet" href="vendor/twbs/bootstrap/dist/css/bootstrap.css">
</head>
<?php
$data = array();
$error = array();
/**
 * Check email
 *
 * @param $email
 * @return bool
 */
function isEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) ? false : true;
}

if (!empty($_POST['loginAction'])) {
    // Get data
    $data['mailAddress'] = $_POST['mailAddress'] ?? '';
    $data['password'] = $_POST['password'] ?? '';

    // Check data
    if (isEmail($data['mailAddress'])) {
        $error['mailAddress'] = 'Email không đúng định dạng';
    }
    if (empty($data['password'])) {
        $error['password'] = 'Bạn chưa nhập mật khẩu';
    }
    if(!$error) {
        try {
            $conn = new PDO(
                'mysql:host=localhost;dbname=anhtutrn;charset=utf8',
                'root',
                ''
            );
            $check = $conn->prepare("SELECT * FROM users WHERE mail_address = :mail_address AND password = :password");
            $check->execute([ ':mail_address' => $data['mailAddress'],':password' => $data['password']]);
            // check email and password are correct
            $result = $check->fetch();
            if ($result) {
                $_SESSION['mailAddress'] = $_POST['mailAddress'];
                //Remember function
                if (!empty($_POST['rememberAction'])) {
                    setcookie('status', 1, time() + 1000, '/', '', 0, 0);
                }
                header('Location: LoginSuccessPdo.php');
            } else {
                $error['fail'] = 'Đăng nhập thất bại';
            }
        } catch (PDOException $ex) {
            echo 'Ket noi that bai';
        }
    }
}
?>
<body>
<div class="container">
    <form method="post" action="LoginPdo.php">
        <legend>Login Form</legend>
        <div class="col-lg-6">
            <div class="form-group">
                <label for="inputEmail1">Email address</label>
                <input type="text" class="form-control" name="mailAddress" id="mail-address" placeholder="Enter email" maxlength="255" value="<?php echo $data['mailAddress'] ?? ''; ?>">
            </div>
            <div class="form-group">
                <label for="inputPassword1">Password</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Password" minlength="6" maxlength="50" value="<?php echo $data['password'] ?? ''; ?>">
            </div>
            <label><input type="checkbox" name="rememberAction" value="remember-action">Remember Me!</label>
            <button type="submit" name="loginAction" value="login">Login</button>
            <div class="text-danger"><?php echo $error['fail'] ?? '';?></div>
        </div>
    </form>
</div>
</body>
</html>

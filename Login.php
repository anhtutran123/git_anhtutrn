<?php
session_start();
//Check cookie or session
if (isset($_COOKIE['status'])) {
    $_SESSION['mail_address'] = $_COOKIE['status'];
    header('Location: LoginSuccess.php');
}

if (isset($_SESSION['mail_address'])) {
    header('Location: LoginSuccess.php');
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login site</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
</head>
<body>
<?php
$error = array();
$data = array();
/**
 * Check email
 *
 * @param $email
 * @return bool
 */
function isEmail($email)
{
    return (filter_var($email, FILTER_VALIDATE_EMAIL) && $email == 'anhtutran@gmail.com' && strlen($email) < 255) ? false : true;
}

/**
 * Check password
 *
 * @param $password
 * @return bool
 */
function isPassword($password)
{
    return ($password == 'anhtutran123' && strlen($password) >= 6 && strlen($password) <= 50) ? false : true;
}

if (!empty($_POST['login_action'])) {
    // Get data
    $data['mail_address'] = isset($_POST['mail_address']) ? $_POST['mail_address'] : '';
    $data['password'] = isset($_POST['password']) ? $_POST['password'] : '';

    // Check data
    if (empty($data['mail_address'])) {
        $error['mail_address'] = 'Bạn chưa nhập email';
    } elseif (isEmail($data['mail_address'])) {
        $error['mail_address'] = 'Email không đúng';
    }

    if (empty($data['password'])) {
        $error['password'] = 'Bạn chưa nhập mật khẩu';
    } elseif (isPassword($data['password'])) {
        $error['password'] = 'Mật khẩu không đúng';
    }

    //Save data if there no errors
    if (!$error) {
        $_SESSION['mail_address'] = $_POST['mail_address'];
        //Remember function
        if (!empty($_POST['remember_action'])) {
            setcookie('status', 1, time() + 1000, '/', '', 0, 0);
        }
        header('Location: LoginSuccess.php');
    }

}
?>

<h1>Sign in</h1>
<form method="post" action="Login.php">
    <table cellspacing="0" cellpadding="5">
        <tr>
            <td>Email của bạn</td>
            <td>
                <div>
                    <input type="input" name="mail_address" id="mail-address" value="<?php echo isset($data['mail_address']) ? $data['mail_address'] : ''; ?>"/>
                    <div style="float: right;color: red;"><?php echo isset($error['mail_address']) ? $error['mail_address'] : ''; ?></div>
                </div>
            </td>
        </tr>
        <tr>
            <td>Mật khẩu</td>
            <td>
                <div>
                    <input type="password" name="password" id="password" value="<?php echo isset($data['password']) ? $data['password'] : ''; ?>"/>
                    <div style="float: right; color: red;"><?php echo isset($error['password']) ? $error['password'] : ''; ?></div>
                </div>
            </td>
        </tr>
        <tr>
            <td><input type="checkbox" name="remember_action" value="remember_action"/>Remember me</td>
            <td><input type="submit" name="login_action" value="Login"/></td>
        </tr>
    </table>
    <p id="text" style="margin-left: 20px;"></p>
</form>
<!--jquery-->
    <script>
        $('#mail-address').on('input', function () {
            var input = $(this);
            if (input.val()) {
                var is_email = "Bạn vừa nhập '" + input.val() + "'";
                $('#text').text(is_email);
            } else {
                var is_email = 'Bạn chưa nhập mail address';
                $('#text').text(is_email);
            }
        });
    </script>
</body>
</html>

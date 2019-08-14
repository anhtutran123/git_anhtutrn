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
    <title>Register Page</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="vendor/twbs/bootstrap/dist/js/bootstrap.js">
    <link rel="stylesheet" href="vendor/twbs/bootstrap/dist/css/bootstrap.css">
</head>
<body>
<?php
/**
 * Check email
 *
 * @param $email
 * @return bool
 */
function isEmail($email)
{
    return (filter_var($email, FILTER_VALIDATE_EMAIL) && strlen($email) < 255) ? false : true;
}
/**
 * Check password
 *
 * @param $password
 * @return bool
 */
function isPassword($password)
{
    return (strlen($password) >= 6 && strlen($password) <= 50) ? false : true;
}
/**
 * Check phone
 *
 * @param $phone
 * @return bool
 */
function isPhone($phone)
{
    return (strlen($phone) >= 10 && strlen($phone) <= 20) ? false : true;
}
$error = array();
$data = array();

if (isset($_POST['registerAction'])) {
    //Get data
    $data['mailAddress'] = $_POST['mailAddress'] ?? '';
    $data['password'] = $_POST['password'] ?? '';
    $data['passwordConfirm'] = $_POST['passwordConfirm'] ?? '';
    $data['phone'] = $_POST['phone'] ?? '';
    $data['address'] = $_POST['address'];

    //Check data
    if (empty($data['mailAddress'])) {
        $error['mailAddress'] = 'Bạn chưa nhập email';
    } elseif (isEmail($data['mailAddress'])) {
        $error['mailAddress'] = 'Email không đúng';
    }
    if (empty($data['password'])) {
        $error['password'] = 'Bạn chưa nhập mật khẩu';
        $error['passwordConfirm'] = 'Bạn chưa nhập mật khẩu';
    } elseif (isPassword($data['password'])) {
        $error['password'] = 'Mật khẩu không hợp lệ';
    }
    //Check password and re-enter password
    if (empty($data['passwordConfirm'])) {
        $error['passwordConfirm'] = 'Bạn chưa nhập lại mật khẩu';
    } elseif ($data['password'] != $data['passwordConfirm']) {
        $error['passwordConfirm'] = 'Mật khẩu bạn vừa nhập không đúng';
    }
    if (!empty($data['phone'] && isPhone($data['phone']))) {
        $error['phone'] = 'Số điện thoại không đúng';
    }

    //Save data in database if there no errors
    if (!$error) {
        try {
            $conn = new PDO(
                'mysql:host=localhost;dbname=anhtutrn;charset=utf8',
                'root',
                ''
            );
            $check = $conn->prepare("SELECT * FROM users WHERE mail_address = :mail_address");
            $check->execute([':mail_address' => $data['mailAddress']]);
            // check email is exists
            if ($check->fetch()) {
                $error['mailAddress'] = 'Email already exists. Please try another email';
            } else {
                //Save data and create date
                $date = date('Y/m/d');
                $stmt = $conn->prepare('INSERT INTO users (mail_address, password, phone, address, created_at, updated_at) VALUES (:mail_address, :password, :phone, :address, :creat, :updated)');
                $stmt->execute(array(
                    ':mail_address' => $data['mailAddress'],
                    ':password' => $data['password'],
                    ':phone' => $data['phone'],
                    ':address' => $data['address'],
                    ':creat' => $date,
                    ':updated' => $date
                ));
            };
            //if there still no error redirect to login site
            if (!$error) {
                header('Location: LoginPdo.php');
            }
        } catch (PDOException $ex) {
            echo 'Ket noi that bai';
        }
    }
}
?>
<div class="container">
    <form method="post" action="RegisterPdo.php">
        <legend>Register Form</legend>
        <div class="col-lg-6">
            <div class="form-group">
                <label for="inputEmail1">Email address</label>
                <input type="text" class="form-control" name="mailAddress" id="mail-address" placeholder="Enter email" required value="<?php echo $data['mailAddress'] ?? ''; ?>">
                <div class="text-danger"><?php echo $error['mailAddress'] ?? '';?></div>
            </div>
            <div class="form-group">
                <label for="inputPassword1">Password</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Password" required value="<?php echo $data['password'] ?? ''; ?>">
                <div class="text-danger" ><?php echo $error['password'] ?? '';?></div>
            </div>
            <div class="form-group">
                <label for="inputPassword1">Password Confirm</label>
                <input type="password" class="form-control" name="passwordConfirm" id="password-confirm" placeholder="Re-enter password" required value="<?php echo $data['passwordConfirm'] ?? ''; ?>">
                <div class="text-danger" ><?php echo $error['passwordConfirm'] ?? ''; ?></div>
            </div>
            <div class="form-group">
                <label for="inputPhone">Phone</label>
                <input type="text" class="form-control" name="phone" id="phone" placeholder="Enter phone" value="<?php echo $data['phone'] ?? ''; ?>">
                <div class="text-danger"><?php echo $error['phone'] ?? ''; ?></div>
            </div>
            <div class="form-group">
                <label for="inputAddress">Address</label>
                <input type="text" class="form-control" name="address" id="address" placeholder="Enter address" required>
            </div>
            <button type="submit" name="registerAction" value="register">Register</button>
        </div>
    </form>
</div>
</body>
</html>

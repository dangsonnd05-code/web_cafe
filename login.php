<?php
session_start();
require_once 'connect_user.php';

if ($_POST) {
    $email = $_POST['email'];
    $pass = md5($_POST['password']);

    $rs = mysqli_query($conn_user, "
        SELECT * FROM users
        WHERE email='$email' AND password='$pass'
    ");

    if ($u = mysqli_fetch_assoc($rs)) {
        $_SESSION['user'] = $u;

        if ($u['role'] == 'admin') {
            header("Location: admin_customers.php");
        } else {
            header("Location: index.php");
        }
        exit;
    } else {
        echo "❌ Sai tài khoản hoặc mật khẩu!";
    }
}
?>

<h2>Đăng nhập</h2>
<form method="post">
    <input name="email" placeholder="Email"><br>
    <input name="password" type="password" placeholder="Mật khẩu"><br>
    <button>Đăng nhập</button>
</form>

<p>Chưa có tài khoản? <a href="register.php">Đăng ký</a></p>

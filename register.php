<?php
require_once 'connect_user.php';

if ($_POST) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $pass = md5($_POST['password']);

    mysqli_query($conn_user, "
        INSERT INTO users(name,email,password)
        VALUES ('$name','$email','$pass')
    ");

    echo "✅ Đăng ký thành công! <a href='login.php'>Đăng nhập</a>";
    exit;
}
?>

<h2>Đăng ký tài khoản</h2>
<form method="post">
    <input name="name" placeholder="Họ tên" required><br>
    <input name="email" placeholder="Email" required><br>
    <input name="password" type="password" placeholder="Mật khẩu" required><br>
    <button>Đăng ký</button>
</form>

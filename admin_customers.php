<?php
session_start();
require_once 'connect_user.php';

if ($_SESSION['user']['role'] != 'admin') {
    die("❌ Không có quyền truy cập");
}

$rs = mysqli_query($conn_user, "
    SELECT id,name,email,created_at 
    FROM users 
    WHERE role='user'
");
?>

<h2>👥 Quản lý khách hàng</h2>

<table border="1" cellpadding="5">
<tr>
    <th>ID</th>
    <th>Tên</th>
    <th>Email</th>
    <th>Ngày tạo</th>
</tr>

<?php while ($u = mysqli_fetch_assoc($rs)): ?>
<tr>
    <td><?= $u['id'] ?></td>
    <td><?= $u['name'] ?></td>
    <td><?= $u['email'] ?></td>
    <td><?= $u['created_at'] ?></td>
</tr>
<?php endwhile; ?>
</table>

<a href="logout.php">🚪 Đăng xuất</a>

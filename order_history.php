<?php
session_start();
require_once 'connect_order.php';

$user_id = $_SESSION['user']['id'];

$rs = mysqli_query($conn_order, "
    SELECT * FROM orders
    WHERE customer_id = $user_id
    ORDER BY id DESC
");
?>

<h2>📜 Lịch sử mua hàng</h2>

<a href="index.php">⬅ Quay lại</a>

<?php while ($o = mysqli_fetch_assoc($rs)): ?>
<p>
    🧾 Đơn #<?= $o['id'] ?> |
    Tổng: <?= number_format($o['total']) ?> VNĐ |
    <?= $o['created_at'] ?>
</p>
<?php endwhile; ?>

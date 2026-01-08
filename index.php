<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
/* =========================
   KẾT NỐI DATABASE
========================= */
require_once __DIR__ . '/connect_user.php';
require_once __DIR__ . '/connect_master.php';
require_once __DIR__ . '/connect_order.php';

/* =========================
   LẤY MENU TỪ DATABASE
========================= */
$products = [];
$rs = mysqli_query($conn_master, "SELECT * FROM products");

while ($row = mysqli_fetch_assoc($rs)) {
    $products[$row['id']] = $row;
}

/* =========================
   GIỎ HÀNG
========================= */
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

/* =========================
   ĐẶT ĐỒ UỐNG
========================= */
if (isset($_GET['buy'])) {
    $id = (int)$_GET['buy'];

    if (isset($products[$id]) && $products[$id]['qty'] > 0) {

        $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + 1;

        // Trừ kho trong cafe_master
        mysqli_query($conn_master, "
            UPDATE products 
            SET qty = qty - 1 
            WHERE id = $id
        ");

        header("Location: index.php");
        exit;
    }
}

/* =========================
   THANH TOÁN
========================= */
if (isset($_POST['checkout'])) {

    $total = 0;
    foreach ($_SESSION['cart'] as $id => $qty) {
        $total += $products[$id]['price'] * $qty;
    }

    // Lưu đơn hàng vào cafe_order
    mysqli_query($conn_order, "
        $user_id = $_SESSION['user']['id'];

mysqli_query($conn_order, "
    INSERT INTO orders(customer_id,total,status) 
    VALUES ($user_id,$total,'Hoàn thành')
");

    ");

    $order_id = mysqli_insert_id($conn_order);

    // Lưu chi tiết đơn
    foreach ($_SESSION['cart'] as $id => $qty) {
        $price = $products[$id]['price'];

        mysqli_query($conn_order, "
            INSERT INTO order_items(order_id,product_id,price,qty)
            VALUES ($order_id,$id,$price,$qty)
        ");
    }

    $_SESSION['cart'] = [];
    echo "<script>alert('Thanh toán thành công! ☕');</script>";
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>QUÁN CAFE</title>

<style>
body {
    margin: 0;
    font-family: Arial, sans-serif;
    background: #f4f6f8;
}
header {
    position: fixed;
    top: 0;
    width: 100%;
    background: #6f4e37;
    color: white;
    padding: 15px;
    text-align: center;
    font-size: 24px;
    z-index: 1000;
}
.container {
    width: 1000px;
    margin: 120px auto 60px;
    background: white;
    padding: 20px;
}
table {
    width: 100%;
    border-collapse: collapse;
}
th, td {
    border: 1px solid #ccc;
    padding: 10px;
    text-align: center;
}
th {
    background: #8b5a2b;
    color: white;
}
.buy {
    background: #28a745;
    color: white;
    padding: 6px 10px;
    text-decoration: none;
    border-radius: 4px;
}
.soldout {
    color: red;
    font-weight: bold;
}
.cart {
    margin-top: 30px;
    background: #f8f9fa;
    padding: 15px;
}
footer {
    background: #6f4e37;
    color: white;
    text-align: center;
    padding: 15px;
    position: fixed;
    bottom: 0;
    width: 100%;
}
</style>
</head>

<body>

<header>
    ☕ KIOH COFFEE – ĐẶT ĐỒ UỐNG TRỰC TUYẾN
   <div style="font-size:14px;margin-top:5px;">
    Xin chào <?= $_SESSION['user']['name'] ?> |
    <a href="order_history.php" style="color:white;">📜 Lịch sử</a> |
    <a href="logout.php" style="color:white;">🚪 Đăng xuất</a>
</div>

</header>

<div class="container">
<h2>🍹 MENU ĐỒ UỐNG</h2>

<table>
<tr>
    <th>Tên đồ uống</th>
    <th>Giá</th>
    <th>Số lượng</th>
    <th>Trạng thái</th>
</tr>

<?php foreach ($products as $id => $p): ?>
<tr>
    <td><?= htmlspecialchars($p['name']) ?></td>
    <td><?= number_format($p['price']) ?> VNĐ</td>
    <td><?= $p['qty'] ?></td>
    <td>
        <?php if ($p['qty'] > 0): ?>
            <a class="buy" href="?buy=<?= $id ?>">☕ Đặt</a>
        <?php else: ?>
            <span class="soldout">HẾT HÀNG</span>
        <?php endif; ?>
    </td>
</tr>
<?php endforeach; ?>
</table>

<div class="cart">
<h3>🛒 Đơn hàng của bạn</h3>

<?php
$total = 0;
foreach ($_SESSION['cart'] as $id => $qty):
    $subtotal = $products[$id]['price'] * $qty;
    $total += $subtotal;
?>
<p><?= $products[$id]['name'] ?> × <?= $qty ?> = <?= number_format($subtotal) ?> VNĐ</p>
<?php endforeach; ?>

<h4>💰 Tổng tiền: <?= number_format($total) ?> VNĐ</h4>

<?php if ($total > 0): ?>
<form method="post">
    <button name="checkout">✅ Thanh toán</button>
</form>
<?php endif; ?>
</div>

</div>

<footer>
    © 2026 – KIOH COFFÊ | Môn Điện Toán Đám Mây
</footer>

</body>
</html>




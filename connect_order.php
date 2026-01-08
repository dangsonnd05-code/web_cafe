<?php
$host = 'gateway01.ap-southeast-1.prod.aws.tidbcloud.com';
$port = 4000;
$username = 'dFsEFy6gSxGqUdk.root';
$password = '37pVnFWdVLkmZh2t';
$dbname = 'cafe_order';

/* Khởi tạo kết nối SSL */
$conn_order = mysqli_init();
mysqli_ssl_set($conn_order, NULL, NULL, NULL, NULL, NULL);

/* Kết nối */
if (!mysqli_real_connect(
    $conn_order,
    $host,
    $username,
    $password,
    $dbname,
    $port,
    NULL,
    MYSQLI_CLIENT_SSL
)) {
    die("❌ Lỗi kết nối cafe_order: " . mysqli_connect_error());
}

/* Charset UTF8 */
$conn_order->set_charset("utf8mb4");

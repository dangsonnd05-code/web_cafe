<?php
$host = 'gateway01.ap-southeast-1.prod.aws.tidbcloud.com';
$port = 4000;
$username = 'dFsEFy6gSxGqUdk.root';
$password = '37pVnFWdVLkmZh2t';
$dbname = 'cafe_master';

/* Khởi tạo kết nối SSL */
$conn_master = mysqli_init();
mysqli_ssl_set($conn_master, NULL, NULL, NULL, NULL, NULL);

/* Kết nối */
if (!mysqli_real_connect(
    $conn_master,
    $host,
    $username,
    $password,
    $dbname,
    $port,
    NULL,
    MYSQLI_CLIENT_SSL
)) {
    die("❌ Lỗi kết nối cafe_master: " . mysqli_connect_error());
}

/* Charset UTF8 */
$conn_master->set_charset("utf8mb4");

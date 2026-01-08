<?php
// Thông tin kết nối TiDB Cloud (Đã điền sẵn)
$host = 'gateway01.ap-southeast-1.prod.aws.tidbcloud.com';
$port = 4000;
$username = 'dFsEFy6gSxGqUdk.root';
$password = '37pVnFWdVLkmZh2t';
$dbname = 'quan_cafe';

// Khởi tạo kết nối SSL (Bắt buộc với TiDB)
$conn = mysqli_init();
mysqli_ssl_set($conn, NULL, NULL, NULL, NULL, NULL);

// Thực hiện kết nối
if (!mysqli_real_connect($conn, $host, $username, $password, $dbname, $port, NULL, MYSQLI_CLIENT_SSL)) {
    die("Lỗi kết nối Database: " . mysqli_connect_error());
}

// Thiết lập font chữ tiếng Việt cho chuẩn
$conn->set_charset("utf8");

?>

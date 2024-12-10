<?php
$host = 'localhost'; // Thay bằng host của bạn
$db = 'quiz'; // Tên cơ sở dữ liệu
$username = 'root'; // Tên người dùng MySQL
$password = ''; // Mật khẩu MySQL

// Tạo kết nối
$conn = new mysqli($host, $username, $password, $db);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
?>

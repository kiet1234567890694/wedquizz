<?php
session_start();

// Hủy tất cả các session
session_unset();

// Hủy session hiện tại
session_destroy();

// Chuyển hướng về trang đăng nhập hoặc trang chủ
header("Location: login.php");
exit();
?>

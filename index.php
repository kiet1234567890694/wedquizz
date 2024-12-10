<?php
session_start();
require './db.php'; // Kết nối database

// Kiểm tra đăng nhập
$isLoggedIn = isset($_SESSION['user_id']);
$username = '';

if ($isLoggedIn) {
    $userId = $_SESSION['user_id'];
    $sql = "SELECT full_name FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $username = $user['full_name'] ?? 'Người dùng';
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduQuiz</title>
    <link rel="stylesheet" href="./css/styles.css"> <!-- Đường dẫn tới file CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet" />
    <style>
        /* Dán CSS ở đây */
    </style>
</head>

<body>
    <!-- Thanh header -->
    <header class="header">
        <img src="../images/LOGO1.fc4be851.png" alt="EduQuiz Logo" height="40">
        <input id="search-input" type="text" placeholder="Tìm kiếm môn học...">
        <?php if ($isLoggedIn): ?>
            <span>Xin chào, <?php echo htmlspecialchars($username, ENT_QUOTES); ?>!</span>
            <a href="./user/logout.php" class="login-btn">Đăng Xuất</a>
        <?php else: ?>
            <a href="./user/login.php" class="login-btn">Đăng Nhập</a>
        <?php endif; ?>
    </header>
    <!-- Bố cục chính -->
    <div class="content" style="display: flex;">
        <!-- Sidebar -->
        <div class="sidebar">
            <ul>
                <li><a href="/index.php"><i class="fas fa-home"></i> Trang chủ</a></li>
                <li><a href="/tailieu.php"><i class="fas fa-book"></i> Tài liệu học tập</a></li>
                <li><a href="/tintuc.php"><i class="fas fa-newspaper"></i> Tin tức</a></li>
                <li><a href="/gioithieu.php"><i class="fas fa-tags"></i> Giới thiệu</a></li>
                <li><a href="../user/profile.php"><i class="fas fa-user"></i> Nâng cấp tài khoản</a></li>
                <li><a href="/lienhe.php"><i class="fas fa-user"></i> Liên hệ</a></li>
            </ul>
        </div>

        <!-- Nội dung chính -->
        <div class="main-content">
            <div class="banner">
                <img src="" alt="Banner Image" >
            </div>
            <div class="text">
                    <h2>QUIZ</h2>
            </div>
            <!-- Thêm danh sách môn học -->
            <div id="subjects-list">
               
            </div>
        </div>
    </div>

    <script src="app.js"></script> <!-- Kết nối JavaScript -->
</body>

</html>

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
    <title>Tài Liệu Học Tập</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        /* Đặt kiểu cho body */
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f3f3f7;
            color: #333;
        }

        /* Thanh header */
        .header {
            background-color: #6212ea;
            color: white;
            text-align: center;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .header h1 {
            margin: 0;
            font-weight: 600;
        }

        /* Bố cục chính */
        .content {
            display: flex;
            padding: 20px;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding-top: 20px;
            margin-right: 20px;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar ul li a {
            display: block;
            padding: 15px;
            color: #333;
            text-decoration: none;
            border-bottom: 1px solid #ddd;
            font-weight: 500;
            transition: background-color 0.3s, color 0.3s;
        }

        .sidebar ul li a:hover {
            background-color: #6212ea;
            color: white;
        }

        /* Nội dung chính */
        .main-content {
            flex: 1;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .main-content h2 {
            font-weight: 600;
            color: #6212ea;
        }

        /* Thư mục tài liệu */
        .folder-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .folder {
            width: 30%;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .folder:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        .folder i {
            font-size: 40px;
            color: #6212ea;
        }

        .folder h3 {
            font-size: 18px;
            margin: 10px 0;
            color: #333;
        }

        .file-list {
            list-style: none;
            padding: 0;
        }

        .file-list li {
            margin-bottom: 10px;
        }

        .file-list a {
            text-decoration: none;
            color: #333;
            font-size: 16px;
            transition: color 0.3s ease;
        }

        .file-list a:hover {
            color: #6212ea;
        }

        /* Mobile responsiveness */
        @media (max-width: 768px) {
            .folder-container {
                flex-direction: column;
            }

            .folder {
                width: 100%;
            }
        }
        .login-btn {
            background-color: #007bff;
            color: #fff;
            /* Màu chữ trắng */
            padding: 5px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            background: linear-gradient(to right, #8c01c3, #4e09cf);
            font-weight: bold;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .login-btn:hover {
            background: #5e11db;
            transform: scale(1.05);
        }

        .login-btn:active {
            background: #5e11db;
        }

        .login-btn {
            color: #fff !important;
            /* Thêm !important để đảm bảo màu chữ trắng */
        }
    </style>
</head>

<body>
    <header class="header">
        <img src="logo.png" alt="EduQuiz Logo" height="40">
        <h1>Tài Liệu Học Tập</h1>
        <?php if ($isLoggedIn): ?>
                <span>Xin chào, <?php echo htmlspecialchars($username, ENT_QUOTES); ?>!</span>
                <a href="./user/logout.php" class="login-btn">Đăng Xuất</a>
            <?php else: ?>
                <a href="./user/login.php" class="login-btn">Đăng Nhập</a>
            <?php endif; ?>
    </header>

    <!-- Bố cục chính -->
    <div class="content">
        <div class="sidebar">
            <ul>
            <li><a href="index.php">Trang chủ</a></li>
            <li><a href="tailieu.php">Tài liệu</a></li>
            <li><a href="tintuc.php">Tin tức</a></li>
            <li><a href="gioithieu.php">Giới thiệu</a></li>
            <li><a href="lienhe.php">Liên hệ</a></li>
            </ul>
        </div>

        <div class="main-content">
            <h2>Thư Mục Tài Liệu</h2>
            <div class="folder-container">
                <div class="folder">
                    <i class="fas fa-folder"></i>
                    <h3>Lập trình Android</h3>
                    <ul class="file-list">
                        <li><a href="#">Tài liệu 1.pdf</a></li>
                        <li><a href="#">Tài liệu 2.pdf</a></li>
                        <li><a href="#">Tài liệu 3.pdf</a></li>
                    </ul>
                </div>
                <div class="folder">
                    <i class="fas fa-folder"></i>
                    <h3>Lập trình Java</h3>
                    <ul class="file-list">
                        <li><a href="#">Tài liệu 1.pdf</a></li>
                        <li><a href="#">Tài liệu 2.pdf</a></li>
                    </ul>
                </div>
                <div class="folder">
                    <i class="fas fa-folder"></i>
                    <h3>Web Development</h3>
                    <ul class="file-list">
                        <li><a href="#">Tài liệu 1.pdf</a></li>
                        <li><a href="#">Tài liệu 2.pdf</a></li>
                        <li><a href="#">Tài liệu 3.pdf</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>

</html>

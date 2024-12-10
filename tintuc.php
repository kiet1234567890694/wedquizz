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
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>
        EduQuiz
    </title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&amp;display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7fa;
            /* Slightly lighter background */
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 30px;
            /* Increased padding for a more spacious look */
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            /* Added shadow for depth */
        }

        .navbar .logo {
            display: flex;
            align-items: center;
        }

        .navbar .logo img {
            height: 60px;
            /* Slightly larger logo */
            margin-right: 10px;
            width: 145px;
        }

        .navbar .nav-links {
            display: flex;
            align-items: center;
        }

        .navbar .nav-links a {
            margin: 0 15px;
            /* Increased margin for better spacing */
            text-decoration: none;
            color: #343a40;
            /* Darker text color */
            font-weight: 500;
            transition: color 0.3s;
            /* Smooth transition for hover effect */
        }

        .navbar .nav-links a:hover {
            color: #6f42c1;
            /* Change color on hover */
        }

        .navbar .login-btn {
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

        .navbar .login-btn:hover {
            background: #5e11db;
            transform: scale(1.05);
        }

        .navbar .login-btn:active {
            background: #5e11db;
        }

        .navbar .login-btn {
            color: #fff !important;
            /* Thêm !important để đảm bảo màu chữ trắng */
        }



        .content {
            padding: 30px;
            /* Increased padding for content area */
        }

        .breadcrumb {
            font-size: 14px;
            color: #6c757d;
            margin-bottom: 20px;
        }

        .breadcrumb a {
            text-decoration: none;
            color: #6c757d;
        }

        .breadcrumb a:hover {
            text-decoration: underline;
        }

        .articles {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .article {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            /* Deeper shadow for articles */
            overflow: hidden;
            transition: transform 0.3s;
            /* Smooth transition for hover effect */
        }

        .article:hover {
            transform: translateY(-5px);
            /* Lift effect on hover */
        }

        .article img {
            width: 100%;
            height: 180px;
            /* Increased height for images */
            object-fit: cover;
        }

        .article .content {
            padding: 20px;
            /* Increased padding for article content */
        }

        .article .tag {
            display: inline-block;
            background-color: #e9ecef;
            /* Light background for tags */
            color: #6f42c1;
            padding: 5px 15px;
            /* Increased padding for tags */
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            margin-bottom: 10px;
        }

        .article .title {
            font-size: 18px;
            /* Increased font size for titles */
            font-weight: 700;
            margin-bottom: 10px;
            color: #000;
        }

        .article .description {
            font-size: 14px;
            color: #6c757d;
        }

        .login-btn {
            background-color: #6f42c1;
            /* Button color */
            color: #fff;
            /* Text color */
            padding: 10px 20px;
            /* Padding for button */
            border-radius: 20px;
            /* Rounded corners */
            text-decoration: none;
            /* No underline */
            transition: background-color 0.3s;
            /* Smooth transition */
        }

        .login-btn:hover {
            background-color: #5a3791;
            /* Darker shade on hover */
        }
    </style>
</head>

<body>
    <div class="navbar">
        <div class="logo">
            <img alt="EduQuiz Logo" height="40"
                src="../images/LOGO1.fc4be851.png"
                width="40" />
          
        </div>
        <div class="nav-links">
            <a href="index.php">Trang chủ</a>
            <a href="tailieu.php">Tài liệu</a>
            <a href="tintuc.php">Tin tức</a>
            <a href="gioithieu.php">Giới thiệu</a>
            <a href="lienhe.php">Liên hệ</a>
            <?php if ($isLoggedIn): ?>
                <span>Xin chào, <?php echo htmlspecialchars($username, ENT_QUOTES); ?>!</span>
                <a href="./user/logout.php" class="login-btn">Đăng Xuất</a>
            <?php else: ?>
                <a href="./user/login.php" class="login-btn">Đăng Nhập</a>
            <?php endif; ?>
        </div>
    </div>
    <div class="content">
        <div class="breadcrumb">
            <a href="#">
                Trang chủ
            </a>
            /
            <span>
                Bài viết
            </span>
        </div>
        <div class="articles">
            <div class="article">
                <img alt="AI in Healthcare" height="150"
                    src="https://storage.googleapis.com/a1aa/image/ryXIeuK3r7RgLqPKsfsepXEZMMi450tDzi5xNZa1EE7r6pxnA.jpg"
                    width="300" />
                <div class="content">
                    <div class="tag">
                        13 ỨNG DỤNG
                    </div>
                    <div class="title">
                        TRÍ TUỆ NHÂN TẠO AI TRONG Y TẾ
                    </div>
                    <div class="description">
                        Tìm hiểu về 13 ứng dụng trí tuệ nhân tạo AI trong y tế đã mang lại nhiều đột phá và cải tiến
                        quan trọng trong [...]
                    </div>
                </div>
            </div>
            <div class="article">
                <img alt="Robots in Education" height="150"
                    src="https://storage.googleapis.com/a1aa/image/mCOpCMBt3s5PARM1NJKK5w36mofpRnj4gnj6qHQXZu1le04TA.jpg"
                    width="300" />
                <div class="content">
                    <div class="tag">
                        TÌM HIỂU
                    </div>
                    <div class="title">
                        ROBOT TRONG GIÁO DỤC LÀ GÌ?
                    </div>
                    <div class="description">
                        Robot trong giáo dục là gì? Tại sao việc sử dụng robot trong giáo dục lại quan trọng? [...]
                    </div>
                </div>
            </div>
            <div class="article">
                <img alt="Importance of Education" height="150"
                    src="https://storage.googleapis.com/a1aa/image/ZaEfCrqf2znf4IuZjQzJwDZNibQOhoUE30JOm8DcydvS6pxnA.jpg"
                    width="300" />
                <div class="content">
                    <div class="tag">
                        TÌM HIỂU
                    </div>
                    <div class="title">
                        TẠI SAO GIÁO DỤC LẠI QUAN TRỌNG
                    </div>
                    <div class="description">
                        Tại sao giáo dục lại quan trọng? Vai trò của giáo dục trong phát triển cá nhân và xã hội [...]
                    </div>
                </div>
            </div>
            <div class="article">
                <img alt="Modern Education Methods" height="150"
                    src="https://storage.googleapis.com/a1aa/image/yC1ugsLYDAo6DRmizNYZOrOteaOihNLrzepKvCvGd6AX904TA.jpg"
                    width="300" />
                <div class="content">
                    <div class="tag">
                        TÌM HIỂU
                    </div>
                    <div class="title">
                        8 PHƯƠNG PHÁP GIÁO DỤC HIỆN ĐẠI
                    </div>
                    <div class="description">
                        8 phương pháp giáo dục hiện đại dành cho giáo viên, phụ huynh và học sinh [...]
                    </div>
                </div>
            </div>
            <div class="article">
                <img alt="IT Exams" height="150"
                    src="https://storage.googleapis.com/a1aa/image/E7ESjQIyZsaxClBozQf01eTkh53bMPze4je5dx1CQ1q80TjPB.jpg"
                    width="300" />
                <div class="content">
                    <div class="tag">
                        100+ ĐỀ THI
                    </div>
                    <div class="title">
                        TRẮC NGHIỆM TIN 4 HUBT
                    </div>
                    <div class="description">
                        Trọn bộ 100+ đề trắc nghiệm Tin 4 HUBT có đáp án mới nhất trên EduQuiz [...]
                    </div>
                </div>
            </div>
            <div class="article">
                <img alt="Strategic Management Exams" height="150"
                    src="https://storage.googleapis.com/a1aa/image/0HyK52pFQ0YiHRGjqmaNw68GfS6kElMBVmXITIzr4zjoe04TA.jpg"
                    width="300" />
                <div class="content">
                    <div class="tag">
                        100+ ĐỀ THI
                    </div>
                    <div class="title">
                        TRẮC NGHIỆM QUẢN TRỊ CHIẾN LƯỢC
                    </div>
                    <div class="description">
                        100+ đề trắc nghiệm Quản trị chiến lược có đáp án mới nhất trên EduQuiz [...]
                    </div>
                </div>
            </div>
            <div class="article">
                <img alt="WTO Exams" height="150"
                    src="https://storage.googleapis.com/a1aa/image/moijZpniRK7dOpO5HTE6khLkACxWYxH4x2OPIwqZZgqTPNeJA.jpg"
                    width="300" />
                <div class="content">
                    <div class="tag">
                        100+ ĐỀ THI
                    </div>
                    <div class="title">
                        TRẮC NGHIỆM VỀ WTO CÓ ĐÁP ÁN
                    </div>
                    <div class="description">
                        100+ đề trắc nghiệm về WTO có đáp án mới nhất trên EduQuiz [...]
                    </div>
                </div>
            </div>
            <div class="article">
                <img alt="Computer Network Exams" height="150"
                    src="https://storage.googleapis.com/a1aa/image/nQ7BUg13uFbeDyegGLNf14671Esig0tseoKUbr2i9jNO1TjPB.jpg"
                    width="300" />
                <div class="content">
                    <div class="tag">
                        TRỌN BỘ 100+
                    </div>
                    <div class="title">
                        ĐỀ THI TRẮC NGHIỆM MẠNG MÁY TÍNH
                    </div>
                    <div class="description">
                        Trọn bộ đề trắc nghiệm Mạng máy tính có đáp án mới nhất trên EduQuiz [...]
                    </div>
                </div>
            </div>
            <div class="article">
                <img alt="Parasitology Exams" height="150"
                    src="https://storage.googleapis.com/a1aa/image/6jemxRSSaFwlWqvxGqB0tTFrKy5NRLchf5I1IruqDFrN904TA.jpg"
                    width="300" />
                <div class="content">
                    <div class="tag">
                        100+ ĐỀ THI
                    </div>
                    <div class="title">
                        TRẮC NGHIỆM KÝ SINH TRÙNG
                    </div>
                    <div class="description">
                        Trọn bộ 100+ đề trắc nghiệm Ký sinh trùng có đáp án mới nhất trên EduQuiz [...]
                    </div>
                </div>
            </div>
            <div class="article">
                <img alt="Medical Psychology Exams" height="150"
                    src="https://storage.googleapis.com/a1aa/image/dyuKpDcyr0biJVVdvaXnxQfMY59RvGivFVBSDsnp6FTle04TA.jpg"
                    width="300" />
                <div class="content">
                    <div class="tag">
                        100+ ĐỀ THI
                    </div>
                    <div class="title">
                        TRẮC NGHIỆM TÂM LÝ Y ĐỨC
                    </div>
                    <div class="description">
                        Trọn bộ 100+ đề trắc nghiệm Tâm lý y đức có đáp án mới nhất trên EduQuiz [...]
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
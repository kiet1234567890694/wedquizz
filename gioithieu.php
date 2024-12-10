<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giới Thiệu</title>
    <style>
        /* Đặt kiểu cho body */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5; /* Màu nền sáng */
            color: #333;
        }

        /* Thanh header */
        .header {
            background-color: white; /* Màu xanh đậm EduQuiz */
            color: black;
            text-align: center;
            padding: 15px;
        }

        .header h1 {
            margin: 0;
        }

        /* Bố cục chính */
        .content {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background-color: white; /* Màu xám đen */
            color: black;
            padding-top: 20px;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li a {
            display: block;
            padding: 15px;
            color: black;
            text-decoration: none;
            border-bottom: 1px solid #444;
        }

        .sidebar ul li a:hover {
            background-color: #00B34D; /* Màu xanh đậm EduQuiz khi hover */
        }

        /* Nội dung chính */
        .main-content {
            flex: 1;
            padding: 30px;
            background-color: #ffffff; /* Màu nền chính */
            color: #333;
        }

        .main-content h2 {
            font-size: 28px;
            color: #00B34D; /* Màu xanh EduQuiz */
            margin-bottom: 10px;
        }

        .main-content h3 {
            font-size: 24px;
            color: #333;
            margin-top: 20px;
        }

        .main-content p {
            font-size: 16px;
            line-height: 1.6;
            color: #666;
        }

        /* Thêm hiệu ứng cho liên kết trong sidebar */
        .sidebar ul li a:hover {
            background-color: #00B34D;
        }

        /* Thêm hiệu ứng cho các đoạn văn bản */
        .main-content p {
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            /* Khi màn hình nhỏ, thay đổi bố cục */
            .content {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                margin-bottom: 20px;
            }

            .main-content {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <header class="header">
        <img src="./images/LOGO1.fc4be851.png" alt="EduQuiz Logo" height="40">
        <h1>Giới Thiệu</h1>
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
            <h2>Chúng tôi là ai?</h2>
            <p>Chào mừng bạn đến với trang web của chúng tôi. Chúng tôi cung cấp các khóa học trực tuyến, tài liệu học tập, và những bài viết tin tức mới nhất trong lĩnh vực giáo dục.</p>

            <h3>Sứ mệnh của chúng tôi</h3>
            <p>Chúng tôi cam kết mang đến cho bạn những khóa học chất lượng và cập nhật tin tức, tài liệu học tập đầy đủ để bạn có thể phát triển bản thân trong quá trình học tập.</p>

            <h3>Đội ngũ của chúng tôi</h3>
            <p>Chúng tôi là một nhóm các giảng viên và chuyên gia trong các lĩnh vực giáo dục, luôn nỗ lực cải thiện chất lượng học tập và cung cấp những tài liệu hữu ích cho cộng đồng học viên.</p>

            <h3>Liên hệ với chúng tôi</h3>
            <p>Để biết thêm thông tin, vui lòng liên hệ với chúng tôi qua trang Liên hệ hoặc gửi email cho chúng tôi tại support@eduquiz.vn.</p>
        </div>
    </div>

    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>

</html>

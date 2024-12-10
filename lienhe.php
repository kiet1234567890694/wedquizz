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
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title>
   EduQuiz Contact Page
  </title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&amp;display=swap" rel="stylesheet"/>
  <style>
   body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 0;
        }
        .header img {
            width: 150px;
            height: 60px;
        }
        .header nav a {
            margin: 0 10px;
            text-decoration: none;
            color: #000;
            font-weight: 500;
        }
        .header nav a:last-child {
            background-color: #6a1b9a;
            color: #fff;
            padding: 10px 20px;
            border-radius: 20px;
        }
        .main-content {
            text-align: center;
            margin: 40px 0;
        }
        .main-content h1 {
            font-size: 2.5em;
            color: #6a1b9a;
        }
        .main-content p {
            font-size: 1.2em;
            color: #333;
        }
        .contact-section {
            display: flex;
            justify-content: space-between;
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .contact-info {
            width: 45%;
        }
        .contact-info p {
            margin: 10px 0;
            color: #333;
        }
        .contact-info a {
            color: #6a1b9a;
            text-decoration: none;
        }
        .contact-info .social-icons a {
            margin: 0 10px;
            color: #333;
            font-size: 1.5em;
        }
        .contact-form {
            width: 45%;
        }
        .contact-form input, .contact-form textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .contact-form button {
            background-color: #6a1b9a;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .contact-form button:hover {
            background-color: #5e35b1;
        }
        .contact-image {
            text-align: center;
            margin-top: 20px;
        }
        .contact-image img {
            max-width: 100%;
            border-radius: 10px;
        }
        @media (max-width: 768px) {
            .contact-section {
                flex-direction: column;
                align-items: center;
            }
            .contact-info, .contact-form {
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
  <div class="container">
   <header class="header">
    <img alt="EduQuiz Logo" height="40" src="./images/LOGO1.fc4be851.png" width="100"/>
    <nav>
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
    </nav>
   </header>
   <div class="main-content">
    <h1>
     Liên hệ với chúng tôi
    </h1>
    <p>
     Việc liên lạc với EduQuiz chưa bao giờ dễ dàng hơn thế.
    </p>
   </div>
   <div class="contact-section">
    <div class="contact-info">
     <p>
      Chúng tôi đang giúp cho 100000+ khách hàng và đối tác tổ chức các kỳ thi đánh giá năng lực, nâng cao chất lượng đào tạo nhân sự và học viên.
     </p>
     <a href="#">
      Hãy để chúng tôi tư vấn giải pháp cho bạn
     </a>
     <p>
      <strong>
       Số điện thoại
      </strong>
      0969682900
     </p>
     <p>
      <strong>
       Email
      </strong>
      contact@eduquiz.vn
     </p>
     <p>
      <strong>
       Văn phòng
      </strong>
      Tầng 5, số 33 , phố Trung Kính - P. Trung Hòa - Q. Cầu Giấy - TP. Hà Nội
     </p>
     <p>
      <strong>
       Nghe cộng đồng nói về chúng tôi
      </strong>
     </p>
     <div class="social-icons">
      <a href="#">
       <i class="fab fa-facebook">
       </i>
      </a>
      <a href="#">
       <i class="fab fa-tiktok">
       </i>
      </a>
      <a href="#">
       <i class="fab fa-youtube">
       </i>
      </a>
     </div>
    </div>
    <div class="contact-form">
     <input placeholder="Họ và tên" type="text"/>
     <input placeholder="Email" type="email"/>
     <input placeholder="Số điện thoại" type="text"/>
     <textarea placeholder="Nhập mong muốn cần tư vấn"></textarea>
     <button>
      Gửi liên hệ
     </button>
    </div>
   </div>
  </div>
 </body>
</html>

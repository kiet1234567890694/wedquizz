<?php
// Kết nối với cơ sở dữ liệu
include '../db.php';
session_start();

// Kiểm tra nếu form đã được gửi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Truy vấn cơ sở dữ liệu để lấy thông tin người dùng
    $sql = "SELECT id, password FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $hashed_password);

    // Kiểm tra mật khẩu và lưu thông tin người dùng vào session nếu thành công
    if ($stmt->fetch() && password_verify($password, $hashed_password)) {
        // Lưu ID người dùng vào session
        $_SESSION['user_id'] = $id;
        // Chuyển hướng đến trang chính sau khi đăng nhập
        header("Location: ../index.php");
        exit();
    } else {
        // Thông báo lỗi nếu tên đăng nhập hoặc mật khẩu không đúng
        $error_message = "Tên đăng nhập hoặc mật khẩu không chính xác!";
    }

    // Đóng kết nối
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <style>
        /* Reset một số thuộc tính mặc định */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Cài đặt font chữ cho toàn bộ trang */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
        }

        /* Tạo phần container cho form */
        .container {
            background-color: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 420px;
            text-align: center;
            animation: fadeIn 0.5s ease-out;
        }

        /* Tiêu đề của form */
        h2 {
            font-size: 28px;
            color: #333;
            margin-bottom: 20px;
            font-weight: 600;
        }

        /* Các trường input */
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 15px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            outline: none;
            transition: all 0.3s ease-in-out;
        }

        /* Hiệu ứng focus cho các trường input */
        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #4CAF50;
            box-shadow: 0 0 5px rgba(76, 175, 80, 0.5);
        }

        /* Nút đăng nhập */
        button {
            width: 100%;
            padding: 15px;
            background-color: #4CAF50;
            color: white;
            font-size: 18px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        /* Hiệu ứng hover cho nút đăng nhập */
        button:hover {
            background-color: #45a049;
        }

        /* Thông báo lỗi */
        p {
            color: red;
            font-size: 14px;
            margin-top: 10px;
        }

        /* Liên kết đăng ký */
        a {
            color: #4CAF50;
            font-weight: bold;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        a:hover {
            color: #45a049;
            text-decoration: underline;
        }

        /* Animation cho container */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Đăng nhập vào hệ thống</h2>

        <!-- Hiển thị thông báo lỗi nếu có -->
        <?php if (isset($error_message)): ?>
            <p><?php echo $error_message; ?></p>
        <?php endif; ?>

        <!-- Form đăng nhập -->
        <form method="POST" action="login.php">
            <input type="text" name="username" placeholder="Tên đăng nhập" required>
            <input type="password" name="password" placeholder="Mật khẩu" required>
            <button type="submit">Đăng nhập</button>
        </form>

        <p>Bạn chưa có tài khoản? <a href="register.php">Đăng ký ngay</a></p>
    </div>

</body>
</html>

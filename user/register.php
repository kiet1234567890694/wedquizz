<?php
// Kết nối với cơ sở dữ liệu
include '../db.php';

// Kiểm tra nếu form đã được gửi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Kiểm tra nếu người dùng đã tồn tại
    $sql_check = "SELECT id FROM users WHERE username = ? OR email = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("ss", $username, $email);
    $stmt_check->execute();
    $stmt_check->store_result();

    // Nếu đã có người dùng với tên đăng nhập hoặc email đó, thông báo lỗi
    if ($stmt_check->num_rows > 0) {
        $error_message = "Tên đăng nhập hoặc email đã tồn tại!";
    } else {
        // Mã hóa mật khẩu
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Chèn người dùng vào cơ sở dữ liệu
        $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $username, $email, $hashed_password);

        if ($stmt->execute()) {
            // Đăng ký thành công
            $success_message = "Đăng ký thành công!";
        } else {
            $error_message = "Có lỗi xảy ra: " . $stmt->error;
        }
    }

    // Đóng kết nối
    $stmt_check->close();
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
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
        input[type="email"],
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
        input[type="email"]:focus,
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
        <h2>Đăng ký tài khoản</h2>

        <!-- Hiển thị thông báo lỗi nếu có -->
        <?php if (isset($error_message)): ?>
            <p style="color: red;"><?php echo $error_message; ?></p>
        <?php endif; ?>

        <!-- Hiển thị thông báo thành công nếu có -->
        <?php if (isset($success_message)): ?>
            <p style="color: green;"><?php echo $success_message; ?></p>
        <?php endif; ?>

        <!-- Form đăng ký -->
        <form method="POST" action="register.php">
            <input type="text" name="username" placeholder="Tên đăng nhập" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Mật khẩu" required>
            <button type="submit">Đăng ký</button>
        </form>

        <p>Bạn đã có tài khoản? <a href="login.php">Đăng nhập ngay</a></p>
    </div>

</body>
</html>

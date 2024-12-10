<?php
session_start();
require '../db.php'; // Kết nối database

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối cơ sở dữ liệu không thành công: " . $conn->connect_error);
}

// Kiểm tra đăng nhập
$isLoggedIn = isset($_SESSION['user_id']);
$username = '';

if ($isLoggedIn) {
    $userId = $_SESSION['user_id'];
    $sql = "SELECT full_name FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        die('Lỗi khi chuẩn bị câu lệnh SQL: ' . $conn->error);
    }
    
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $username = $user['full_name'] ?? 'Người dùng';
}

// Lấy thông tin người dùng
$userId = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die('Lỗi khi chuẩn bị câu lệnh SQL: ' . $conn->error);
}

$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = $_POST['full_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $address = $_POST['address'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $dob = $_POST['dob'] ?? '';

    // Cập nhật thông tin vào cơ sở dữ liệu
    $updateSql = "UPDATE users SET full_name = ?, email = ?, phone = ?, address = ?, gender = ?, dob = ? WHERE id = ?";
    $stmt = $conn->prepare($updateSql);

    if ($stmt === false) {
        die('Lỗi khi chuẩn bị câu lệnh SQL: ' . $conn->error);
    }

    $stmt->bind_param("ssssssi", $fullName, $email, $phone, $address, $gender, $dob, $userId);
    $stmt->execute();

    // Cập nhật thông tin vào session
    $_SESSION['full_name'] = $fullName;
    $_SESSION['email'] = $email;
    $_SESSION['phone'] = $phone;
    $_SESSION['address'] = $address;
    $_SESSION['gender'] = $gender;
    $_SESSION['dob'] = $dob;

    $successMessage = "Cập nhật thông tin thành công!";
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hồ sơ người dùng</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* Cấu trúc chung của trang */
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9fb;
            /* Màu nền sáng, nhẹ */
            color: #333;
        }

        /* Header */
        header {
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        header img {
            width: 120px;
            height: auto;
        }

        /* Navigation */
        nav {
            display: flex;
            align-items: center;
        }

        nav a {
            margin: 0 20px;
            color: #555;
            font-weight: 500;
            text-decoration: none;
            transition: color 0.3s;
        }

        nav a:hover {
            color: #8c01c3;
        }

        /* Hiển thị tên người dùng và nút đăng xuất */
        nav .login-btn {
            background: linear-gradient(45deg, #8c01c3, #4e09cf);
            color: white;
            padding: 8px 16px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.3s;
        }

        nav .login-btn:hover {
            background: #5e11db;
            transform: scale(1.05);
        }

        nav .login-btn:active {
            background: #5e11db;
        }

        /* Form người dùng */
        .form-container {
            max-width: 900px;
            margin: 40px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        #user-info p {
            margin: 10px 0;
        }

        #user-info strong {
            color: #8c01c3;
        }

        #edit-button {
            background-color: #4e09cf;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        #edit-button:hover {
            background-color: #5e11db;
        }

        #edit-form input,
        #edit-form textarea,
        #edit-form select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 16px;
        }

        #edit-form textarea {
            resize: vertical;
        }

        button[type="submit"] {
            background-color: #4e09cf;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button[type="submit"]:hover {
            background-color: #5e11db;
        }

        .success {
            color: #28a745;
            font-weight: bold;
        }

        /* Responsive */
        @media (max-width: 768px) {
            header {
                flex-direction: column;
                text-align: center;
            }

            nav a {
                margin: 10px 0;
            }
        }
    </style>
</head>

<body>
    <header class="header">
        <img alt="EduQuiz Logo" height="40" src="../images/LOGO1.fc4be851.png" width="100" />
        <nav>
            <a href="../index.php">Trang chủ</a>
            <a href="../tailieu.php">Tài liệu</a>
            <a href="../tintuc.php">Tin tức</a>
            <a href="../gioithieu.php">Giới thiệu</a>
            <a href="../lienhe.php">Liên hệ</a>
            <?php if ($isLoggedIn): ?>
                <span>Xin chào, <?php echo htmlspecialchars($username, ENT_QUOTES); ?>!</span>
                <a href="logout.php" class="login-btn">Đăng Xuất</a>
            <?php else: ?>
                <a href="login.php" class="login-btn">Đăng Nhập</a>
            <?php endif; ?>
        </nav>
    </header>
    <div class="form-container">
        <?php if (!empty($successMessage)): ?>
            <p class="success"><?php echo $successMessage; ?></p>
        <?php endif; ?>

        <div id="user-info">
            <p><strong>Họ và tên:</strong> <?php echo htmlspecialchars($user['full_name'] ?? '', ENT_QUOTES); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email'] ?? '', ENT_QUOTES); ?></p>
            <p><strong>Số điện thoại:</strong> <?php echo htmlspecialchars($user['phone'] ?? '', ENT_QUOTES); ?></p>
            <p><strong>Địa chỉ:</strong> <?php echo htmlspecialchars($user['address'] ?? '', ENT_QUOTES); ?></p>
            <p><strong>Giới tính:</strong>
                <?php echo htmlspecialchars($user['gender'] = $_SESSION['gender'] ?? $user['gender'] ?? 'Chưa cập nhật', ENT_QUOTES); ?>
            </p>
            <p><strong>Ngày sinh:</strong>
                <?php echo htmlspecialchars($user['dob'] = $_SESSION['dob'] ?? $user['dob'] ?? 'Chưa cập nhật', ENT_QUOTES); ?>
            </p>

            <button id="edit-button">Sửa thông tin</button>
        </div>

        <!-- Form cập nhật thông tin -->
        <form id="edit-form" action="profile.php" method="POST" style="display: none;">
            <label for="full_name">Họ và tên:</label>
            <input type="text" id="full_name" name="full_name" value="<?php echo htmlspecialchars($user['full_name'] ?? '', ENT_QUOTES); ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email'] ?? '', ENT_QUOTES); ?>" required>

            <label for="phone">Số điện thoại:</label>
            <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone'] ?? '', ENT_QUOTES); ?>">

            <label for="address">Địa chỉ:</label>
            <textarea id="address" name="address" rows="4"><?php echo htmlspecialchars($user['address'] ?? '', ENT_QUOTES); ?></textarea>

            <label for="gender">Giới tính:</label>
            <select id="gender" name="gender">
                <option value="Nam" <?php echo (isset($user['gender']) && $user['gender'] == 'male') ? 'selected' : ''; ?>>Nam</option>
                <option value="Nữ" <?php echo (isset($user['gender']) && $user['gender'] == 'female') ? 'selected' : ''; ?>>Nữ</option>
                <option value="Khác" <?php echo (isset($user['gender']) && $user['gender'] == 'other') ? 'selected' : ''; ?>>Khác</option>
            </select>

            <label for="dob">Ngày sinh:</label>
            <input type="date" id="dob" name="dob" value="<?php echo htmlspecialchars($user['dob'] ?? '', ENT_QUOTES); ?>" required>

            <button type="submit">Cập nhật</button>
        </form>
    </div>

    <script>
        document.getElementById('edit-button').addEventListener('click', function() {
            document.getElementById('user-info').style.display = 'none';
            document.getElementById('edit-form').style.display = 'block';
        });
    </script>
</body>

</html>

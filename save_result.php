<?php
include 'db.php'; // Kết nối cơ sở dữ liệu

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kiểm tra xem các dữ liệu POST có tồn tại hay không
    if (isset($_POST['user_id'], $_POST['subject_name'], $_POST['score'])) {
        $user_id = $_POST['user_id'];
        $subject_name = $_POST['subject_name'];
        $score = $_POST['score'];

        // Kiểm tra dữ liệu có hợp lệ hay không
        if (!is_numeric($user_id) || !is_string($subject_name) || !is_numeric($score)) {
            echo json_encode(["success" => false, "message" => "Dữ liệu không hợp lệ."]);
            exit;
        }

        // Kiểm tra xem người dùng đã làm bài trước đó chưa
        $sql_check = "SELECT id, attempts FROM user_scores WHERE user_id = ? AND subject_name = ?";
        $stmt_check = $conn->prepare($sql_check);
        if ($stmt_check === false) {
            echo json_encode(["success" => false, "message" => "Lỗi khi chuẩn bị câu lệnh SQL."]);
            exit;
        }

        $stmt_check->bind_param("is", $user_id, $subject_name);
        $stmt_check->execute();
        $stmt_check->store_result();

        if ($stmt_check->num_rows > 0) {
            // Nếu đã có kết quả, cập nhật số lần làm bài và điểm số mới
            $stmt_check->bind_result($id, $attempts);
            $stmt_check->fetch();
            $new_attempts = $attempts + 1;

            // Cập nhật điểm số và số lần làm bài
            $sql_update = "UPDATE user_scores SET score = ?, attempts = ?, date_taken = CURRENT_TIMESTAMP WHERE id = ?";
            $stmt_update = $conn->prepare($sql_update);
            if ($stmt_update === false) {
                echo json_encode(["success" => false, "message" => "Lỗi khi chuẩn bị câu lệnh SQL cho cập nhật."]);
                exit;
            }

            $stmt_update->bind_param("dii", $score, $new_attempts, $id);

            if ($stmt_update->execute()) {
                echo json_encode(["success" => true, "message" => "Cập nhật kết quả thành công."]);
            } else {
                echo json_encode(["success" => false, "message" => "Cập nhật kết quả không thành công."]);
            }
        } else {
            // Nếu chưa có kết quả, thêm mới bản ghi
            $sql_insert = "INSERT INTO user_scores (user_id, subject_name, score, attempts, date_taken) VALUES (?, ?, ?, ?, CURRENT_TIMESTAMP)";
            $stmt_insert = $conn->prepare($sql_insert);
            if ($stmt_insert === false) {
                echo json_encode(["success" => false, "message" => "Lỗi khi chuẩn bị câu lệnh SQL cho thêm mới."]);
                exit;
            }

            $stmt_insert->bind_param("isdi", $user_id, $subject_name, $score, 1);

            if ($stmt_insert->execute()) {
                echo json_encode(["success" => true, "message" => "Lưu kết quả thành công."]);
            } else {
                echo json_encode(["success" => false, "message" => "Lưu kết quả không thành công."]);
            }
        }

        // Đóng kết nối
        $stmt_check->close();
        if (isset($stmt_update)) $stmt_update->close();
        if (isset($stmt_insert)) $stmt_insert->close();
        $conn->close();
    } else {
        echo json_encode(["success" => false, "message" => "Dữ liệu không đầy đủ."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Phương thức yêu cầu không hợp lệ."]);
}
?>

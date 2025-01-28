<?php
session_start();
require_once '../includes/db.php';

header('Content-Type: application/json');

try {
    if (isset($_POST['password'])) {
        $user_id = $_SESSION['user_id'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirm_password'];

        $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $dbPassword = $row['password'];

            if (password_verify($password, $dbPassword)) {
                $hashedPassword = password_hash($confirmPassword, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
                $stmt->bind_param('si', $hashedPassword, $user_id);
                $stmt->execute();
                echo json_encode(array("success" => true, "message" => "Password updated successfully."));
                exit;
            } else {
                echo json_encode(array("success" => false, "message" => "Password is wrong."));
                exit;
            }
        } else {
            echo json_encode(array("success" => false, "message" => "Invalid request hghg."));
            exit;
        }
        $conn->close();
    } else {
        echo json_encode(array("success" => false, "message" => "Invalid request no user."));
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(array("success" => false, "message" => "An error occurred: 25" . $e->getMessage()));
}
<?php

session_start();

require_once '../includes/db.php';



if (isset($_POST['submitlogin'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password, stage,status,role FROM users WHERE email = ?");
    $stmt->bind_param('s', $email);

    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $dbPassword = $row['password'];
        $userId = $row['id'];
        $stage = $row['stage'];
        $status = $row['status'];
        $role = $row['role'];

        if (password_verify($password, $dbPassword)) {
            if ($stage == 1 || $stage == 2) {
                $_SESSION['register_user_id'] = $userId;
                header("Location: ../register.php");
                exit;
            } else if ($stage == 3) {
                if ($status == 0) {
                    $_SESSION['user_verification_id'] = $userId;
                    header("Location: ../account-verification.php");
                } else {

                    if ($role == 1) {
                        $_SESSION['admin_id'] = $userId;
                        header("Location: ../eh-admin/dashboard.php");
                    } else {
                        $_SESSION['user_id'] = $userId;
                        header("Location: ../index.php");
                    }
                }
                exit;
            }
        } else {
            header("Location: ../login.php?error=wrong_password");
        }
    } else {
        header("Location: ../login.php?error=no_user");
    }
    $conn->close();
}


if (isset($_POST['submitVerification'])) {
    $code = $_POST['code'];
    $uid = $_SESSION['user_verification_id'];

    $stmt = $conn->prepare("SELECT verificationCode FROM users WHERE id = ?");
    $stmt->bind_param('s', $uid);

    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $dbPassword = $row['verificationCode'];

        if ($dbPassword == $code) {
            $stmt = $conn->prepare("UPDATE users SET status = 1 WHERE id = ?");
            $stmt->bind_param('s', $uid);
            $stmt->execute();
            session_destroy();
            session_start();
            $_SESSION['user_id'] = $uid;
            header("Location: ../index.php");
        } else {
            header("Location: ../account-verification.php?error=code");
        }
    } else {
        header("Location: ../login.php?error=no_user");
    }
    $conn->close();
}
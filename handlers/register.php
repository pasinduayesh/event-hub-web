<?php
session_start();

require_once '../includes/db.php';
require_once("../vendor/autoload.php");
require_once("./functions.php");
\Tinify\setKey("kGC1rd1m2LmvQS7cL0D5qCgHCj8J9mGY");

if (isset($_POST['submitregister'])) {
    $fname = $_POST['firstname'];
    $lname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];

    $stmt = $conn->prepare("SELECT stage FROM users WHERE email = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        header("Location: ../login.php?error=user_exist");
        exit;
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, password, phone) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param('sssss', $fname, $lname, $email, $hashedPassword, $phone);

        if ($stmt->execute()) {
            $lastInsertId = $stmt->insert_id;
            $_SESSION['register_user_id'] = $lastInsertId;

            $stmt = $conn->prepare("UPDATE users SET stage = 1 WHERE id = ?");
            $stmt->bind_param('i', $lastInsertId);
            $stmt->execute();

            header("Location: ../personal-details.php");
            exit;
        } else {
            echo "Failed to register the user.";
            exit;
        }
    }
}

if (isset($_POST['registerpersonal'])) {
    $DOB = $_POST['DOB'];
    $gender = $_POST['gender'] === 'Male' ? 1 : 0;
    $location = $_POST['location'];

    try {
        $source = \Tinify\fromFile($_FILES['img']['tmp_name']);
    } catch (\Throwable $th) {
        echo json_encode(array("success" => false, "message" => $th, "type" => "add"));
    }

    $originalFileName = $_FILES['img']['name'];
    $targetDirectory = "../resources/images/user/";
    $targetFileName = generateUniqueID(14) . '.' . pathinfo($originalFileName, PATHINFO_EXTENSION);
    $targetFilePath = $targetDirectory . $targetFileName;

    $source->toFile($targetFilePath);


    $stmt = $conn->prepare("UPDATE users SET DOB = ?, gender = ?, address = ?, img = ? WHERE id = ?");
    $stmt->bind_param('ssssi', $DOB, $gender, $location, $targetFileName, $_SESSION['register_user_id']);

    if ($stmt->execute()) {
        $stmt = $conn->prepare("UPDATE users SET stage = 2 WHERE id = ?");
        $stmt->bind_param('i', $_SESSION['register_user_id']);
        $stmt->execute();

        header("Location: ../interests.php");

    } else {
        echo "Failed to update personal details.";
    }

    $conn->close();

}

if (isset($_POST['selectedCategories'])) {
    $selectedCategories = $_POST['selectedCategories'];

    $userId = $_SESSION['register_user_id'];

    $stmt = $conn->prepare("DELETE FROM userinterests WHERE user_id = ?");
    $stmt->bind_param('i', $_SESSION['register_user_id']);

    if ($stmt->execute()) {
        $categoryIDs = explode(',', $selectedCategories);

        $stmtInsert = $conn->prepare("INSERT INTO userinterests (user_id, category_id) VALUES (?, ?)");

        if ($stmtInsert) {
            foreach ($categoryIDs as $categoryID) {
                $stmtInsert->bind_param('ii', $_SESSION['register_user_id'], $categoryID);
                $stmtInsert->execute();
            }
        } else {
            echo "Failed to add user interests.";

        }
    }

    $stmt = $conn->prepare("UPDATE users SET stage = 3 WHERE id = ?");
    $stmt->bind_param('i', $_SESSION['register_user_id']);
    $stmt->execute();
    $conn->close();
    session_destroy();
    session_start();
    header("Location: ../login.php?registration=success");
    $_SESSION['user_verification_id'] = $userId;
    header("Location: ../account-verification.php");
    $conn->close();
    exit;
}
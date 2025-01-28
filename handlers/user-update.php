<?php
session_start();
require_once '../includes/db.php';
require_once("../vendor/autoload.php");
require_once("./functions.php");
\Tinify\setKey("kGC1rd1m2LmvQS7cL0D5qCgHCj8J9mGY");

header('Content-Type: application/json');

try {
    if (isset($_POST['selectedCategoriesUpdate'])) {
        $user_id = $_SESSION['user_id'];
        $fname = $_POST['firstname'];
        $lname = $_POST['lastname'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $dob = $_POST['date'];
        $location = $_POST['location'];
        $gender = $_POST['gender'] === 'Male' ? 1 : 0;
        $imageForm = $_FILES['img']['name'];

        if ($imageForm) {
            $stmt = $conn->prepare("SELECT img FROM users WHERE id = ?");
            $stmt->bind_param('s', $user_id);
            $stmt->execute();

            // Bind the result variables
            $stmt->bind_result($image);
            $stmt->fetch();
            if ($image) {
                $file_path = '../resources/images/user/' . $image;
                if (file_exists($file_path) && is_file($file_path)) {
                    unlink($file_path);
                }
            }

            try {
                $source = \Tinify\fromFile($_FILES['img']['tmp_name']);
            } catch (\Throwable $th) {
                throw new Exception("Error with image.");
            }

            $originalFileName = $_FILES['img']['name'];
            $targetDirectory = "../resources/images/user/";
            $targetFileName = generateUniqueID(14) . '.' . pathinfo($originalFileName, PATHINFO_EXTENSION);
            $targetFilePath = $targetDirectory . $targetFileName;
            $source->toFile($targetFilePath);

            $stmt->close();

            $stmt = $conn->prepare("UPDATE users SET first_name = ?, last_name = ?, email = ?,img = ?, phone = ?, dob = ?, address = ?, gender = ? WHERE id = ?");
            $stmt->bind_param('ssssssssi', $fname, $lname, $email, $targetFileName, $phone, $dob, $location, $gender, $user_id);
        } else {
            $stmt = $conn->prepare("UPDATE users SET first_name = ?, last_name = ?, email = ?, phone = ?, dob = ?, address = ?, gender = ? WHERE id = ?");
            $stmt->bind_param('sssssssi', $fname, $lname, $email, $phone, $dob, $location, $gender, $user_id);
        }

        if ($stmt->execute()) {
            $stmt->close();

            $stmt = $conn->prepare("DELETE FROM userinterests WHERE user_id = ?");
            $stmt->bind_param('i', $user_id);
            $stmt->execute();

            $selectedCategories = $_POST['selectedCategoriesUpdate'];

            $stmtInsert = $conn->prepare("INSERT INTO userinterests (user_id, category_id) VALUES (?, ?)");

            if ($stmt) {
                $categoryIDs = explode(',', $selectedCategories);

                foreach ($categoryIDs as $categoryID) {
                    $stmtInsert->bind_param('ii', $_SESSION['user_id'], $categoryID);
                    $stmtInsert->execute();
                }
                echo json_encode(array("success" => true, "message" => "Account updated successfully!", "type" => "update"));
                exit;
            } else {
                throw new Exception("Error preparing event categories statement.");
            }
        } else {
            throw new Exception("Error executing event update statement.");
        }

        $conn->close();
    } else {
        http_response_code(400);
        echo json_encode(array("success" => false, "message" => "Invalid request."));
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(array("success" => false, "message" => "An error occurred: " . $e->getMessage()));
}
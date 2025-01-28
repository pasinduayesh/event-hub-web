<?php
session_start();
require_once '../includes/db.php';
require_once("../vendor/autoload.php");
require_once("./functions.php");
\Tinify\setKey("kGC1rd1m2LmvQS7cL0D5qCgHCj8J9mGY");

header('Content-Type: application/json');

try {
    if (isset($_POST['selectedCategoriesUpdate'])) {
        $event_id = $_POST['event_id'];
        $name = $_POST['name'];
        $price = $_POST['price'];
        $tickets = $_POST['tickets'];
        $address = $_POST['address'];
        $description = $_POST['description'];
        $time = $_POST['time'];
        $date = $_POST['date'];
        $selectedCategories = $_POST['selectedCategoriesUpdate'];
        $location = $_POST['location'];
        $ageRestriction = $_POST['agerestriction'] === 'Yes' ? 1 : 0;
        $imageForm = $_FILES['img']['name'];

        if ($imageForm) {
            $stmt = $conn->prepare("SELECT image FROM events WHERE id = ?");
            $stmt->bind_param('s', $_POST['event_id']);
            $stmt->execute();

            // Bind the result variables
            $stmt->bind_result($image);
            $stmt->fetch();
            if ($image) {
                $file_path = '../uploads/' . $image;
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
            $targetDirectory = "../uploads/";
            $targetFileName = generateUniqueID(14) . '.' . pathinfo($originalFileName, PATHINFO_EXTENSION);
            $targetFilePath = $targetDirectory . $targetFileName;
            $source->toFile($targetFilePath);

            $stmt->close();

            $stmt = $conn->prepare("UPDATE events SET name = ?, price = ?, tickets_count = ?, venue = ?,time=?, description = ?,location = ?, age_restricted = ?, date = ?, image = ? WHERE id = ?");
            $stmt->bind_param('ssisssssssi', $name, $price, $tickets, $address, $time, $description, $location, $ageRestriction, $date, $targetFileName, $event_id);
        } else {
            $stmt = $conn->prepare("UPDATE events SET name = ?, price = ?, tickets_count = ?, venue = ?,time=?, description = ?,location = ?, age_restricted = ?, date = ? WHERE id = ?");
            $stmt->bind_param('ssissssssi', $name, $price, $tickets, $address, $time, $description, $location, $ageRestriction, $date, $event_id);
        }

        if ($stmt->execute()) {
            $stmt->close();

            $stmt = $conn->prepare("DELETE FROM eventcategories WHERE event_id = ?");
            $stmt->bind_param("i", $event_id);
            $stmt->execute();
            $stmt->close();

            $stmt = $conn->prepare("INSERT INTO eventcategories (event_id, category_id) VALUES (?, ?)");

            if ($stmt) {
                $categoryIDs = explode(',', $selectedCategories);

                foreach ($categoryIDs as $categoryID) {
                    $stmt->bind_param("ii", $event_id, $categoryID);
                    if (!$stmt->execute()) {
                        throw new Exception("Error executing event categories statement.");
                    }
                }
                echo json_encode(array("success" => true, "message" => "Event updated successfully!", "type" => "update"));
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

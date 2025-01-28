<?php
session_start();
require_once '../includes/db.php';
require_once("../vendor/autoload.php");
require_once("./functions.php");
\Tinify\setKey("kGC1rd1m2LmvQS7cL0D5qCgHCj8J9mGY");

header('Content-Type: application/json');

if (isset($_POST['selectedCategories'])) {

    $name = $_POST['name'];
    $price = $_POST['price'];
    $tickets = $_POST['tickets'];
    $address = $_POST['address'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $selectedCategories = $_POST['selectedCategories'];
    $location = $_POST['location'];
    $address = $_POST['address'];
    $ageRestriction = $_POST['agerestriction'] === 'Yes' ? 1 : 0;

    try {
        $source = \Tinify\fromFile($_FILES['img']['tmp_name']);
    } catch (\Throwable $th) {
        echo json_encode(array("success" => false, "message" => $th, "type" => "add"));
    }

    $originalFileName = $_FILES['img']['name'];
    $targetDirectory = "../uploads/";
    $targetFileName = generateUniqueID(14) . '.' . pathinfo($originalFileName, PATHINFO_EXTENSION);
    $targetFilePath = $targetDirectory . $targetFileName;

    $source->toFile($targetFilePath);

    $sql = "INSERT INTO events (name, created_at, tickets_count, price, age_restricted, user_id, venue, time, description, date, location, image) VALUES (?, NOW(), ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    try {
        if ($stmt) {
            $stmt->bind_param(
                "sssssssssss",
                $name,
                $tickets,
                $price,
                $ageRestriction,
                $_SESSION['user_id'],
                $address,
                $time,
                $description,
                $date,
                $location,
                $targetFileName
            );

            if ($stmt->execute()) {


                $categoryIDs = explode(',', $selectedCategories);
                $lastInsertId = $conn->insert_id;
                $stmt->close();

                $stmt = $conn->prepare("INSERT INTO eventcategories (event_id, category_id) VALUES (?,?)");

                if ($stmt) {
                    foreach ($categoryIDs as $categoryID) {

                        try {
                            $stmt->bind_param("ii", $lastInsertId, $categoryID);
                            $stmt->execute();
                        } catch (\Throwable $th) {
                            echo json_encode(array("success" => false, "message" => $th, "type" => "add"));
                        }
                    }
                    $stmt->close();
                } else {
                    echo json_encode(array("success" => false, "message" => "Error with the category", "type" => "add"));
                }
                echo json_encode(array("success" => true, "message" => "Event added successfully!", "type" => "add"));
                exit;
            } else {
                echo json_encode(array("success" => false, "message" => "Error event", "type" => "add"));
            }
        }
    } catch (\Throwable $th) {
        echo json_encode(array("success" => false, "message" => $th, "type" => "add"));
    }


    $conn->close();
} else {
    http_response_code(400);
    echo json_encode(array("success" => false, "message" => "Invalid request."));
    exit;
}
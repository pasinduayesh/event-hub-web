<?php
// userUpdate.php

require_once '../../includes/db.php';

$response = array();

if (isset($_GET['action'])) {
    $action = $_GET['action'];

    $response["success"] = true;
    $response["message"] = $action;

    if ($action === 'view') {
        $stmt = $conn->prepare("SELECT id,name FROM categories ORDER BY id DESC");

        if ($stmt->execute()) {
            $stmt->bind_result($id, $name);
            $rows = array();

            while ($stmt->fetch()) {
                // Store the fetched data in an array
                $row = array(
                    'id' => $id,
                    'name' => $name
                );

                // Add the row data to the rows array
                $rows[] = $row;
            }

            $stmt->close();

            // Add the rows data to the response
            $response["data"] = $rows;
        } else {
            $response["success"] = false;
            $response["message"] = "Failed to fetch event data";
        }
    } elseif ($action === 'add') {
        $stmt = $conn->prepare("INSERT INTO categories (name) VALUES (?)");
        $stmt->bind_param("s", $_GET['name']);
        if ($stmt->execute()) {
            $response["success"] = true;
            $response["message"] = "event added successfully";
        }
        $stmt->close();
    } elseif ($action === 'update') {
        $stmt = $conn->prepare("UPDATE categories SET name = ? WHERE id = ?");
        $stmt->bind_param("ss", $_GET['name'], $_GET['id']);
        if ($stmt->execute()) {
            $response["success"] = true;
            $response["message"] = "event added successfully";
        }
        $stmt->close();
    }

}
header('Content-Type: application/json');
echo json_encode($response);
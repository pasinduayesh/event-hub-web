<?php
// userUpdate.php

require_once '../../includes/db.php';

$response = array();

if (isset($_GET['uid']) && isset($_GET['action'])) {
    $userID = $_GET['uid'];
    $action = $_GET['action'];

    if ($action === 'approve') {
        $stmt = $conn->prepare("UPDATE users SET status = 1 WHERE id = ?");
        $stmt->bind_param('s', $userID);
        if ($stmt->execute()) {
            $response["success"] = true;
            $response["message"] = "User approved successfully.";
        } else {
            $response["success"] = false;
            $response["message"] = "Failed to approve user.";
        }
    } elseif ($action === 'delete') {
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param('s', $userID);
        if ($stmt->execute()) {
            $response["success"] = true;
            $response["message"] = "User deleted successfully.";
        } else {
            $response["success"] = false;
            $response["message"] = "Failed to delete user.";
        }
    } else {
        $response["success"] = false;
        $response["message"] = "Invalid action specified.";
    }
} elseif (isset($_GET['userSearch']) && isset($_GET['type'])) {
    $eventStatus = $_GET['type'];

    if ($eventStatus == 'approved') {
        $stmt = $conn->prepare("SELECT id,last_name,first_name,email,address,gender,DOB,created_at,NIC,status,phone,img FROM users WHERE role=0 AND status = 1");
    } elseif ($eventStatus == 'unapproved') {
        $stmt = $conn->prepare("SELECT id,last_name,first_name,email,address,gender,DOB,created_at,NIC,status,phone,img FROM users WHERE role=0 AND status = 0");
    } elseif ($eventStatus == 'all') {
        $stmt = $conn->prepare("SELECT id,last_name,first_name,email,address,gender,DOB,created_at,NIC,status,phone,img FROM users WHERE role=0");
    } else {
        $stmt = $conn->prepare("SELECT id,last_name,first_name,email,address,gender,DOB,created_at,NIC,status,phone,img FROM users WHERE role=0");
    }
    $stmt->execute();

    // Bind the result variables
    $stmt->bind_result($id, $last_name, $first_name, $email, $address, $gender, $DOB, $created_at, $NIC, $status, $phone, $img);

    // Initialize an empty array to store the table rows
    $rows = array();

    // Fetch the results and store them in the array
    while ($stmt->fetch()) {
        // Store the fetched data in an array
        $row = array(
            'status' => ($status == 0) ? '' : 'approved',
            'img' => ($img == '') ? 'https://st3.depositphotos.com/6672868/13701/v/450/depositphotos_137014128-stock-illustration-user-profile-icon.jpg' : '../resources/images/user/' . $img,
            'id' => $id,
            'full_name' => $first_name . " " . $last_name,
            'email' => $email,
            'phone' => $phone
        );

        // Add the row data to the rows array
        $rows[] = $row;
    }

    $stmt->close();

    // Add the rows data to the response
    $response["data"] = $rows;
}

header('Content-Type: application/json');
echo json_encode($response);

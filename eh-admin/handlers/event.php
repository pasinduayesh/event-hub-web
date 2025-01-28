<?php
// userUpdate.php

require_once '../../includes/db.php';

$response = array();

if (isset($_GET['uid']) && isset($_GET['eid']) && isset($_GET['action'])) {
    $userID = $_GET['uid'];
    $eventID = $_GET['eid'];
    $action = $_GET['action'];

    if ($action === 'view') {

        $stmt = $conn->prepare("
            SELECT
                e.id,
                e.image,
                e.name,
                e.user_id,
                u.email,  -- Adding the email column from the users table
                e.location,
                e.date,
                e.time,
                e.tickets_count,
                e.price,
                e.description,
                e.venue,
                e.status,
                COALESCE(SUM(ube.quantity), 0) AS total_tickets_booked
            FROM
                events AS e
            LEFT JOIN
                userbookevent AS ube ON e.id = ube.event_id
            LEFT JOIN
                users AS u ON e.user_id = u.id  -- Joining with the users table
            WHERE
                e.id = ?
            GROUP BY
                e.id;
        ");
        $stmt->bind_param('s', $eventID);
        if ($stmt->execute()) {
            $stmt->bind_result($id, $image, $name, $userid, $email, $location, $date, $time, $tickets, $price, $description, $address, $status, $total_tickets_booked);
            $stmt->fetch();

            $row = array(
                'status' => ($status == 0) ? '' : 'approved',
                'img' => ($image == '') ? 'https://st3.depositphotos.com/6672868/13701/v/450/depositphotos_137014128-stock-illustration-user-profile-icon.jpg' : '../uploads/' . $image,
                'id' => $id,
                'name' => $name,
                'location' => $location,
                'date' => $date,
                'uid' => $userid,
                'email' => $email,
                'time' => $time,
                'tickets' => $tickets,
                'price' => $price,
                'address' => $address,
                'description' => $description,
                'bookedTickets' => $total_tickets_booked,
                'availableTickets' => $tickets - $total_tickets_booked
            );
            $response["data"] = $row;
            $response["success"] = true;
            $response["message"] = "Event details fetched successfully";
        } else {
            $response["success"] = false;
            $response["message"] = "Failed to fetch event data";
        }
    } elseif ($action === 'delete') {
        $stmt = $conn->prepare("DELETE FROM events WHERE id = ?");
        $stmt->bind_param('s', $eventID);
        if ($stmt->execute()) {
            $response["uid"] = $userID;
            $response["eid"] = $eventID;
            $response["success"] = true;
            $response["message"] = "User deleted successfully.";
        } else {
            $response["success"] = false;
            $response["message"] = "Failed to delete user.";
        }
    } elseif ($action === 'approve') {

        $stmt = $conn->prepare("UPDATE events SET status = 1 WHERE id = ?");
        $stmt->bind_param('s', $eventID);
        if ($stmt->execute()) {
            $response["success"] = true;
            $response["uid"] = $userID;
            $response["eid"] = $eventID;
            $response["message"] = "User deleted successfully.";
        } else {
            $response["success"] = false;
            $response["message"] = "Failed to delete user.";
        }
    } else {
        $response["success"] = false;
        $response["message"] = "Invalid action specified";
    }
} elseif (isset($_GET['uid']) && isset($_GET['type']) && isset($_GET['key-word'])) {
    $eventStatus = $_GET['type'];
    $userID = $_GET['uid'];
    $keyWord = $_GET['key-word'];

    if ($keyWord == "") {
        if ($eventStatus == 'approved') {
            if ($userID == "") {
                $stmt = $conn->prepare("SELECT id,name,status, image FROM events WHERE status = 1");
            } else {
                $stmt = $conn->prepare("SELECT id,name,status, image FROM events WHERE user_id=? AND status = 1");
            }

        } elseif ($eventStatus == 'unapproved') {

            if ($userID == "") {
                $stmt = $conn->prepare("SELECT id,name,status, image FROM events WHERE status = 0");
            } else {
                $stmt = $conn->prepare("SELECT id,name,status, image FROM events WHERE user_id=? AND status = 0");
            }

        } elseif ($eventStatus == 'all') {

            if ($userID == "") {
                $stmt = $conn->prepare("SELECT id,name,status, image FROM events");
            } else {
                $stmt = $conn->prepare("SELECT id,name,status, image FROM events WHERE user_id=?");
            }

        } else {

            if ($userID == "") {
                $stmt = $conn->prepare("SELECT id,name,status, image FROM events");
            } else {
                $stmt = $conn->prepare("SELECT id,name,status, image FROM events WHERE user_id=?");
            }

        }

        if ($userID != "") {
            $stmt->bind_param('s', $userID);
        }

    } else {

        if ($userID == "") {
            $stmt = $conn->prepare("SELECT id, name, status, image FROM events WHERE name LIKE ?");
        } else {
            $stmt = $conn->prepare("SELECT id, name, status, image FROM events WHERE user_id = ? AND name LIKE ?");
        }

        $keyWord = '%' . $keyWord . '%'; // Adding wildcards to the keyword

        if ($userID != "") {
            $stmt->bind_param('ss', $userID, $keyWord);

        } else {
            $stmt->bind_param('s', $keyWord);

        }

        $stmt->execute();

    }

    $stmt->execute();
    // Bind the result variables
    $stmt->bind_result($id, $name, $status, $img);
    // Initialize an empty array to store the table rows
    $rows = array();
    // Fetch the results and store them in the array
    while ($stmt->fetch()) {
        // Store the fetched data in an array
        $row = array(
            'status' => ($status == 0) ? '' : 'approved',
            'img' => ($img == '') ? 'https://st3.depositphotos.com/6672868/13701/v/450/depositphotos_137014128-stock-illustration-user-profile-icon.jpg' : '../uploads/' . $img,
            'id' => $id,
            'name' => $name,
            'uis' => $userID
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
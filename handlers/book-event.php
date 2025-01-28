<?php
session_start();
require_once '../includes/db.php';
require_once("./functions.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';
require '../PHPMailer-master/src/Exception.php';

header('Content-Type: application/json');

if (isset($_POST['book'])) {
    $ticketCount = $_POST['ticket-count'];
    $eventID = $_POST['event_id'];
    $userID = $_SESSION['user_id'];
    $eventPrice = $_POST['event_price'];
    $eventTime = $_POST['etime'];
    $eventDate = $_POST['edate'];
    $eventName = $_POST['ename'];
    $eventAddress = $_POST['eaddress'];
    try {

        $stmt = $conn->prepare("SELECT COUNT(id) FROM userbookevent WHERE event_id = ? AND user_id = ?");
        $stmt->bind_param("ii", $eventID, $userID);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        if ($stmt) {
            if ($count < 1) {
                $stmt = $conn->prepare("SELECT (
                SELECT SUM(quantity) FROM userbookevent WHERE event_id = ?
                ) AS totalBookedTickets, (
                SELECT tickets_count FROM events WHERE id = ?
                ) AS availableTickets");
                $stmt->bind_param("ii", $eventID, $eventID);
                $stmt->execute();
                $stmt->bind_result($totalBookedTickets, $availableTickets);
                $stmt->fetch();
                $stmt->close();

                if ($stmt) {
                    if ($ticketCount > ($availableTickets - $totalBookedTickets)) {
                        echo json_encode(array("success" => false, "message" => "Tickets are not available."));
                    } else {

                        $stmt = $conn->prepare("SELECT id, first_name, last_name, email, gender FROM users WHERE id = ?");
                        $stmt->bind_param("i", $_POST['uid']);
                        $stmt->execute();
                        $stmt->bind_result($id, $fname, $lname, $email, $gender);
                        $stmt->fetch();
                        $stmt->close();

                        $greeting = $gender == 1 ? 'Sir' : 'Madam';

                        $mail = new PHPMailer(true);

                        try {
                            //Server settings
                            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;  // Enable verbose debug output
                            $mail->isSMTP(); // Send using SMTP
                            $mail->Host = 'eventhub.ribluma.com'; // Set the SMTP server to send through
                            $mail->SMTPAuth = true; // Enable SMTP authentication
                            $mail->Username = 'sales@eventhub.ribluma.com'; // SMTP username
                            $mail->Password = 'Negus@123'; // SMTP password
                            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Enable SSL/TLS encryption
                            $mail->Port = 465; // SSL/TLS port

                            //Recipients
                            $mail->setFrom('sales@eventhub.ribluma.com', 'EventHub');
                            $mail->addAddress($email, $fname); // Add a recipient

                            // Content
                            $mail->isHTML(false); // Set email format to plain text
                            $mail->Subject = 'Booking Confirmation';

                            $uniqueCode = generateUniqueID(6);

                            $emailBody = "Dear $greeting,\n\n";
                            $emailBody = "\n";
                            $emailBody .= "Thank you for booking the event \"$eventName\"\n";
                            $emailBody .= "Time : $eventTime.\n";
                            $emailBody .= "Date : $eventDate.\n";
                            $emailBody .= "Location : $eventAddress.\n";
                            $emailBody .= "Your booking id is: $uniqueCode.\n";
                            $emailBody .= "We look forward to seeing you at the event!\n\n";
                            $emailBody .= "Best regards,\nEventHub Team";

                            $mail->Body = $emailBody;

                            $mail->send();

                            $stmt = $conn->prepare("INSERT INTO userbookevent (user_id, event_id, quantity, cost, bookingID) VALUES (?, ?, ?,?,?)");
                            $cost = ($eventPrice * $ticketCount);
                            $stmt->bind_param("iiids", $userID, $eventID, $ticketCount, $cost, $uniqueCode);
                            $stmt->execute();
                            $stmt->close();
                            echo json_encode(array("success" => true, "message" => "Booked successfully!."));
                        } catch (Exception $e) {
                            echo json_encode(array("success" => false, "message" => "Something went wrong."));
                        }
                    }
                }

            } else {
                echo json_encode(array("success" => true, "message" => "You have already booked for this event."));
            }
        } else {
            echo json_encode(array("success" => false, "message" => "Something went wrong."));
        }

    } catch (\Throwable $th) {
        echo json_encode(array("success" => false, "message" => "Something went wrong." . $th));
    }

    $conn->close();
} else {
    http_response_code(400);
    echo json_encode(array("success" => false, "message" => "Invalid request."));
    exit;
}
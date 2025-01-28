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

if (isset($_POST['delete-event'])) {

    $ename = $_POST['eventName'];

    // Prepare the statement
    $stmt = $conn->prepare("SELECT
    u.id AS user_id,
    u.email,
    u.first_name
FROM
    users AS u
INNER JOIN
    userbookevent AS ube ON u.id = ube.user_id
WHERE
    ube.event_id = ?
    GROUP BY u.id;");

    $stmt->bind_param('s', $_POST['eventID']);

    $stmt->execute();

    // Bind the result variables
    $stmt->bind_result($id, $email, $name);

    // Output buffer
    ob_start();

    // Fetch the results
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

        // Recipients
        $mail->setFrom('sales@eventhub.ribluma.com', 'EventHub');

        while ($stmt->fetch()) {
            $mail->addAddress($email, $name);
        }

        // Content
        $mail->isHTML(false); // Set email format to plain text
        $mail->Subject = 'Event Canceled';


        $emailBody = "Dear user,\n\n";
        $emailBody .= "\n";
        $emailBody .= "We are sorry to say that the $ename event got cancelled due to unavoidable reasons.\n";

        $mail->Body = $emailBody;

        // Send the email to all recipients at once
        try {
            if (!$mail) {
                $mail->send();
            }
        } finally {

            $stmt = $conn->prepare("DELETE FROM events WHERE id =?");

            $stmt->bind_param('s', $_POST['eventID']);

            $stmt->execute();

            echo json_encode(array("success" => true, "message" => "Successfully deleted."));
        }


    } catch (Exception $e) {
        echo json_encode(array("success" => true, "message" => "Something went wrong." . $e));
    }

    // Get the buffered output
    $output = ob_get_clean();

    // Close the statement
    $stmt->close();
    $conn->close();
    // Output the buffered HTML
    echo $output;
} else {
    echo json_encode(array("success" => false, "message" => "Invalid request."));
    exit;
}
<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


require './PHPMailer-master/src/PHPMailer.php';
require './PHPMailer-master/src/SMTP.php';
require './PHPMailer-master/src/Exception.php';
require_once './handlers/functions.php';
require './includes/db.php';



session_start();
if (!isset($_SESSION['user_verification_id'])) {
    header("Location: login.php");
} else {
    $uid = $_SESSION['user_verification_id'];

    $stmt = $conn->prepare("SELECT id, first_name, last_name, email, gender FROM users WHERE id = ?");
    $stmt->bind_param("i", $uid);
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
        $mail->Subject = 'Account activation';

        $uniqueCode = generateUniqueID(5);

        $emailBody = "Dear $greeting,\n\n";
        $emailBody = "\n";
        $emailBody .= "Your verification code is: $uniqueCode.\n";
        $emailBody .= "Best regards,\nEventHub Team";

        $mail->Body = $emailBody;

        $mail->send();

        $stmt = $conn->prepare("UPDATE users SET verificationCode = ? WHERE id = ?");
        $stmt->bind_param("ss", $uniqueCode, $uid);
        $stmt->execute();
        $stmt->close();
    } catch (Exception $e) {
        echo "Email could not be sent. There was an error: {$mail->ErrorInfo}";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
            integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="icon" type="image/x-icon" href="../resources/images/root/favicon.png">
        <link rel="stylesheet" href="./resources/styles/index.css">
        <script src="./resources/scripts/index.js" defer></script>
        <title>EventHub | Account-Verification</title>
    </head>

    <body>
        <div class="background-pattern">
            <img class="blob blob-2" src="./resources/images/root/Component 2.png" alt="" srcset="">
            <img class="blob blob-1" src="./resources/images/root/Component 1.png" alt="" srcset="">
            <div class="pattern"></div>
        </div>
        <div class="login-register-wrapper min-h-w fx-c-c">



            <img src="./resources/images/root/eventhub black.png" alt="Logo">

            <form action="./handlers/login.php" method="POST">

                <span style="font-size : 1.5rem; text-align: center;">You will recieve a verification code to your
                    email.</span>
                <?php
                if (isset($_GET['error'])) {
                    $error = $_GET['error'];

                    if ($error === "code") {
                        echo '
                        <div class="pop-up-msg">
                            <i class="svg-wrapper">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                    <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zm0-384c13.3 0 24 10.7 24 24V264c0 13.3-10.7 24-24 24s-24-10.7-24-24V152c0-13.3 10.7-24 24-24zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z" />
                                </svg>
                            </i>

                            <span>
                                Invalid Code
                            </span>
                        </div>
                    ';
                    }
                }
                ?>

                <div class="input-wrapper">
                    <i class="svg-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 448 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                            <path
                                d="M144 144v48H304V144c0-44.2-35.8-80-80-80s-80 35.8-80 80zM80 192V144C80 64.5 144.5 0 224 0s144 64.5 144 144v48h16c35.3 0 64 28.7 64 64V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V256c0-35.3 28.7-64 64-64H80z" />
                        </svg>
                    </i>
                    <input type="text" placeholder="Verification code" name="code" required>
                </div>

                <button class="submit-btn" type="submit" name="submitVerification">
                    Submit
                </button>

            </form>
        </div>
    </body>

</html>
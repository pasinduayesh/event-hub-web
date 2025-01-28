<?php

session_start();

if (isset($_SESSION['register_user_id'])) {

    require_once "./includes/db.php";
    $stmt = $conn->prepare("SELECT stage FROM users WHERE id = ?");
    $stmt->bind_param('s', $_SESSION['register_user_id']);

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $stage = $row['stage'];

        if ($stage == 0) {
            header("Location: ./register.php");
            exit;
        } else if ($stage == 2) {
            header("Location: ./interests.php");
            exit;
        } else if ($stage == 3) {
            header("Location: ./index.php");
            exit;
        }
    } else {
        session_destroy();
        header("Location: ./register.php");
    }

} else if (isset($_SESSION['user_id'])) {
    header("Location: ./index.php");
} else {
    session_destroy();
    header("Location: ./register.php");
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

        <title>EventHub | Personal Details</title>
    </head>

    <body>
        <div class="background-pattern">
            <img class="blob blob-2" src="./resources/images/root/Component 2.png" alt="" srcset="">
            <img class="blob blob-1" src="./resources/images/root/Component 1.png" alt="" srcset="">
            <div class="pattern"></div>
        </div>
        <div class="login-register-wrapper min-h-w fx-c-c">



            <img src="./resources/images/root/eventhub black.png" alt="Logo">

            <form action="./handlers/register.php" enctype="multipart/form-data" method="POST">

                <img src="https://st3.depositphotos.com/6672868/13701/v/450/depositphotos_137014128-stock-illustration-user-profile-icon.jpg"
                    alt="" id="previewImage">
                <div class="input-wrapper">
                    <i class="svg-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em"
                            viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                            <path
                                d="M0 96C0 60.7 28.7 32 64 32H448c35.3 0 64 28.7 64 64V416c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V96zM323.8 202.5c-4.5-6.6-11.9-10.5-19.8-10.5s-15.4 3.9-19.8 10.5l-87 127.6L170.7 297c-4.6-5.7-11.5-9-18.7-9s-14.2 3.3-18.7 9l-64 80c-5.8 7.2-6.9 17.1-2.9 25.4s12.4 13.6 21.6 13.6h96 32H424c8.9 0 17.1-4.9 21.2-12.8s3.6-17.4-1.4-24.7l-120-176zM112 192a48 48 0 1 0 0-96 48 48 0 1 0 0 96z" />
                        </svg>
                    </i>

                    <label for="imageInput" class="input-dialog-box-wrapper">
                        <p id="image-placeholder">Select an image</p>
                        <input type="file" id="imageInput"
                            onchange="previewImageTag(event); setPlaceholder('imageInput','image-placeholder', 'Select an image');"
                            name="img" required>
                    </label>
                </div>
                <div class="input-wrapper">
                    <i class="svg-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 448 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                            <path
                                d="M128 0c17.7 0 32 14.3 32 32V64H288V32c0-17.7 14.3-32 32-32s32 14.3 32 32V64h48c26.5 0 48 21.5 48 48v48H0V112C0 85.5 21.5 64 48 64H96V32c0-17.7 14.3-32 32-32zM0 192H448V464c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V192zm64 80v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V272c0-8.8-7.2-16-16-16H80c-8.8 0-16 7.2-16 16zm128 0v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V272c0-8.8-7.2-16-16-16H208c-8.8 0-16 7.2-16 16zm144-16c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V272c0-8.8-7.2-16-16-16H336zM64 400v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16H80c-8.8 0-16 7.2-16 16zm144-16c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16H208zm112 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16H336c-8.8 0-16 7.2-16 16z" />
                        </svg>
                    </i>
                    <label for="DOB" class="input-dialog-box-wrapper">
                        <p id="date-of-birth-placeholder">Date of birth</p>
                        <input type="date" placeholder="Date Of Birth" name="DOB" id="DOB"
                            onchange="setPlaceholder('DOB','date-of-birth-placeholder', 'Date of Birth')" required>
                    </label>

                </div>

                <div class="input-wrapper">
                    <i class="svg-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 384 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                            <path
                                d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z" />
                        </svg>
                    </i>

                    <div class="custom-drop-down">
                        <input type="text" placeholder="Location" name="location" required>
                        <div class="drop-down-container">
                            <i class="svg-wrapper drop-down-icon">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 320 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                    <path
                                        d="M137.4 374.6c12.5 12.5 32.8 12.5 45.3 0l128-128c9.2-9.2 11.9-22.9 6.9-34.9s-16.6-19.8-29.6-19.8L32 192c-12.9 0-24.6 7.8-29.6 19.8s-2.2 25.7 6.9 34.9l128 128z" />
                                </svg>
                            </i>

                            <ul class="drop-down-list hide">
                                <li>Colombo</li>
                                <li>Moratuwa</li>
                                <li>Kandy</li>
                                <li>Negombo</li>
                                <li>Batticaloa</li>
                                <li>Sri Jayewardenepura Kotte</li>
                                <li>Kilinochchi</li>
                                <li>Galle</li>
                                <li>Trincomalee</li>
                                <li>Jaffna</li>
                                <li>Matara</li>
                                <li>Anuradhapura</li>
                                <li>Ratnapura</li>
                                <li>Puttalam</li>
                                <li>Badulla</li>
                                <li>Mullaittivu</li>
                                <li>Matale</li>
                                <li>Mannar</li>
                                <li>Kurunegala</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="input-wrapper">

                    <i class="svg-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 320 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                            <path
                                d="M160 0a48 48 0 1 1 0 96 48 48 0 1 1 0-96zm8 352V128h6.9c33.7 0 64.9 17.7 82.3 46.6l58.3 97c9.1 15.1 4.2 34.8-10.9 43.9s-34.8 4.2-43.9-10.9L232 256.9V480c0 17.7-14.3 32-32 32s-32-14.3-32-32V352h0zM58.2 182.3c19.9-33.1 55.3-53.5 93.8-54.3V384h0v96c0 17.7-14.3 32-32 32s-32-14.3-32-32V384H70.2c-10.9 0-18.6-10.7-15.2-21.1L93.3 248.1 59.4 304.5c-9.1 15.1-28.8 20-43.9 10.9s-20-28.8-10.9-43.9l53.6-89.2z" />
                        </svg>
                    </i>

                    <div class="custom-drop-down">
                        <input type="text" placeholder="Gender" name="gender" required>
                        <div class="drop-down-container">
                            <i class="svg-wrapper drop-down-icon">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 320 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                    <path
                                        d="M137.4 374.6c12.5 12.5 32.8 12.5 45.3 0l128-128c9.2-9.2 11.9-22.9 6.9-34.9s-16.6-19.8-29.6-19.8L32 192c-12.9 0-24.6 7.8-29.6 19.8s-2.2 25.7 6.9 34.9l128 128z" />
                                </svg>
                            </i>

                            <ul class="drop-down-list hide">
                                <li>Male</li>
                                <li>Female</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <button class="submit-btn" name="registerpersonal" type="submit">
                    Next
                </button>

            </form>
        </div>
        <script src="https://code.jquery.com/jquery-3.7.0.min.js"
            integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
        <script src="./resources/scripts/index.js"></script>
    </body>

</html>
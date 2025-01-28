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

        if ($stage == 2) {
            header("Location: ./interests.php");
            exit;
        } else if ($stage == 1) {
            header("Location: ./personal-details.php");
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
        <title>EventHub | Register</title>
    </head>

    <body>
        <div class="background-pattern">
            <img class="blob blob-2" src="./resources/images/root/Component 2.png" alt="" srcset="">
            <img class="blob blob-1" src="./resources/images/root/Component 1.png" alt="" srcset="">
            <div class="pattern"></div>
        </div>

        <div class="login-register-wrapper min-h-w fx-c-c">



            <img src="./resources/images/root/eventhub black.png" alt="Logo">
            <form action="./handlers/register.php" method="POST" id="userRegister">
                <div class="pop-up-msg hide" id="passwordMismatchError">
                    <i class="svg-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 512 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                            <path
                                d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zm0-384c13.3 0 24 10.7 24 24V264c0 13.3-10.7 24-24 24s-24-10.7-24-24V152c0-13.3 10.7-24 24-24zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z" />
                        </svg>
                    </i>

                    <span>
                        Password doesnt match
                    </span>
                </div>

                <div class="input-wrapper">
                    <i class="svg-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 448 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                            <path
                                d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z" />
                        </svg>
                    </i>
                    <input type="text" placeholder="First Name" name="firstname" required>
                </div>

                <div class="input-wrapper">
                    <i class="svg-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 448 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                            <path
                                d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z" />
                        </svg>
                    </i>
                    <input type="text" placeholder="Last Name" name="lastname" required>
                </div>

                <div class="input-wrapper">
                    <i class="svg-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 512 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                            <path
                                d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48H48zM0 176V384c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V176L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z" />
                        </svg>
                    </i>
                    <input type="email" placeholder="Email" name="email" required>
                </div>

                <div class="input-wrapper">
                    <i class="svg-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em"
                            viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                            <path
                                d="M164.9 24.6c-7.7-18.6-28-28.5-47.4-23.2l-88 24C12.1 30.2 0 46 0 64C0 311.4 200.6 512 448 512c18 0 33.8-12.1 38.6-29.5l24-88c5.3-19.4-4.6-39.7-23.2-47.4l-96-40c-16.3-6.8-35.2-2.1-46.3 11.6L304.7 368C234.3 334.7 177.3 277.7 144 207.3L193.3 167c13.7-11.2 18.4-30 11.6-46.3l-40-96z" />
                        </svg>
                    </i>
                    <input type="text" placeholder="Phone" name="phone" required>
                </div>

                <div class="input-wrapper">
                    <i class="svg-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 448 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                            <path
                                d="M144 144v48H304V144c0-44.2-35.8-80-80-80s-80 35.8-80 80zM80 192V144C80 64.5 144.5 0 224 0s144 64.5 144 144v48h16c35.3 0 64 28.7 64 64V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V256c0-35.3 28.7-64 64-64H80z" />
                        </svg>
                    </i>
                    <input type="password" placeholder="Password" name="password" id="password"
                        onkeydown="checkPasswordMatch()" onkeypress="checkPasswordMatch()"
                        onchange="checkPasswordMatch()" required>
                </div>

                <div class="input-wrapper">
                    <i class="svg-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 448 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                            <path
                                d="M144 144v48H304V144c0-44.2-35.8-80-80-80s-80 35.8-80 80zM80 192V144C80 64.5 144.5 0 224 0s144 64.5 144 144v48h16c35.3 0 64 28.7 64 64V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V256c0-35.3 28.7-64 64-64H80z" />
                        </svg>
                    </i>
                    <input type="password" placeholder="Confirm Password" name="confirmpassword" id="confirmpassword"
                        onkeydown="checkPasswordMatch()" onkeypress="checkPasswordMatch()"
                        onchange="checkPasswordMatch()" required>
                </div>

                <button class="submit-btn submit-btn-disabled" name="submitregister" type="submit" id="register-submit">
                    Register
                </button>



                <a href="login.php">Already have an account ? Login.</a>

            </form>
        </div>
        <script src="https://code.jquery.com/jquery-3.7.0.min.js"
            integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
        <script src="./resources/scripts/index.js"></script>
    </body>

</html>
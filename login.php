<?php

session_start();

if (isset($_SESSION['register_user_id'])) {

    header("Location: ./register.php");

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
        <title>EventHub | Login</title>
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

                <?php
                if (isset($_GET['error'])) {
                    $error = $_GET['error'];

                    if ($error === "user_exist") {
                        echo '
                        <div class="pop-up-msg">
                            <i class="svg-wrapper">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                    <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zm0-384c13.3 0 24 10.7 24 24V264c0 13.3-10.7 24-24 24s-24-10.7-24-24V152c0-13.3 10.7-24 24-24zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z" />
                                </svg>
                            </i>

                            <span>
                                User Already Exists
                            </span>
                        </div>
                    ';
                    }

                    if ($error === "wrong_password") {
                        echo '
                        <div class="pop-up-msg">
                            <i class="svg-wrapper">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                    <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zm0-384c13.3 0 24 10.7 24 24V264c0 13.3-10.7 24-24 24s-24-10.7-24-24V152c0-13.3 10.7-24 24-24zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z" />
                                </svg>
                            </i>

                            <span>
                                Wrong password
                            </span>
                        </div>
                    ';
                    }

                    if ($error === "no_user") {
                        echo '
                        <div class="pop-up-msg">
                            <i class="svg-wrapper">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                    <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zm0-384c13.3 0 24 10.7 24 24V264c0 13.3-10.7 24-24 24s-24-10.7-24-24V152c0-13.3 10.7-24 24-24zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z" />
                                </svg>
                            </i>

                            <span>
                                User doesnt exist
                            </span>
                        </div>
                    ';
                    }
                } else if (isset($_GET['registration'])) {
                    echo '
                        <div class="pop-up-msg success">
                            <i class="svg-wrapper">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                    <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zm0-384c13.3 0 24 10.7 24 24V264c0 13.3-10.7 24-24 24s-24-10.7-24-24V152c0-13.3 10.7-24 24-24zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z" />
                                </svg>
                            </i>

                            <span>
                                Successfully registered!
                            </span>
                        </div>
                    ';
                }
                ?>


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
                        <svg xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 448 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                            <path
                                d="M144 144v48H304V144c0-44.2-35.8-80-80-80s-80 35.8-80 80zM80 192V144C80 64.5 144.5 0 224 0s144 64.5 144 144v48h16c35.3 0 64 28.7 64 64V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V256c0-35.3 28.7-64 64-64H80z" />
                        </svg>
                    </i>
                    <input type="password" placeholder="Password" name="password" required>
                </div>

                <button class="submit-btn" type="submit" name="submitlogin">
                    Login
                </button>



                <a href="register.php">Creat an account ? Register.</a>

            </form>
        </div>
    </body>

</html>
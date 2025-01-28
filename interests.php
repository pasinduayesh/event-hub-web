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
            <p>Please select topics you are interested in.</p>

            <form action=" ./handlers/register.php" method="POST"
                class="interests-card-container-form personal-interets">
                <div class="interests-card-container">
                    <?php

                    $sql = "SELECT * FROM categories";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // Output data of each row
                        while ($row = $result->fetch_assoc()) {
                            echo '<button type="button" class="interests-card" onclick="toggleCategory(this)" data-category-id="' . $row['id'] . '">' . $row['name'] . '<i class="svg-wrapper svg-wrapper-float"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z" /></svg></i></button>';
                        }
                    }

                    $conn->close();
                    ?>
                </div>
                <button type="submit" class="submit-btn">Next</button>
                <input type="hidden" id="selectedCategoriesInput" name="selectedCategories"
                    class="selectedCategoriesInput">
            </form>

        </div>
        <script src="https://code.jquery.com/jquery-3.7.0.min.js"
            integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
        <script src="./resources/scripts/index.js"></script>
    </body>

</html>
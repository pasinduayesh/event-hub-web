<?php
session_start();
require_once "./includes/db.php";

$stmt = $conn->prepare("SELECT id, first_name, last_name,img, address, DOB, email, gender, phone
                       FROM users
                       WHERE id = ?");
$stmt->bind_param('s', $_SESSION['user_id']);
$stmt->execute();

// Bind the result variables
$stmt->bind_result($id, $firstName, $lastName, $img, $location, $dob, $email, $gender, $phone);

// Output buffer
ob_start();
$stmt->fetch();
$stmt->close();
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
        <title>EventHub | Account</title>
    </head>

    <body>
        <div class="background-pattern">
            <img class="blob blob-2" src="../resources/images/root/Component 2.png" alt="" srcset="">
            <img class="blob blob-1" src="../resources/images/root/Component 1.png" alt="" srcset="">
            <div class="pattern"></div>
        </div>

        <main>

            <div class="form-container-full">
                <div class="top-bar">

                    <button onclick="window.location.href = './index.php'">
                        <i class="svg-wrapper">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 448 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                <path
                                    d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z" />
                            </svg>
                        </i>
                    </button>
                    <h1>Manage Account</h1>

                </div>

                <form action="./handlers/user-update.php" method="POST" class="add-events interests-card-container-form"
                    enctype="multipart/form-data">
                    <div class="pop-up-msg hide">
                        <i class="svg-wrapper">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 512 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                <path
                                    d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zm0-384c13.3 0 24 10.7 24 24V264c0 13.3-10.7 24-24 24s-24-10.7-24-24V152c0-13.3 10.7-24 24-24zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z" />
                            </svg>
                        </i>

                        <span>

                        </span>
                    </div>

                    <div class="pop-up-msg loader hide success">
                        <i class="svg-wrapper">
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em"
                                viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                <path
                                    d="M222.7 32.1c5 16.9-4.6 34.8-21.5 39.8C121.8 95.6 64 169.1 64 256c0 106 86 192 192 192s192-86 192-192c0-86.9-57.8-160.4-137.1-184.1c-16.9-5-26.6-22.9-21.5-39.8s22.9-26.6 39.8-21.5C434.9 42.1 512 140 512 256c0 141.4-114.6 256-256 256S0 397.4 0 256C0 140 77.1 42.1 182.9 10.6c16.9-5 34.8 4.6 39.8 21.5z" />
                            </svg>
                        </i>

                        <span>
                            Loading...
                        </span>
                    </div>

                    <img src="./resources/images/user/<?php echo $img ?>" alt="" id="previewImage"
                        style="width: 100px; aspect-ratio:1; object-fit:cover; object-position:center; border-radius:100%;" />
                    <div class="input-container">
                        <span>Image : </span>
                        <div class="input-wrapper">
                            <label for="imageInput" class="input-dialog-box-wrapper">
                                <p id="image-placeholder" class="no-icon">
                                    <?php echo $img ?>
                                </p>

                                <input type="file" id="imageInput"
                                    onchange="previewImageTag(event); setPlaceholder('imageInput','image-placeholder', 'Select account image');"
                                    name="img" accept=".jpg, .jpeg, .png" max="5MB">
                            </label>
                        </div>
                    </div>

                    <div class="input-container">
                        <span>First Name : </span>
                        <div class="input-wrapper">
                            <input type="text" placeholder="Name" name="firstname" value="<?php echo $firstName ?>">
                        </div>
                    </div>

                    <div class="input-container">
                        <span>Last Name : </span>
                        <div class="input-wrapper">
                            <input type="text" placeholder="Name" name="lastname" value="<?php echo $lastName ?>">
                        </div>
                    </div>

                    <div class="input-container">
                        <span>Date : </span>
                        <div class="input-wrapper">

                            <label for="DOB" class="input-dialog-box-wrapper">
                                <p id="date-of-birth-placeholder" class="no-icon">
                                    <?php echo $dob ?>
                                </p>
                                <input value="<?php echo $dob ?>" type="date" name="date" id="DOB"
                                    onchange="setPlaceholder('DOB','date-of-birth-placeholder', 'Date of birth')"
                                    required>
                            </label>
                        </div>
                    </div>

                    <div class="input-container">
                        <span>Contact Number : </span>
                        <div class="input-wrapper">
                            <input type="text" placeholder="Phone" name="phone" value="<?php echo $phone ?>">
                        </div>
                    </div>

                    <div class="input-container">
                        <span>Email : </span>
                        <div class="input-wrapper">
                            <input type="text" placeholder="Email" name="email" value="<?php echo $email ?>">
                        </div>
                    </div>

                    <div class="input-container">
                        <span>Category : </span>
                        <div class="interests-card-container">
                            <?php

                            $user_id = $_SESSION['user_id'];

                            // Query to fetch categories with user interests
                            $query = "SELECT c.id AS category_id, c.name AS category_name, ui.user_id
                  FROM categories AS c
                  LEFT JOIN userinterests AS ui ON c.id = ui.category_id AND ui.user_id = ?";

                            $stmt = $conn->prepare($query);
                            $stmt->bind_param('s', $user_id);
                            $stmt->execute();

                            $result = $stmt->get_result();

                            if ($result->num_rows > 0) {
                                // Output data of each row
                                while ($row = $result->fetch_assoc()) {
                                    $category_id = $row['category_id'];
                                    $category_name = $row['category_name'];
                                    $highlight_class = ($row['user_id'] !== null) ? 'interests-card-active' : '';

                                    echo '<button type="button" class="interests-card ' . $highlight_class . '" onclick="toggleCategory(this)" data-category-id="' . $category_id . '">' . $category_name . '<i class="svg-wrapper svg-wrapper-float"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z" /></svg></i></button>';
                                }
                            }

                            $stmt->close();
                            $conn->close();
                            ?>
                        </div>
                        <input type="hidden" id="selectedCategoriesInput" class="selectedCategoriesInput"
                            name="selectedCategoriesUpdate">
                    </div>


                    <div class="input-container">
                        <span>Location : </span>
                        <div class="input-wrapper">
                            <div class="custom-drop-down">
                                <input type="text" placeholder="Location" name="location"
                                    value="<?php echo $location ?>">
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
                    </div>

                    <div class="input-container">
                        <span>Gender : </span>
                        <div class="input-wrapper">
                            <div class="custom-drop-down">
                                <input type="text" placeholder="Gender ?" name="gender"
                                    value="<?php echo ($gender == 0) ? 'Female' : 'Male'; ?>">

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
                    </div>

                    <div class="button-wrapper">
                        <button class="submit-btn" type="submit" name="updateuser">
                            Update Details
                        </button>
                    </div>


                </form>

                <br>
                <hr>
                <br>
                <form action="./handlers/change-password.php" method="POST"
                    class="change-password interests-card-container-form">
                    <div class="input-container">
                        <span>Old password : </span>
                        <div class="input-wrapper">
                            <input type="password" placeholder="Old password" name="password">
                        </div>
                    </div>

                    <div class="input-container">
                        <span>New password : </span>
                        <div class="input-wrapper">
                            <input type="password" placeholder="New password" name="confirm_password">
                        </div>
                    </div>

                    <div class="button-wrapper">
                        <button class="submit-btn" type="submit" name="changePassword">
                            Change Password
                        </button>
                    </div>
                </form>

            </div>


        </main>

        <?php require "./partials/footer.php" ?>
<?php

$searchTerm = $_GET['search-term'] ?? '';
$date = $_GET['date'] ?? '';
$location = $_GET['location'] ?? '';
$category = $_GET['category'] ?? '';

?>

<div class="search-bar-container">
    <form action="./events.php" method="get">

        <div class="input-wrapper">
            <input type="text" placeholder="Search.." value="<?php echo $searchTerm; ?>" name="search-term">
        </div>

        <div class="input-wrapper">
            <i class="svg-wrapper">
                <svg xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 448 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                    <path
                        d="M128 0c17.7 0 32 14.3 32 32V64H288V32c0-17.7 14.3-32 32-32s32 14.3 32 32V64h48c26.5 0 48 21.5 48 48v48H0V112C0 85.5 21.5 64 48 64H96V32c0-17.7 14.3-32 32-32zM0 192H448V464c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V192zm64 80v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V272c0-8.8-7.2-16-16-16H80c-8.8 0-16 7.2-16 16zm128 0v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V272c0-8.8-7.2-16-16-16H208c-8.8 0-16 7.2-16 16zm144-16c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V272c0-8.8-7.2-16-16-16H336zM64 400v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16H80c-8.8 0-16 7.2-16 16zm144-16c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16H208zm112 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16H336c-8.8 0-16 7.2-16 16z" />
                </svg>
            </i>
            <input name="date" type="date" placeholder="Date" value="<?php echo $date; ?>">
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
                <input name="location" type="text" placeholder="Location" value="<?php echo $location; ?>">
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
                        d="M40 352l48 0c22.1 0 40 17.9 40 40l0 48c0 22.1-17.9 40-40 40l-48 0c-22.1 0-40-17.9-40-40l0-48c0-22.1 17.9-40 40-40zm192 0l48 0c22.1 0 40 17.9 40 40l0 48c0 22.1-17.9 40-40 40l-48 0c-22.1 0-40-17.9-40-40l0-48c0-22.1 17.9-40 40-40zM40 320c-22.1 0-40-17.9-40-40l0-48c0-22.1 17.9-40 40-40l48 0c22.1 0 40 17.9 40 40l0 48c0 22.1-17.9 40-40 40l-48 0zM232 192l48 0c22.1 0 40 17.9 40 40l0 48c0 22.1-17.9 40-40 40l-48 0c-22.1 0-40-17.9-40-40l0-48c0-22.1 17.9-40 40-40zM40 160c-22.1 0-40-17.9-40-40L0 72C0 49.9 17.9 32 40 32l48 0c22.1 0 40 17.9 40 40l0 48c0 22.1-17.9 40-40 40l-48 0zM232 32l48 0c22.1 0 40 17.9 40 40l0 48c0 22.1-17.9 40-40 40l-48 0c-22.1 0-40-17.9-40-40l0-48c0-22.1 17.9-40 40-40z" />
                </svg>
            </i>

            <div class="custom-drop-down">
                <input name="category" type="text" placeholder="Category" value="<?php echo $category; ?>">
                <div class="drop-down-container">
                    <i class="svg-wrapper drop-down-icon">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 320 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                            <path
                                d="M137.4 374.6c12.5 12.5 32.8 12.5 45.3 0l128-128c9.2-9.2 11.9-22.9 6.9-34.9s-16.6-19.8-29.6-19.8L32 192c-12.9 0-24.6 7.8-29.6 19.8s-2.2 25.7 6.9 34.9l128 128z" />
                        </svg>
                    </i>

                    <ul class="drop-down-list hide">
                        <?php

                        $sql = "SELECT * FROM categories";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            // Output data of each row
                            while ($row = $result->fetch_assoc()) {
                                echo '<li>' . $row['name'] . '</li>';
                            }
                        }

                        ?>
                    </ul>
                </div>
            </div>
        </div>

        <button class="submit-btn reset-btn" name="search-submit" type="button"
            onclick="window.location.href = './events.php';">
            Clear
        </button>

        <button class="submit-btn" name="search-submit">
            <i class="svg-wrapper">
                <svg xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 512 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                    <path
                        d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z" />
                </svg>
            </i>
        </button>



    </form>
</div>
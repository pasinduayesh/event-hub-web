<?php require "./partials/header.php" ?>

<main>

    <?php require "./partials/search.php"; ?>

    <div class="card-container-wrapper event-page">

        <div class="card-container card-container-auto">

            <div class="card-slider-top-bar">
                <h1>Events</h1>
            </div>

            <div class="card-wrapper">

                <?php

                $searchTerm = $_GET['search-term'] ?? '';
                $date = $_GET['date'] ?? '';
                $location = $_GET['location'] ?? '';
                $category = $_GET['category'] ?? '';

                // Prepare the base SQL query
                $sql = "SELECT e.id, e.image, e.name, e.location, e.date,e.time, e.tickets_count, GROUP_CONCAT(c.name) AS categories,
                COALESCE((SELECT SUM(quantity) FROM userbookevent WHERE event_id = e.id), 0) AS booked_event_count
                FROM events AS e
                LEFT JOIN eventcategories AS ec ON e.id = ec.event_id 
                LEFT JOIN categories AS c ON ec.category_id = c.id WHERE e.status = 1 AND e.expired = 0";

                // Initialize an array to store the conditions
                $conditions = [];

                // Check if search term is provided
                if (!empty($searchTerm)) {
                    // Add search term condition
                    $conditions[] = "e.name LIKE '%$searchTerm%'";
                }

                // Check if date is provided
                if (!empty($date)) {
                    // Add date condition
                    $conditions[] = "e.date = '$date'";
                }

                // Check if location is provided
                if (!empty($location)) {
                    // Add location condition
                    $conditions[] = "e.location LIKE '%$location%'";
                }

                // Check if category is provided
                if (!empty($category)) {
                    // Add category condition
                    $conditions[] = "c.id = '$category'";
                }

                // Add the conditions to the SQL query if any exist
                if (!empty($conditions)) {
                    $sql .= " AND " . implode(" AND ", $conditions);
                }

                // Add grouping and ordering to the SQL query
                $sql .= " GROUP BY e.id DESC LIMIT 20";

                // Prepare the statement
                $stmt = $conn->prepare($sql);
                $stmt->execute();

                // Bind the result variables
                $stmt->bind_result($id, $image, $name, $location, $date, $time, $tickets, $categories, $booked_event_count);

                // Output buffer
                ob_start();

                $resultsTrue = false;
                // Fetch the results
                while ($stmt->fetch()) {
                    $resultsTrue = true;
                    ?>
                    <div class="card-box">
                        <div class="card">
                            <img src="./uploads/<?php echo $image ?>" alt="">

                            <div class="lines"></div>

                            <div class="content-container">

                                <div class="tickets ft">
                                    <span>
                                        <?php echo $tickets - $booked_event_count ?> left
                                    </span>
                                    <i class="svg-wrapper">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 576 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                            <path
                                                d="M64 64C28.7 64 0 92.7 0 128v64c0 8.8 7.4 15.7 15.7 18.6C34.5 217.1 48 235 48 256s-13.5 38.9-32.3 45.4C7.4 304.3 0 311.2 0 320v64c0 35.3 28.7 64 64 64H512c35.3 0 64-28.7 64-64V320c0-8.8-7.4-15.7-15.7-18.6C541.5 294.9 528 277 528 256s13.5-38.9 32.3-45.4c8.3-2.9 15.7-9.8 15.7-18.6V128c0-35.3-28.7-64-64-64H64zm64 112l0 160c0 8.8 7.2 16 16 16H432c8.8 0 16-7.2 16-16V176c0-8.8-7.2-16-16-16H144c-8.8 0-16 7.2-16 16zM96 160c0-17.7 14.3-32 32-32H448c17.7 0 32 14.3 32 32V352c0 17.7-14.3 32-32 32H128c-17.7 0-32-14.3-32-32V160z" />
                                        </svg>
                                    </i>
                                </div>

                                <h1>
                                    <?php echo $name ?>
                                </h1>


                                <div class="details-container">
                                    <div>
                                        <i class="svg-wrapper">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 384 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                <path
                                                    d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z" />
                                            </svg>
                                        </i>
                                        <span>
                                            <?php echo $location ?>
                                        </span>
                                    </div>

                                    <div>
                                        <i class="svg-wrapper">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 448 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                <path
                                                    d="M128 0c17.7 0 32 14.3 32 32V64H288V32c0-17.7 14.3-32 32-32s32 14.3 32 32V64h48c26.5 0 48 21.5 48 48v48H0V112C0 85.5 21.5 64 48 64H96V32c0-17.7 14.3-32 32-32zM0 192H448V464c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V192zm64 80v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V272c0-8.8-7.2-16-16-16H80c-8.8 0-16 7.2-16 16zm128 0v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V272c0-8.8-7.2-16-16-16H208c-8.8 0-16 7.2-16 16zm144-16c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V272c0-8.8-7.2-16-16-16H336zM64 400v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16H80c-8.8 0-16 7.2-16 16zm144-16c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16H208zm112 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16H336c-8.8 0-16 7.2-16 16z" />
                                            </svg>
                                        </i>

                                        <span>
                                            <?php echo $date ?>
                                        </span>
                                    </div>
                                    <div>
                                        <i class="svg-wrapper">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="1em"
                                                viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                <path
                                                    d="M256 0a256 256 0 1 1 0 512A256 256 0 1 1 256 0zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z" />
                                            </svg>
                                        </i>

                                        <span>
                                            <?php echo $time ?>
                                        </span>
                                    </div>

                                </div>


                                <div class="button-wrapper">
                                    <button
                                        onclick="window.location.href='event.php?event_id=<?php echo $id ?>'">Details</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }

                if (!$resultsTrue) {
                    echo "No results";
                }

                // Get the buffered output
                $output = ob_get_clean();

                // Close the statement
                $stmt->close();

                // Output the buffered HTML
                echo $output;

                $conn->close();
                ?>

            </div>

        </div>

    </div>


</main>

<?php require "./partials/footer.php" ?>
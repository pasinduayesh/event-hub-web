<?php require "./partials/header.php" ?>
<header>

    <img src="./resources/images/root/banner2.png" alt="">

    <h1>
        Event<br>Hub
    </h1>

    <p>
        Create and manage events, browse and book tickets, and promote your events all in one place. Start
        exploring today!
    </p>



</header>

<main>

    <?php require "./partials/search.php" ?>
    <div class="card-container-wrapper">

        <div class="card-container">

            <div class="card-slider-top-bar">
                <h1>Recently Added</h1>
                <div class="controls">
                    <button class="scroll-left">
                        <i class="svg-wrapper">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 320 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                <path
                                    d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l192 192c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L77.3 256 246.6 86.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-192 192z" />
                            </svg>
                        </i>
                    </button>
                    <button class="scroll-right">
                        <i class="svg-wrapper">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 320 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                <path
                                    d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z" />
                            </svg>
                        </i>
                    </button>
                </div>
            </div>

            <div class="card-slider">

                <?php

                // Prepare the statement
                $stmt = $conn->prepare("SELECT 
                e.id, 
                e.image, 
                e.name, 
                e.location, 
                e.date,
                e.time, 
                e.tickets_count,
                e.expired, 
                COALESCE(SUM(ube.quantity), 0) AS total_tickets_booked
            FROM 
                events AS e
            LEFT JOIN 
                userbookevent AS ube ON e.id = ube.event_id
            WHERE 
                e.status = 1
            GROUP BY 
                e.id
            ORDER BY 
                e.id DESC
            LIMIT 10;");
                $stmt->execute();

                // Bind the result variables
                $stmt->bind_result($id, $image, $name, $location, $date, $time, $tickets, $expired, $total_tickets_booked);

                // Output buffer
                ob_start();

                // Fetch the results
                while ($stmt->fetch()) {
                    // Output the card HTML using the fetched variables
                    ?>
                    <div class="card">

                        <?php if ($expired != 0) {
                            echo '<div class="expired">Expired</div>';
                        } ?>

                        <img src="./uploads/<?php echo $image ?>" alt="">

                        <div class="lines"></div>

                        <div class="content-container">

                            <div class="tickets ft">
                                <span>
                                    <?php echo $tickets - $total_tickets_booked ?> left
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

                            <?php if ($expired == 0) { ?>
                                <div class="button-wrapper">
                                    <button
                                        onclick="window.location.href='event.php?event_id=<?php echo $id ?>'">Details</button>
                                </div>

                            <?php } ?>

                        </div>
                    </div>
                    <?php
                }

                // Get the buffered output
                $output = ob_get_clean();

                // Close the statement
                $stmt->close();

                // Output the buffered HTML
                echo $output;

                ?>


            </div>

        </div>

    </div>

    <div class="card-container-wrapper">

        <div class="card-container">

            <div class="card-slider-top-bar">
                <h1>Featured</h1>
                <div class="controls">
                    <button class="scroll-left">
                        <i class="svg-wrapper">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 320 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                <path
                                    d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l192 192c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L77.3 256 246.6 86.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-192 192z" />
                            </svg>
                        </i>
                    </button>
                    <button class="scroll-right">
                        <i class="svg-wrapper">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 320 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                <path
                                    d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z" />
                            </svg>
                        </i>
                    </button>
                </div>
            </div>

            <div class="card-slider">

                <?php

                // Prepare the statement
                $stmt = $conn->prepare("
                SELECT 
                e.id, 
                e.image, 
                e.name, 
                e.location, 
                e.date,
                e.time, 
                e.tickets_count, 
                e.expired, 
                COALESCE(SUM(ube.quantity), 0) AS booked_ticket_count
            FROM 
                userinterests ui
            JOIN 
                eventcategories ec ON ui.category_id = ec.category_id
            JOIN 
                events e ON ec.event_id = e.id
            LEFT JOIN 
                userbookevent ube ON e.id = ube.event_id
            WHERE 
                ui.user_id = ? 
                AND e.status = 1
            GROUP BY 
                e.id
            UNION
            SELECT 
                e.id, 
                e.image, 
                e.name, 
                e.location, 
                e.date,
                e.time, 
                e.tickets_count,
                e.expired, 
                0 AS booked_ticket_count
            FROM 
                events e
            WHERE  
                e.status = 1
                AND e.id NOT IN (
                    SELECT ec.event_id
                    FROM userinterests ui
                    JOIN eventcategories ec ON ui.category_id = ec.category_id
                    WHERE ui.user_id = ?
                )
            ORDER BY 
                expired
            LIMIT 10;
            
            ");

                $stmt->bind_param('ss', $_SESSION['user_id'], $_SESSION['user_id']);
                $stmt->execute();

                // Bind the result variables
                $stmt->bind_result($id, $image, $name, $location, $date, $time, $tickets, $expired, $total_tickets_booked);

                // Output buffer
                ob_start();

                // Fetch the results
                while ($stmt->fetch()) {
                    // Output the card HTML using the fetched variables
                    ?>
                    <div class="card">
                        <?php if ($expired != 0) {
                            echo '<div class="expired">Expired</div>';
                        } ?>
                        <img src="./uploads/<?php echo $image ?>" alt="">

                        <div class="lines"></div>

                        <div class="content-container">

                            <div class="tickets ft">
                                <span>
                                    <?php echo $tickets - $total_tickets_booked ?> left
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


                            <?php if ($expired == 0) { ?>
                                <div class="button-wrapper">
                                    <button
                                        onclick="window.location.href='event.php?event_id=<?php echo $id ?>'">Details</button>
                                </div>

                            <?php } ?>
                        </div>
                    </div>
                    <?php
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
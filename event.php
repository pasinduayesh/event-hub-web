<?php require "./partials/header.php" ?>

<?php

$stmt = $conn->prepare("INSERT IGNORE INTO eventview (user_id, event_id) VALUES (?, ?)");
$stmt->bind_param("ii", $_SESSION['user_id'], $_GET['event_id']);
$stmt->execute();

?>

<main>

    <div class="single-event-container">
        <?php
        // $stmt = $conn->prepare("SELECT e.id, e.image, e.name, e.user_id, e.location, e.date,e.time, e.tickets_count, e.price, e.description, e.venue, COALESCE(SUM(ube.quantity), 0) AS total_tickets_booked
        // FROM events AS e
        // LEFT JOIN userbookevent AS ube ON e.id = ube.event_id
        // WHERE e.id = ? 
        // GROUP BY e.id");
        // $stmt->bind_param('s', $_GET['event_id']);
        // $stmt->execute();
        
        // // Bind the result variables
        // $stmt->bind_result($id, $image, $name, $userid, $location, $date, $time, $tickets, $price, $description, $address, $total_tickets_booked);
        
        $stmt = $conn->prepare("SELECT
            e.id,
            e.image,
            e.name,
            e.user_id,
            e.location,
            e.date,
            e.time,
            e.tickets_count,
            e.price,
            e.description,
            e.venue,
            COALESCE(SUM(ube.quantity), 0) AS total_tickets_booked,
            u.phone,
            u.first_name,
            u.last_name,
            u.email
        FROM events AS e
        LEFT JOIN userbookevent AS ube ON e.id = ube.event_id
        LEFT JOIN users AS u ON e.user_id = u.id
        WHERE e.id = ?
        GROUP BY e.id");
        $stmt->bind_param('s', $_GET['event_id']);
        $stmt->execute();

        // Bind the result variables
        $stmt->bind_result($id, $image, $name, $userid, $location, $date, $time, $tickets, $price, $description, $address, $total_tickets_booked, $contact_number, $first_name, $last_name, $email);

        $stmt->fetch();
        // Output buffer
        ob_start();
        $stmt->fetch();
        ?>
        <div class="pop-up-msg hide">
            <i class="svg-wrapper">
                <svg xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 512 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                    <path
                        d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zm0-384c13.3 0 24 10.7 24 24V264c0 13.3-10.7 24-24 24s-24-10.7-24-24V152c0-13.3 10.7-24 24-24zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z" />
                </svg>
            </i>

            <span>
                Fill all the fields!
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

        <div class="col-1">

            <img src="./uploads/<?php echo $image ?>" alt="">

            <?php if ($_SESSION['user_id'] != $userid) { ?>
                <form action="./handlers/book-event.php" class="book-ticket" method="post">
                    <div class="input-wrapper" style="display : contents;">
                        <input type="number" placeholder="ticket-count" name="ticket-count" value="1" hidden require>
                        <input type="text" hidden name="event_id" value="<?php echo $id ?>">
                        <input type="text" hidden name="event_price" value="<?php echo $price ?>">
                        <input type="text" hidden name="uid" value="<?php echo $_SESSION['user_id'] ?>">
                        <input type="text" hidden name="ename" value="<?php echo $name ?>">
                        <input type="text" hidden name="etime" value="<?php echo $time ?>">
                        <input type="text" hidden name="edate" value="<?php echo $date ?>">
                        <input type="text" hidden name="eaddress" value="<?php echo $address ?>">
                        <input type="text" hidden name="book">
                    </div>
                    <button class="submit-btn" name="book" type="submit">Book Now</button>
                </form>
            <?php } ?>



        </div>

        <div class="col-2">

            <h1>
                <?php echo $name ?>
            </h1>

            <div class="details">

                <p>
                    <i class="svg-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em"
                            viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                            <path
                                d="M64 64C28.7 64 0 92.7 0 128V384c0 35.3 28.7 64 64 64H512c35.3 0 64-28.7 64-64V128c0-35.3-28.7-64-64-64H64zm64 320H64V320c35.3 0 64 28.7 64 64zM64 192V128h64c0 35.3-28.7 64-64 64zM448 384c0-35.3 28.7-64 64-64v64H448zm64-192c-35.3 0-64-28.7-64-64h64v64zM288 160a96 96 0 1 1 0 192 96 96 0 1 1 0-192z" />
                        </svg>
                    </i>
                    Rs.
                    <?php echo $price ?>
                </p>
                <p>
                    <i class="svg-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em"
                            viewBox="0 0 384 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                            <path
                                d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z" />
                        </svg>
                    </i>
                    <?php echo $location ?>
                </p>
                <p>
                    <i class="svg-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em"
                            viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                            <path
                                d="M575.8 255.5c0 18-15 32.1-32 32.1h-32l.7 160.2c0 2.7-.2 5.4-.5 8.1V472c0 22.1-17.9 40-40 40H456c-1.1 0-2.2 0-3.3-.1c-1.4 .1-2.8 .1-4.2 .1H416 392c-22.1 0-40-17.9-40-40V448 384c0-17.7-14.3-32-32-32H256c-17.7 0-32 14.3-32 32v64 24c0 22.1-17.9 40-40 40H160 128.1c-1.5 0-3-.1-4.5-.2c-1.2 .1-2.4 .2-3.6 .2H104c-22.1 0-40-17.9-40-40V360c0-.9 0-1.9 .1-2.8V287.6H32c-18 0-32-14-32-32.1c0-9 3-17 10-24L266.4 8c7-7 15-8 22-8s15 2 21 7L564.8 231.5c8 7 12 15 11 24z" />
                        </svg>
                    </i>
                    <?php echo $address ?>
                </p>
                <p>
                    <i class="svg-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em"
                            viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                            <path
                                d="M128 0c17.7 0 32 14.3 32 32V64H288V32c0-17.7 14.3-32 32-32s32 14.3 32 32V64h48c26.5 0 48 21.5 48 48v48H0V112C0 85.5 21.5 64 48 64H96V32c0-17.7 14.3-32 32-32zM0 192H448V464c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V192zm64 80v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V272c0-8.8-7.2-16-16-16H80c-8.8 0-16 7.2-16 16zm128 0v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V272c0-8.8-7.2-16-16-16H208c-8.8 0-16 7.2-16 16zm144-16c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V272c0-8.8-7.2-16-16-16H336zM64 400v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16H80c-8.8 0-16 7.2-16 16zm144-16c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16H208zm112 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16H336c-8.8 0-16 7.2-16 16z" />
                        </svg>
                    </i>
                    <?php echo $date ?>
                </p>
                <p>
                    <i class="svg-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em"
                            viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                            <path
                                d="M256 0a256 256 0 1 1 0 512A256 256 0 1 1 256 0zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z" />
                        </svg>
                    </i>
                    <?php echo $time ?>
                </p>
                <p>
                    <i class="svg-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512">
                            <path
                                d="M64 64C28.7 64 0 92.7 0 128v64c0 8.8 7.4 15.7 15.7 18.6C34.5 217.1 48 235 48 256s-13.5 38.9-32.3 45.4C7.4 304.3 0 311.2 0 320v64c0 35.3 28.7 64 64 64H512c35.3 0 64-28.7 64-64V320c0-8.8-7.4-15.7-15.7-18.6C541.5 294.9 528 277 528 256s13.5-38.9 32.3-45.4c8.3-2.9 15.7-9.8 15.7-18.6V128c0-35.3-28.7-64-64-64H64zm64 112l0 160c0 8.8 7.2 16 16 16H432c8.8 0 16-7.2 16-16V176c0-8.8-7.2-16-16-16H144c-8.8 0-16 7.2-16 16zM96 160c0-17.7 14.3-32 32-32H448c17.7 0 32 14.3 32 32V352c0 17.7-14.3 32-32 32H128c-17.7 0-32-14.3-32-32V160z" />
                        </svg>
                    </i>
                    <?php echo ($tickets - $total_tickets_booked) ?> tickets available
                </p>

                <p>
                    <i class="svg-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512">
                            <path
                                d="M575.8 255.5c0 18-15 32.1-32 32.1h-32l.7 160.2c.2 35.5-28.5 64.3-64 64.3H128.1c-35.3 0-64-28.7-64-64V287.6H32c-18 0-32-14-32-32.1c0-9 3-17 10-24L266.4 8c7-7 15-8 22-8s15 2 21 7L564.8 231.5c8 7 12 15 11 24zM352 224a64 64 0 1 0 -128 0 64 64 0 1 0 128 0zm-96 96c-44.2 0-80 35.8-80 80c0 8.8 7.2 16 16 16H384c8.8 0 16-7.2 16-16c0-44.2-35.8-80-80-80H256z" />
                        </svg>


                    </i>
                    Event Host :
                    <?php echo $first_name . " " . $last_name ?>
                </p>

                <p>
                    <i class="svg-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512">
                            <path
                                d="M164.9 24.6c-7.7-18.6-28-28.5-47.4-23.2l-88 24C12.1 30.2 0 46 0 64C0 311.4 200.6 512 448 512c18 0 33.8-12.1 38.6-29.5l24-88c5.3-19.4-4.6-39.7-23.2-47.4l-96-40c-16.3-6.8-35.2-2.1-46.3 11.6L304.7 368C234.3 334.7 177.3 277.7 144 207.3L193.3 167c13.7-11.2 18.4-30 11.6-46.3l-40-96z" />
                        </svg>


                    </i>
                    Host Contact :
                    <?php echo $contact_number ?>
                </p>

                <p>
                    <i class="svg-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512">
                            <path
                                d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48H48zM0 176V384c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V176L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z" />
                        </svg>


                    </i>
                    Host Email :
                    <?php echo $email ?>
                </p>
            </div>

            <pre class="description"><?php echo $description;
            $stmt->close(); ?></pre>



        </div>

        <div class="map-container">
            <iframe src="https://maps.google.com/maps?q=<?php echo $address; ?>&output=embed" width="600" height="450"
                style="border:0;" allowfullscreen="" referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>

    </div>


    <div class="card-container-wrapper">

        <div class="card-container">

            <div class="card-slider-top-bar">
                <h1>Related</h1>
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
                // Prepare the statement to fetch related events
                $stmtRelated = $conn->prepare("SELECT e.id, e.image, e.name, e.location, e.date, e.time, e.tickets_count, COALESCE(SUM(ube.quantity), 0) AS total_tickets_booked
    FROM events AS e
    LEFT JOIN userbookevent AS ube ON e.id = ube.event_id
    WHERE e.id != ? AND e.status = 1 AND e.id IN (
        SELECT event_id
        FROM eventcategories
        WHERE category_id IN (
            SELECT category_id
            FROM eventcategories
            WHERE event_id = ?
        )
    )
    GROUP BY e.id
    LIMIT 10");

                $stmtRelated->bind_param('ss', $_GET['event_id'], $_GET['event_id']);
                $stmtRelated->execute();

                // Bind the result variables
                $stmtRelated->bind_result($id, $image, $name, $location, $date, $time, $tickets, $total_tickets_booked);

                // Fetch the related events
                $relatedEvents = [];
                while ($stmtRelated->fetch()) {
                    $relatedEvents[] = [
                        'id' => $id,
                        'image' => $image,
                        'name' => $name,
                        'location' => $location,
                        'date' => $date,
                        'time' => $time,
                        'tickets' => $tickets,
                        'total_tickets_booked' => $total_tickets_booked,
                    ];
                }

                // Close the related events statement
                $stmtRelated->close();

                // Check if there are at least 10 related events
                if (count($relatedEvents) < 10) {
                    // Not enough related events, fetch random events
                    $stmtRandom = $conn->prepare("SELECT id, image, name, location, date, time, tickets_count, 0 AS total_tickets_booked
        FROM events
        WHERE id != ? AND status = 1
        ORDER BY RAND()
        LIMIT " . (10 - count($relatedEvents)));

                    $stmtRandom->bind_param('s', $_GET['event_id']);
                    $stmtRandom->execute();

                    // Bind the result variables
                    $stmtRandom->bind_result($id, $image, $name, $location, $date, $time, $tickets, $total_tickets_booked);

                    // Fetch the random events
                    while ($stmtRandom->fetch()) {
                        $relatedEvents[] = [
                            'id' => $id,
                            'image' => $image,
                            'name' => $name,
                            'location' => $location,
                            'date' => $date,
                            'time' => $time,
                            'tickets' => $tickets,
                            'total_tickets_booked' => $total_tickets_booked,
                        ];
                    }

                    // Close the random events statement
                    $stmtRandom->close();
                }

                // Shuffle the related events to randomize their order
                shuffle($relatedEvents);

                // Output buffer
                ob_start();

                // Loop through the events to display them
                foreach ($relatedEvents as $event) {
                    ?>
                    <div class="card">
                        <img src="./uploads/<?php echo $event['image'] ?>" alt="">
                        <div class="lines"></div>
                        <div class="content-container">
                            <div class="tickets ft">
                                <span>
                                    <?php echo ($event['tickets'] - $event['total_tickets_booked']) ?> left
                                </span>
                                <i class="svg-wrapper">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                        <!-- Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com -->
                                        <path
                                            d="M64 64C28.7 64 0 92.7 0 128v64c0 8.8 7.4 15.7 15.7 18.6C34.5 217.1 48 235 48 256s-13.5 38.9-32.3 45.4C7.4 304.3 0 311.2 0 320v64c0 35.3 28.7 64 64 64H512c35.3 0 64-28.7 64-64V320c0-8.8-7.4-15.7-15.7-18.6C541.5 294.9 528 277 528 256s13.5-38.9 32.3-45.4c8.3-2.9 15.7-9.8 15.7-18.6V128c0-35.3-28.7-64-64-64H64zm64 112l0 160c0 8.8 7.2 16 16 16H432c8.8 0 16-7.2 16-16V176c0-8.8-7.2-16-16-16H144c-8.8 0-16 7.2-16 16zM96 160c0-17.7 14.3-32 32-32H448c17.7 0 32 14.3 32 32V352c0 17.7-14.3 32-32 32H128c-17.7 0-32-14.3-32-32V160z" />
                                    </svg>
                                </i>
                            </div>
                            <h1>
                                <?php echo $event['name'] ?>
                            </h1>
                            <div class="details-container">
                                <div>
                                    <i class="svg-wrapper">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                                            <!-- Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com -->
                                            <path
                                                d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z" />
                                        </svg>
                                    </i>
                                    <span>
                                        <?php echo $event['location'] ?>
                                    </span>
                                </div>
                                <div>
                                    <i class="svg-wrapper">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                            <!-- Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com -->
                                            <path
                                                d="M128 0c17.7 0 32 14.3 32 32V64H288V32c0-17.7 14.3-32 32-32s32 14.3 32 32V64h48c26.5 0 48 21.5 48 48v48H0V112C0 85.5 21.5 64 48 64H96V32c0-17.7 14.3-32 32-32zM0 192H448V464c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V192zm64 80v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V272c0-8.8-7.2-16-16-16H80c-8.8 0-16 7.2-16 16zm128 0v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V272c0-8.8-7.2-16-16-16H208c-8.8 0-16 7.2-16 16zm144-16c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V272c0-8.8-7.2-16-16-16H336zM64 400v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16H80c-8.8 0-16 7.2-16 16zm144-16c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16H208zm112 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16H336c-8.8 0-16 7.2-16 16z" />
                                        </svg>
                                    </i>
                                    <span>
                                        <?php echo $event['date'] ?>
                                    </span>
                                </div>
                                <div>
                                    <i class="svg-wrapper">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512">
                                            <!-- Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com -->
                                            <path
                                                d="M256 0a256 256 0 1 1 0 512A256 256 0 1 1 256 0zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z" />
                                        </svg>
                                    </i>
                                    <span>
                                        <?php echo $event['time'] ?>
                                    </span>
                                </div>
                            </div>
                            <div class="button-wrapper">
                                <button
                                    onclick="window.location.href='event.php?event_id=<?php echo $event['id'] ?>'">Details</button>
                            </div>
                        </div>
                    </div>
                    <?php
                }

                // Get the buffered output
                $output = ob_get_clean();

                // Output the buffered HTML
                echo $output;
                ?>



            </div>

        </div>

    </div>


</main>


<?php require "./partials/footer.php" ?>
<?php require "./partials/header.php" ?>

<main id="invoice">
    <button class="btn-download">download report</button>
    <?php
    $stmt = $conn->prepare("SELECT 
    e.id, 
    e.image, 
    e.name, 
    e.user_id, 
    e.location, 
    e.date, 
    e.tickets_count, 
    e.price, 
    e.description, 
    e.venue, 
    COALESCE(SUM(ube.quantity), 0) AS total_tickets_booked,
    COALESCE(COUNT(ev.id), 0) AS total_views
    FROM events AS e
    LEFT JOIN userbookevent AS ube ON e.id = ube.event_id
    LEFT JOIN eventview AS ev ON e.id = ev.event_id
    WHERE e.id = ?
    GROUP BY e.id");

    $stmt->bind_param('s', $_GET['event_id']);
    $stmt->execute();

    // Bind the result variables
    $stmt->bind_result($id, $image, $name, $userid, $location, $date, $tickets, $price, $description, $address, $total_tickets_booked, $total_views);

    // Output buffer
    ob_start();
    $stmt->fetch();
    $stmt->close();

    if ($userid != $_SESSION['user_id']) {
        header("Location: manage-events.php");
    }

    ?>

    <div class="single-event-container">

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

            <ul>
                <li>
                    Sold Tickets :
                    <?php echo $total_tickets_booked ?>
                </li>

                <li>
                    Total Income :
                    <?php echo $total_tickets_booked * $price ?>
                </li>

                <li>
                    Total Views :
                    <?php echo $total_views ?>
                </li>
            </ul>

        </div>

        <div class="col-2">

            <form action="./handlers/delete-event.php" class="delete-event-form" method="POSt">
                <input type="hidden" name="eventID" value="<?php echo $id ?>">
                <input type="hidden" name="eventName" value="<?php echo $name ?>">
                <input type="text" name="delete-event" hidden>
                <button class="icons" name="delete-event">
                    <i class="svg-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 448 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                            <path
                                d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z" />
                        </svg>
                    </i>
                </button>
            </form>


            <button class="icons" onclick="window.location.href='./update-event.php?id=<?php echo $id ?>'">
                <i class="svg-wrapper">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 512 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                        <path
                            d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z" />
                    </svg>
                </i>
            </button>


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
                            viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                            <path
                                d="M64 64C28.7 64 0 92.7 0 128v64c0 8.8 7.4 15.7 15.7 18.6C34.5 217.1 48 235 48 256s-13.5 38.9-32.3 45.4C7.4 304.3 0 311.2 0 320v64c0 35.3 28.7 64 64 64H512c35.3 0 64-28.7 64-64V320c0-8.8-7.4-15.7-15.7-18.6C541.5 294.9 528 277 528 256s13.5-38.9 32.3-45.4c8.3-2.9 15.7-9.8 15.7-18.6V128c0-35.3-28.7-64-64-64H64zm64 112l0 160c0 8.8 7.2 16 16 16H432c8.8 0 16-7.2 16-16V176c0-8.8-7.2-16-16-16H144c-8.8 0-16 7.2-16 16zM96 160c0-17.7 14.3-32 32-32H448c17.7 0 32 14.3 32 32V352c0 17.7-14.3 32-32 32H128c-17.7 0-32-14.3-32-32V160z" />
                        </svg>
                    </i>
                    <?php echo $tickets ?> tickets available
                </p>
            </div>

            <pre class="description"><?php echo $description; ?></pre>

        </div>

    </div>


    <div class="table-wrapper">

        <table>
            <thead>
                <tr>
                    <th>
                        Name
                    </th>
                    <th>
                        Phone No
                    </th>
                    <th>
                        Email
                    </th>
                </tr>
            </thead>

            <tbody>

                <?php
                $stmt = $conn->prepare("SELECT u.id, u.first_name, u.last_name, u.email, u.phone
                FROM users AS u
                JOIN userbookevent AS ube ON u.id = ube.user_id
                WHERE ube.event_id = ?");
                $stmt->bind_param('s', $_GET['event_id']);
                $stmt->execute();

                // Bind the result variables
                $stmt->bind_result($id, $firstName, $lastName, $email, $phone);

                // Output buffer
                ob_start();

                // Fetch the results
                while ($stmt->fetch()) {
                    // Output the card HTML using the fetched variables
                    ?>
                    <tr>
                        <td>
                            <?php echo $firstName . " " . $lastName ?>
                        </td>
                        <td>
                            <?php echo $phone ?>
                        </td>
                        <td>
                            <?php echo $email ?>
                        </td>
                    </tr>
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






            </tbody>
        </table>

    </div>


</main>

<?php require "./partials/footer.php" ?>
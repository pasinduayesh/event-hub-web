$(document).ready(function () {

    $('nav ul li div.has-sub-menu').click(function () {
        var parentLi = $(this).closest('li');
        var svgWrapper = parentLi.find('span .icon-wrapper svg'); // Get the SVG element inside the icon-wrapper

        if (parentLi.hasClass('hide-sub-menu')) {
            $('nav ul li div.has-sub-menu').closest('li').addClass('hide-sub-menu');
            parentLi.removeClass('hide-sub-menu');

            svgWrapper.html('<path d="M182.6 137.4c-12.5-12.5-32.8-12.5-45.3 0l-128 128c-9.2 9.2-11.9 22.9-6.9 34.9s16.6 19.8 29.6 19.8H288c12.9 0 24.6-7.8 29.6-19.8s2.2-25.7-6.9-34.9l-128-128z"/>');
        } else {
            parentLi.addClass('hide-sub-menu');
            svgWrapper.html(' <path d="M137.4 374.6c12.5 12.5 32.8 12.5 45.3 0l128-128c9.2-9.2 11.9-22.9 6.9-34.9s-16.6-19.8-29.6-19.8L32 192c-12.9 0-24.6 7.8-29.6 19.8s-2.2 25.7 6.9 34.9l128 128z" />');
        }
    });


    $('nav ul li div.nav-element').click(function () {
        $('nav ul li div.nav-element').removeClass('active');
        $(this).addClass('active');
    });


    var currentUrl = window.location.href;

    $('nav ul li a').each(function () {
        var linkUrl = $(this).attr('href').replace(/\/$/, '');

        if (currentUrl.indexOf(linkUrl) > -1) {
            $(this).find('.nav-element').addClass('active');
        }
    });

    $("#categoryForm").on("submit", function (event) {
        event.preventDefault();

        var category = $("input[name='category']").val();
        var action = $("input[name='action']").val();
        var id = action == 'add' ? '' : $("input[name='id']").val();

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4) {
                if (this.status == 200) {
                    var responseData = JSON.parse(this.responseText);
                    if (responseData.success) {
                        if (action === "add") {
                            $("#categoryForm").trigger("reset");
                        }
                        manageCategories('view', "")
                    } else {
                        // Handle error case
                        console.log("Something went wrong");
                    }
                } else {
                    console.log("Something went wrong");
                }
            }
        };

        xmlhttp.open("GET", "./handlers/categories.php?action=" + action + "&name=" + category + "&id=" + id, true);
        xmlhttp.send();
    });

    $('#admin-search').on("keyup", function () {
        filterEvents("", "", $('#admin-search').val());
    });

    $('#event-search').on("keyup", function () {
        filterEvents("", "", $('#event-search').val());
    });

});

//function to filter users
function filterUsers(filterType) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var responseData = JSON.parse(this.responseText);
            showUserData(responseData.data);
        }
    };
    xmlhttp.open("GET", "./handlers/user.php?userSearch&type=" + filterType, true);
    xmlhttp.send();
}

//tracking the state of filter
var filterEvent = 'all';

//function to filter events
function filterEvents(filterType, id, keyWord) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            var responseData = JSON.parse(this.responseText);
            filterEvent = filterType;
            showEventData(responseData.data);
        }
    };
    xmlhttp.open("GET", "./handlers/event.php?uid=" + id + "&type=" + filterType + "&key-word=" + keyWord, true);
    xmlhttp.send();
}

//user crud function
function updateUser(id, action) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4) {
            if (this.status == 200) {
                var responseData = JSON.parse(this.responseText);
                if (responseData.success) {
                    filterUsers('all');
                } else {
                    alert("Something went wrong");
                }
            } else {
                alert("Something went wrong");
            }
        }
    };
    xmlhttp.open("GET", "./handlers/user.php?uid=" + id + "&action=" + action, true);
    xmlhttp.send();
}

//show user data in table
function showUserData(data) {
    // Assuming 'data' is an array of objects with the required fields
    var tableRows = '';

    // Loop through the data and generate table rows
    for (let i = 0; i < data.length; i++) {
        console.log(i);
        var row = data[i];
        var rowClass = row.status === 'approved' ? 'class="approved"' : '';
        var btn;

        if (row.status === 'approved') {
            btn = `
            <button>
                <div class="icon-wrapper">
                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                        <path style=" fill: var(--SUCCESS_COLOR);" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z" />
                    </svg>
                </div>

            </button>
            `
        }
        else {
            btn = `
            <button onclick="if(confirm('Are you sure you want to approve?')) updateUser(${row.id}, 'approve');">
                <div class="icon-wrapper">
                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                        <path style=" fill: var(--DANGER_COLOR);" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM175 175c9.4-9.4 24.6-9.4 33.9 0l47 47 47-47c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-47 47 47 47c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0l-47-47-47 47c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l47-47-47-47c-9.4-9.4-9.4-24.6 0-33.9z" />
                    </svg>
                </div>

            </button>
            `
        }

        // Generate the row HTML
        var rowHtml = `
        <tr ${rowClass}>
            <td><img src="${row.img}" alt=""></td>
            <td>${row.id}</td>
            <td>${row.full_name}</td>
            <td>${row.email}</td>
            <td>${row.phone}</td>
            <!-- Add other columns as needed -->
            <td>
                <button onclick="if(confirm('Are you sure you want to proceed?')) updateUser(${row.id}, 'delete');">
                    <div class="icon-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                            <path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z" />
                        </svg>
                    </div>
                </button>
            </td>
            <td>
                <button onclick="window.location.href = 'user-event.php?uid=${row.id}';">
                    <div class="icon-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                            <path d="M64 64C28.7 64 0 92.7 0 128v64c0 8.8 7.4 15.7 15.7 18.6C34.5 217.1 48 235 48 256s-13.5 38.9-32.3 45.4C7.4 304.3 0 311.2 0 320v64c0 35.3 28.7 64 64 64H512c35.3 0 64-28.7 64-64V320c0-8.8-7.4-15.7-15.7-18.6C541.5 294.9 528 277 528 256s13.5-38.9 32.3-45.4c8.3-2.9 15.7-9.8 15.7-18.6V128c0-35.3-28.7-64-64-64H64zm64 112l0 160c0 8.8 7.2 16 16 16H432c8.8 0 16-7.2 16-16V176c0-8.8-7.2-16-16-16H144c-8.8 0-16 7.2-16 16zM96 160c0-17.7 14.3-32 32-32H448c17.7 0 32 14.3 32 32V352c0 17.7-14.3 32-32 32H128c-17.7 0-32-14.3-32-32V160z" />
                        </svg>
                    </div>
                </button>
            </td>
            <td>
                ${btn}
            </td>
        </tr>
    `;

        tableRows += rowHtml;
    }

    // Replace the content inside the 'content-wrapper' with the updated table rows
    document.getElementById("result-table").innerHTML = tableRows;
}

//show event data in tabe
function showEventData(data) {
    // Assuming 'data' is an array of objects with the required fields
    var tableRows = '';

    // Loop through the data and generate table rows
    for (let i = 0; i < data.length; i++) {
        var row = data[i];
        var rowClass = row.status === 'approved' ? 'class="approved"' : '';

        // Generate the row HTML
        var rowHtml = `
        <tr ${rowClass}>
            <td><img src="${row.img}" alt=""></td>
            <td>${row.id}</td>
            <td>${row.name}</td>
            <!-- Add other columns as needed -->
            <td>
                <button onclick="fetchEvent(${row.uid}, ${row.id}, 'view');">

                    <div class="icon-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                            <path d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                        </svg>
                    </div>

                </button>
            </td>
        </tr>
    `;

        tableRows += rowHtml;
    }

    // Replace the content inside the 'content-wrapper' with the updated table rows
    document.getElementById("result-table").innerHTML = tableRows;
}

//function to fetch event
function fetchEvent(uid, eid, action) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {

        if (this.readyState == 4 && this.status == 200) {
            var responseData = JSON.parse(this.responseText);
            if (action === 'view') {
                // Update the HTML template with retrieved data
                var eventStatusIcon = responseData.data['status'] === 'approved'
                    ? '<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><path style="fill: var(--SUCCESS_COLOR);" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z"/></svg>'
                    : '<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><path style="fill: var(--DANGER_COLOR);" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM175 175c9.4-9.4 24.6-9.4 33.9 0l47 47 47-47c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-47 47 47 47c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0l-47-47-47 47c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l47-47-47-47c-9.4-9.4-9.4-24.6 0-33.9z"/></svg>';

                var eventImage = responseData.data['img'];
                var eid = responseData.data['id'];
                var uid = responseData.data['uid'];
                var email = responseData.data['email'];
                var eventName = responseData.data['name'];
                var eventPrice = responseData.data['price'];
                var eventLocation = responseData.data['location'];
                var eventAddress = responseData.data['address'];
                var eventDate = responseData.data['date'];
                var eventTime = responseData.data['time'];
                var tickets = responseData.data['tickets'];
                var bookedTickets = responseData.data['bookedTickets'];
                var eventAvailableTickets = responseData.data['availableTickets'];
                var eventDescription = responseData.data['description'];

                var eventTemplate = `
                <div class="icon-wrapper status">
                    ${eventStatusIcon}
                </div>
                <div class="col-1">
                    <img src="${eventImage}" alt="${eventName}">
                </div>
                <div class="col-2">
                    <h1>${eventName}</h1>
                    <div class="details">
                        <p><i class="svg-wrapper">
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512">
                                <path d="M64 64C28.7 64 0 92.7 0 128v64c0 8.8 7.4 15.7 15.7 18.6C34.5 217.1 48 235 48 256s-13.5 38.9-32.3 45.4C7.4 304.3 0 311.2 0 320v64c0 35.3 28.7 64 64 64H512c35.3 0 64-28.7 64-64V320c0-8.8-7.4-15.7-15.7-18.6C541.5 294.9 528 277 528 256s13.5-38.9 32.3-45.4c8.3-2.9 15.7-9.8 15.7-18.6V128c0-35.3-28.7-64-64-64H64zm64 112l0 160c0 8.8 7.2 16 16 16H432c8.8 0 16-7.2 16-16V176c0-8.8-7.2-16-16-16H144c-8.8 0-16 7.2-16 16zM96 160c0-17.7 14.3-32 32-32H448c17.7 0 32 14.3 32 32V352c0 17.7-14.3 32-32 32H128c-17.7 0-32-14.3-32-32V160z"/>
                            </svg>
                        </i> Rs. ${eventPrice}</p>
                        <p><i class="svg-wrapper">
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 384 512">
                                <path d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z"/>
                            </svg>
                        </i> ${eventLocation}</p>
                        <p><i class="svg-wrapper">
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512">
                                <path d="M575.8 255.5c0 18-15 32.1-32 32.1h-32l.7 160.2c0 2.7-.2 5.4-.5 8.1V472c0 22.1-17.9 40-40 40H456c-1.1 0-2.2 0-3.3-.1c-1.4 .1-2.8 .1-4.2 .1H416 392c-22.1 0-40-17.9-40-40V448 384c0-17.7-14.3-32-32-32H256c-17.7 0-32 14.3-32 32v64 24c0 22.1-17.9 40-40 40H160 128.1c-1.5 0-3-.1-4.5-.2c-1.2 .1-2.4 .2-3.6 .2H104c-22.1 0-40-17.9-40-40V360c0-.9 0-1.9 .1-2.8V287.6H32c-18 0-32-14-32-32.1c0-9 3-17 10-24L266.4 8c7-7 15-8 22-8s15 2 21 7L564.8 231.5c8 7 12 15 11 24z"/>
                            </svg>
                        </i> ${eventAddress}</p>
                        <p><i class="svg-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48H48zM0 176V384c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V176L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z"/></svg>
                        </i> ${email}</p>
                        <p>
                            <i class="svg-wrapper">
                              <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M128 0c17.7 0 32 14.3 32 32V64H288V32c0-17.7 14.3-32 32-32s32 14.3 32 32V64h48c26.5 0 48 21.5 48 48v48H0V112C0 85.5 21.5 64 48 64H96V32c0-17.7 14.3-32 32-32zM0 192H448V464c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V192zm64 80v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V272c0-8.8-7.2-16-16-16H80c-8.8 0-16 7.2-16 16zm128 0v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V272c0-8.8-7.2-16-16-16H208c-8.8 0-16 7.2-16 16zm144-16c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V272c0-8.8-7.2-16-16-16H336zM64 400v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16H80c-8.8 0-16 7.2-16 16zm144-16c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16H208zm112 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16H336c-8.8 0-16 7.2-16 16z"/></svg>
                            </i> 
                            ${eventDate}
                        </p>
                        <p>
                            <i class="svg-wrapper">
                                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M464 256A208 208 0 1 1 48 256a208 208 0 1 1 416 0zM0 256a256 256 0 1 0 512 0A256 256 0 1 0 0 256zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z"/>
                                </svg>
                            </i> 
                            ${eventTime}
                        </p>
                        <p>
                            <i class="svg-wrapper">
                                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M64 64C28.7 64 0 92.7 0 128v64c0 8.8 7.4 15.7 15.7 18.6C34.5 217.1 48 235 48 256s-13.5 38.9-32.3 45.4C7.4 304.3 0 311.2 0 320v64c0 35.3 28.7 64 64 64H512c35.3 0 64-28.7 64-64V320c0-8.8-7.4-15.7-15.7-18.6C541.5 294.9 528 277 528 256s13.5-38.9 32.3-45.4c8.3-2.9 15.7-9.8 15.7-18.6V128c0-35.3-28.7-64-64-64H64zm64 112l0 160c0 8.8 7.2 16 16 16H432c8.8 0 16-7.2 16-16V176c0-8.8-7.2-16-16-16H144c-8.8 0-16 7.2-16 16zM96 160c0-17.7 14.3-32 32-32H448c17.7 0 32 14.3 32 32V352c0 17.7-14.3 32-32 32H128c-17.7 0-32-14.3-32-32V160z"/></svg>
                            </i> 
                            Issued tickets : ${tickets} 
                        </p>
                        <p>
                            <i class="svg-wrapper">
                                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M64 64C28.7 64 0 92.7 0 128v64c0 8.8 7.4 15.7 15.7 18.6C34.5 217.1 48 235 48 256s-13.5 38.9-32.3 45.4C7.4 304.3 0 311.2 0 320v64c0 35.3 28.7 64 64 64H512c35.3 0 64-28.7 64-64V320c0-8.8-7.4-15.7-15.7-18.6C541.5 294.9 528 277 528 256s13.5-38.9 32.3-45.4c8.3-2.9 15.7-9.8 15.7-18.6V128c0-35.3-28.7-64-64-64H64zm64 112l0 160c0 8.8 7.2 16 16 16H432c8.8 0 16-7.2 16-16V176c0-8.8-7.2-16-16-16H144c-8.8 0-16 7.2-16 16zM96 160c0-17.7 14.3-32 32-32H448c17.7 0 32 14.3 32 32V352c0 17.7-14.3 32-32 32H128c-17.7 0-32-14.3-32-32V160z"/></svg>
                            </i> 
                            Booked tickets : ${bookedTickets} 
                        </p>
                        <p>
                            <i class="svg-wrapper">
                                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M64 64C28.7 64 0 92.7 0 128v64c0 8.8 7.4 15.7 15.7 18.6C34.5 217.1 48 235 48 256s-13.5 38.9-32.3 45.4C7.4 304.3 0 311.2 0 320v64c0 35.3 28.7 64 64 64H512c35.3 0 64-28.7 64-64V320c0-8.8-7.4-15.7-15.7-18.6C541.5 294.9 528 277 528 256s13.5-38.9 32.3-45.4c8.3-2.9 15.7-9.8 15.7-18.6V128c0-35.3-28.7-64-64-64H64zm64 112l0 160c0 8.8 7.2 16 16 16H432c8.8 0 16-7.2 16-16V176c0-8.8-7.2-16-16-16H144c-8.8 0-16 7.2-16 16zM96 160c0-17.7 14.3-32 32-32H448c17.7 0 32 14.3 32 32V352c0 17.7-14.3 32-32 32H128c-17.7 0-32-14.3-32-32V160z"/></svg>
                            </i> 
                            Avilable tickets : ${eventAvailableTickets} 
                        </p>
                    </div>
                    <p>${eventDescription}</p>
                    <div class="button-wrapper">
                    
                        ${responseData.data['status'] === 'approved'
                        ? ``
                        : `<button onclick="if(confirm('Are you sure you want to approve?')) fetchEvent(${uid}, ${eid}, 'approve');">Approve</button>`}
                        <button onclick="if(confirm('Are you sure you want to delete?')) fetchEvent(${uid}, ${eid}, 'delete');">Delete</button>
                    </div>
                </div>
            `;

                document.getElementById("single-event-container").innerHTML = eventTemplate;
            }

            else if (action === 'delete') {
                console.log(responseData);
                document.getElementById("single-event-container").innerHTML = '';
                filterEvents(filterEvent, responseData.uid, "");
            }

            else if (action === 'approve') {
                filterEvents(filterEvent, responseData.uid, "");
                fetchEvent(responseData.uid, responseData.eid, 'view');
            }
        }


    };
    xmlhttp.open("GET", "./handlers/event.php?uid=" + uid + "&eid=" + eid + "&action=" + action, true);
    xmlhttp.send();
}

//manage categories
function manageCategories(action, id) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var responseData = JSON.parse(this.responseText);
            if (action === 'view') {
                showCategories(responseData.data);
            }
            console.log(responseData);
        }
    };
    xmlhttp.open("GET", "./handlers/categories.php?action=" + action + "&id=" + id, true);
    xmlhttp.send();
}

function updateCategoryForm(id, name) {
    var updateForm = `
        <input type="text" placeholder="Category name" name="category" value=${name} required>
        <input type="hidden" name="id" value=${id}>
        <input type="hidden" name="action" value="update" required>
        <button type="submit" style="background-color: var(--SUCCESS_COLOR); color:#fff;">
            update
        </button>
        <button type="button" onclick="addCategoryForm();" style="background-color: var(--DANGER_COLOR); color:#fff;">
            Cancel
        </button>
        `
    document.getElementById("categoryForm").innerHTML = updateForm;
}

function addCategoryForm() {
    var updateForm = `
        <input type="text" placeholder="Category name" name="category" required>
        <input type="hidden" name="action" value="add" required>
        <button type="submit" name="add-category" style="background-color: var(--SUCCESS_COLOR); color:#fff;">
            Add
        </button>
        `
    document.getElementById("categoryForm").innerHTML = updateForm;
}

function showCategories(data) {
    // Assuming 'data' is an array of objects with the required fields
    var tableRows = '';

    // Loop through the data and generate table rows
    for (let i = 0; i < data.length; i++) {
        var row = data[i];
        // Generate the row HTML
        var rowHtml = `
        <tr>
            <td>
                ${row.id}
            </td>

            <td>
            ${row.name}
            </td>
            <td>

                <button onclick="if(confirm('Are you sure you want to proceed?')) window.location.href = 'category.php?cid=${row.id}&delete';">

                    <div class="icon-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512">
                            <!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                            <path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z" />
                        </svg>
                    </div>

                </button>

            </td>
            <td>

            <button onclick="updateCategoryForm('${row.id}','${row.name}');">

                <div class="icon-wrapper">
                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512">
                        <!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                        <path d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z" />
                    </svg>
                </div>

            </button>

        </td>

        </tr>
    `;

        tableRows += rowHtml;
    }

    // Replace the content inside the 'content-wrapper' with the updated table rows
    document.getElementById("result-table").innerHTML = tableRows;
}


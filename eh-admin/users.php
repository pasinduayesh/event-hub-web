<?php require_once './admin_partials/header.php' ?>

<div class="wrapper columns">

    <?php
    require_once './admin_partials/nav.php';
    ?>



    <div class="main">

        <div class="top-bar">


            <button>

                <div class="icon-wrapper">

                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                        <path d="M0 96C0 78.3 14.3 64 32 64H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H416c17.7 0 32 14.3 32 32z" />
                    </svg>

                </div>

            </button>

            <span>
                All Users
            </span>


        </div>

        <div class="main-content">


            <div class="card-wrapper row">

                <div class="search-bar-wrapper">

                    <div>
                        <input type="text" placeholder="Search">
                        <button>
                            <div class="icon-wrapper">
                                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                    <path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z" />
                                </svg>
                            </div>
                        </button>
                    </div>

                </div>

                <div class="filter-bar">

                    <button onclick="filterUsers('approved');">
                        Approved <span></span>
                    </button>

                    <button onclick="filterUsers('unapproved');">
                        Unapproved <span></span>
                    </button>

                    <button onclick="filterUsers('all');">
                        All
                    </button>


                </div>

                <div class="results-table-wrapper">

                    <div class="table-wrapper">

                        <table>

                            <thead>

                                <tr>
                                    <th style="width: 100px;min-width: 100px;max-width: 100px;text-align: center;">

                                    </th>

                                    <th style="min-width: 50px;">
                                        ID
                                    </th>

                                    <th style=" min-width: 100px;max-width: 300px;">
                                        Name
                                    </th>

                                    <th style="min-width: 200px;max-width: 400px;">
                                        Email
                                    </th>

                                    <th>
                                        Phone
                                    </th>

                                    <th>
                                        Delete
                                    </th>

                                    <th>
                                        Events
                                    </th>

                                    <th>
                                        Approval
                                    </th>


                                </tr>

                            </thead>

                            <tbody id="result-table">
                                <script>
                                    document.addEventListener("DOMContentLoaded", function() {
                                        filterUsers('all');
                                    });
                                </script>
                            </tbody>

                        </table>

                    </div>


                </div>

            </div>


        </div>

    </div>

</div>

<?php require_once './admin_partials/footer.php' ?>
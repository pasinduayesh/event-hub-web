<?php require_once './admin_partials/header.php' ?>

<div class="wrapper columns">

    <?php

    require_once './admin_partials/nav.php';

    ?>



    <div class="main">

        <div class="top-bar">


            <button>

                <div class="icon-wrapper">

                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512">
                        <!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                        <path d="M0 96C0 78.3 14.3 64 32 64H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H416c17.7 0 32 14.3 32 32z" />
                    </svg>

                </div>

            </button>

            <span>
                Categories
            </span>


        </div>

        <div class="main-content">


            <div class="card-wrapper row">

                <div class="search-bar-wrapper">

                    <div>
                        <form method="GET" style="display: contents;" id="categoryForm" action="./handlers/categories.php">

                                <input type="text" placeholder="Category name" name="category" required>
                                <input type="hidden" name="action"  value="add" required>
                                <button type="submit" style="background-color: var(--SUCCESS_COLOR); color:#fff;">
                                    Add
                                </button>

                        </form>
                    </div>

                </div>

                <div class="results-table-wrapper">

                    <div class="table-wrapper">

                        <table>

                            <thead>

                                <tr>

                                    <th style="min-width: 50px;">
                                        ID
                                    </th>

                                    <th style=" min-width: 100px;max-width: 300px;">
                                        Name
                                    </th>

                                    <th>
                                        Delete
                                    </th>

                                    <th>
                                        Update
                                    </th>

                                </tr>

                            </thead>

                            <tbody id="result-table">
                                <script>
                                    document.addEventListener("DOMContentLoaded", function() {
                                        manageCategories('view', "");
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
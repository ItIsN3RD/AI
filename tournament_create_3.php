<?php
session_start();
include 'includes/verify_login.php';
include 'includes/verify_stripe.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <head>
        <title>Social - Network, Community and Event Theme</title>

        <!-- Meta Tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="author" content="Webestica.com">
        <meta name="description" content="Bootstrap 5 based Social Media Network and Community Theme">

        <!-- Favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <!-- Google Font -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="stylesheet"
              href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">

        <!-- Plugins CSS -->
        <link rel="stylesheet" type="text/css" href="assets/vendor/font-awesome/css/all.min.css">
        <link rel="stylesheet" type="text/css" href="assets/vendor/bootstrap-icons/bootstrap-icons.css">
        <link rel="stylesheet" type="text/css" href="assets/vendor/choices.js/public/assets/styles/choices.min.css"/>

        <!-- Theme CSS -->
        <link id="style-switch" rel="stylesheet" type="text/css" href="assets/css/style.css">
    </head>
<body>
<?php
include 'includes/header.php';
?>


<!-- **************** MAIN CONTENT START **************** -->
<main>
    <!-- Container START -->
    <div class="container">
        <div class="row justify-content-center align-items-center vh-100 py-5">
            <!-- Main content START -->
            <div class="col-sm-10 col-md-8 col-lg-7 col-xl-6 col-xxl-5">
                <!-- Sign in START -->
                <div class="card card-body text-center p-4 p-sm-5">
                    <!-- Title -->
                    <h3 class="mb-2">When is your tournament?</h3>
                    <!-- Form START -->
                    <form class="mt-sm-4" action="tournament/create_3.php" method="post">
                        <!-- Bootstrap input group with datepicker and button next to each other-->
                        <div class="input-group mb-3">
                            <input id="selected_date" type="date" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                            <textarea id="selected_details" type="text" class="form-control" placeholder="Details"></textarea>
                            <button class="btn btn-outline-secondary" type="button" id="add_date"><i class="bi bi-plus"
                                                                                                     onclick="add_date()"></i>
                            </button>
                        </div>

                        <div id="date_list" class="d-none">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Tournament Date</th>
                                    <th>Details</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>

                        <style>
                            input[type="date"] {
                                width: 9em;
                            }
                        </style>

                        <script>
                            // if the user clicks the add date button, grab text from id="selected_date" and add it to the date_list table
                            function add_date() {
                                var date = document.getElementById("selected_date").value;
                                var details = document.getElementById("selected_details").value;
                                // verify that the date is not empty
                                if (date == "" || details == "") {
                                    return;
                                } else {
                                    document.getElementById("date_list").classList.remove("d-none");
                                    var date_list = document.querySelector("#date_list tbody");
                                    var new_row = date_list.insertRow();
                                    var cell1 = new_row.insertCell(0);
                                    var cell2 = new_row.insertCell(1);
                                    var cell3 = new_row.insertCell(2);

                                    // format date mm/dd/yyyy
                                    var date_parts = date.split("-");
                                    var date_formatted = date_parts[1] + "/" + date_parts[2] + "/" + date_parts[0];
                                    cell1.innerHTML = '<input class="form-control" type="text" name="date[]" value="' + date_formatted + '">';

                                    cell1.style.width = "9em";
                                    cell2.innerHTML = '<textarea class="form-control" name="details[]">' + details + '</textarea>';
                                    cell3.innerHTML = '<button type="button" class="btn btn-danger" onclick="remove_date(this)">x</button>';
                                    cell3.style.width = "0px";
                                    document.getElementById("selected_date").value = "";
                                }
                            }

                            function remove_date(button) {
                                var row = button.parentNode.parentNode; // get the parent row of the button
                                row.parentNode.removeChild(row); // remove the row from the table
                                // if no rows are left, hide the table
                                if (document.querySelector("#date_list tbody").childElementCount == 0) {
                                    document.getElementById("date_list").classList.add("d-none");
                                }
                            }
                        </script>

                        <!-- Button -->
                        <div class="d-grid">
                            <a class="btn btn-md btn-secondary mb-3" href="https://goplaypickleball.app/tournament_create_2.php">Back</a>
                            <button name="submit_step_3" type="submit" class="btn btn-md btn-primary">Next Step</button>
                        </div>
                    </form>


                    <!-- Copyright -->
                    <p class="mb-0 mt-3">©2022 <a target="_blank"
                                                  href="https://goplaypickleball.app/">GoPlayPickleBall.</a> All rights
                        reserved</p>

                    <!-- Form END -->
                </div>
                <!-- Sign in START -->
            </div>
        </div> <!-- Row END -->
    </div>
    <!-- Container END -->


</main>
<!-- **************** MAIN CONTENT END **************** -->

<!-- =======================
JS libraries, plugins and custom scripts -->

<!-- Bootstrap JS -->
<script src="assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

<!-- Vendors -->
<script src="assets/vendor/choices.js/public/assets/scripts/choices.min.js"></script>

<!-- Template Functions -->
<script src="assets/js/functions.js"></script>

</body>
</html>
</body>
</html>

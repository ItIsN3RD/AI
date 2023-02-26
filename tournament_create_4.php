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
                <div class="card card-body text-center p-2">
                    <!-- Title -->
                    <h3 class="mb-2">How much will it cost?</h3>
                    <!-- Form START -->
                    <form class="mt-sm-4" action="tournament/create_4.php" method="post">
                        <!-- Bootstrap input group with datepicker and button next to each other-->
                        <div class="row justify-content-center">
                            <div class="col-md-4">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">$</span>
                                    <input id="selected_price" type="text" class="form-control" placeholder="Price"
                                           aria-label="Price" aria-describedby="button-addon2">
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">Events qty</span>
                                    <input id="selected_qty" type="number" min="1" max="100" value="1" class="form-control"
                                           aria-label="Quantity" aria-describedby="button-addon2">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-primary" type="button" id="button-addon2" onclick="add_price()">+</button>
                            </div>
                        </div>


                        <div id="price_list" class="d-none">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>

                        <script>
                            // if the user clicks the add price button, grab text from id="selected_price" and add it to the price_list table
                            function add_price() {
                                var price = document.getElementById("selected_price").value;
                                var qty = document.getElementById("selected_qty").value;
                                // verify that the price is not empty
                                if (price == "") {
                                    return;
                                } else {
                                    document.getElementById("price_list").classList.remove("d-none");
                                    var price_list = document.querySelector("#price_list tbody");
                                    var row = price_list.insertRow(-1);
                                    var cell1 = row.insertCell(0);
                                    var cell2 = row.insertCell(1);
                                    var cell3 = row.insertCell(2);
                                    cell1.innerHTML = '<div class="input-group"><span class="input-group-text" style="border-bottom-right-radius: 0px; border-top-right-radius: 0px;">$</span><input name="price[]" type="text" class="form-control price-textbox" value="' + price + '"></div>';
                                    cell2.innerHTML = '<input name="detail[]" type="number" class="form-control qty-textbox" value="' + qty + '" min="1" max="100">';
                                    cell3.innerHTML = '<button class="btn btn-danger" type="button" onclick="remove_price(this)">-</button>';
                                    document.getElementById("selected_price").value = "";
                                    document.getElementById("selected_qty").value = "1";
                                }
                            }

                            function remove_price(btn) {
                                var row = btn.parentNode.parentNode; // get the parent row of the button
                                row.parentNode.removeChild(row); // remove the row from the table
                                // if no rows are left, hide the table
                                if (document.querySelector("#price_list tbody").childElementCount == 0) {
                                    document.getElementById("price_list").classList.add("d-none");
                                }
                            }
                        </script>
                        <!-- Button -->
                        <div class="d-grid">
                            <a class="btn btn-md btn-secondary mb-3" href="https://goplaypickleball.app/tournament_create_3.php">Back</a>
                            <button name="submit_step_4" type="submit" class="btn btn-md btn-primary">Next Step</button>
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

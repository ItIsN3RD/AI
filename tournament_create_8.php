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
                    <h3 class="mb-2"> Upload tournament images.</h3>
                    <p style="margin: 0px !important;">Add up to 8 images to your tournament. <a target="_blank" href="https://goplaypickleball.app/upload.php">Click here</a> for help.</p>

                    <img src="" alt="image-preview" id="image-preview" class="img-fluid d-none" style="max-height: 200px;">

                    <!-- Form START -->
                    <form class="mt-sm-4" action="tournament/create_8.php" method="post" enctype="multipart/form-data">
                        <!-- Bootstrap input group with text input and button next to each other-->
                        <table class="table" style="margin-bottom: 0px;">
                            <tbody style="border-bottom: rgba(0,0,0,0);">
                            <tr>
                                <td>
                                    <input type="file" id="image-upload" name="image">
                                </td>
                            </tr>
                            </tbody>
                        </table>

                        <!-- Button -->
                        <div class="d-grid">
                            <a class="btn btn-md btn-secondary mb-3"
                               href="https://goplaypickleball.app/tournament_create_7.php">Back</a>
                            <button name="submit_step_8" type="submit" class="btn btn-md btn-primary">Next Step</button>
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

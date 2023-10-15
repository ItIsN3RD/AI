<?php
session_start();
include 'includes/verify_login.php';
$tournament = "";

// https://goplaypickleball.app/tournament_edit.php?product_id=51
$tournamentId = $_GET['product_id'];

$serverName = getenv('SERVERNAME');
$uid = getenv('UID');
$pwd = getenv('PWD');
$connectionInfo = array("UID" => $uid, "PWD" => $pwd, "Database" => getenv('DATABASE'));
$conn = sqlsrv_connect($serverName, $connectionInfo);

if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}

$sql = "SELECT * FROM tbltournament WHERE tournament_id = ?";
$params = array($tournamentId);
$stmt = sqlsrv_query($conn, $sql, $params);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Fetch the result and store it in the $tournament variable
$tournament = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);

// do a select * from tblclub where club_id = $tournament['club_id'] to grab the club info
$serverName = getenv('SERVERNAME');
$uid = getenv('UID');
$pwd = getenv('PWD');
$connectionInfo = array("UID" => $uid, "PWD" => $pwd, "Database" => getenv('DATABASE'));
$conn = sqlsrv_connect($serverName, $connectionInfo);

if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}

$sql = "SELECT * FROM tblclubs WHERE club_id = ?";
$params = array($tournament['club_id']);
$stmt = sqlsrv_query($conn, $sql, $params);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Fetch the result and store it in the $club variable
$club = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);

// select * from tbluser where userId = $club['ownerid'] to grab the owner info
$serverName = getenv('SERVERNAME');
$uid = getenv('UID');
$pwd = getenv('PWD');
$connectionInfo = array("UID" => $uid, "PWD" => $pwd, "Database" => getenv('DATABASE'));
$conn = sqlsrv_connect($serverName, $connectionInfo);

if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}

$sql = "SELECT * FROM tbluser WHERE userId = ?";
$params = array($club['ownerid']);
$stmt = sqlsrv_query($conn, $sql, $params);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Fetch the result and store it in the $owner variable
$owner = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>GoPlay Pickleball Profile Edit</title>

    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Webestica.com">
    <meta name="description" content="Bootstrap based News, Magazine and Blog Theme">

    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">

    <!-- Plugins CSS -->
    <link rel="stylesheet" type="text/css" href="assets/vendor/font-awesome/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="assets/vendor/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="assets/vendor/choices.js/public/assets/styles/choices.min.css">
    <link rel="stylesheet" type="text/css" href="assets/vendor/dropzone/dist/dropzone.css"/>
    <link rel="stylesheet" type="text/css" href="assets/vendor/flatpickr/dist/flatpickr.css"/>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDrbv_OKiD3gTJlB3K3aYp9N0YI7FDFsKk&libraries=places"></script>

    <!-- Theme CSS -->
    <link id="style-switch" rel="stylesheet" type="text/css" href="assets/css/style.css">
    <?php
    include 'includes/analytics.php';
    ?>
</head>

<body>

<?php
include 'includes/header.php';
?>

<!-- **************** MAIN CONTENT START **************** -->
<main>
    <!-- Container START -->
    <div class="container">
        <div class="row">

            <?php
            include 'includes/left_profile_tile.php';
            ?>

            <!-- Main content START -->
            <div class="col-lg-6 vstack gap-4">
                <!-- Setting Tab content START -->
                <div class="tab-content py-0 mb-0">

                    <!-- Account setting tab START -->
                    <div class="tab-pane show active fade" id="nav-setting-tab-1">
                        <!-- Account settings START -->
                        <div class="card mb-4">

                            <!-- Title START -->
                            <div class="card-header border-0 pb-0">
                                <h1 class="h5 card-title">Edit Tournament</h1>
                                <?php
                                // display error message from url called error
                                if (isset($_GET['error'])) {
                                    echo '<h3 class="text-danger">Error: ' . $_GET['error'] . '</h3>';
                                }

                                ?>
                            </div>
                            <!-- Card header START -->
                            <!-- Card body START -->
                            <div class="card-body">
                                <!-- Form settings START -->
                                <form class="row g-3" action="tournament/edit_beta.php" method="post"
                                      enctype="multipart/form-data">
                                    <div class="card mb-4" style="border: none !important;">
                                        <div class="accordion" id="accountSettingsAccordion">

                                            <!-- Personal Profile -->
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingPersonalProfile">
                                                    <button class="accordion-button" type="button"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#collapsePersonalProfile">
                                                        Selected Club
                                                    </button>
                                                </h2>
                                                <div id="collapsePersonalProfile"
                                                     class="accordion-collapse collapse show">
                                                    <div class="accordion-body">
                                                        <!-- Your form inputs for Personal Profile go here -->
                                                        <!-- Display Name, Full Name, Skill Level, Bio -->
                                                        <!-- Select Groups -->
                                                        <!-- Large button groups (default and split) -->
                                                        <div class="col-sm-6 col-lg-4 mx-auto">
                                                            <div class="card">
                                                                <div id="clubBanner" class="h-80px rounded-top"
                                                                     style="background-image:url(<?php print_r($club['background_image']); ?> ); background-position: center; background-size: cover; background-repeat: no-repeat;"></div>
                                                                <div class="card-body text-center pt-0">
                                                                    <div class="avatar avatar-lg mt-n5 mb-3"><a
                                                                                href="club_details.php?club_id=37"><img
                                                                                    id="clubImage"
                                                                                    class="avatar-img rounded-circle border border-white border-3 bg-white"
                                                                                    src="<?php print_r($club['profileimgurl']); ?>"
                                                                                    alt=""></a></div>
                                                                    <h5 class="mb-0"><a
                                                                                id="clubName"><?php print_r($club['club_name']); ?></a>
                                                                    </h5>
                                                                </div>

                                                                <input type="hidden" name="clubId" id="clubId"
                                                                       value="<?php print_r($tournament['club_id']); ?>"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Basic Information -->
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingBasicInformation">
                                                    <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#collapseBasicInformation">
                                                        Basic Information
                                                    </button>
                                                </h2>
                                                <div id="collapseBasicInformation" class="accordion-collapse collapse">
                                                    <div class="accordion-body">
                                                        <div class="row g-3">
                                                            <div class="col-md-6">
                                                                <label for="Tourament_name" class="form-label">Tournament
                                                                    Name</label>
                                                                <input type="text" class="form-control"
                                                                       id="Tournament_name" name="TournamentName"
                                                                       placeholder="Enter Tournament
                                                                    Name" value="<?php print_r($tournament['tournament_name']); ?>">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="minSkill" class="form-label">Skill
                                                                    Range</label>
                                                                <div class="input-group">
                                                                    <input type="number" class="form-control"
                                                                           id="minSkill"
                                                                           step="0.25" min="0" max="5"
                                                                           placeholder="Min Skill" name="minSkill" value="<?php print_r($tournament['min_skill_level']); ?>">
                                                                    <span class="input-group-text">-</span>
                                                                    <input type="number" class="form-control"
                                                                           id="maxSkill"
                                                                           step="0.25" min="0" max="5"
                                                                           placeholder="Max Skill" name="maxSkill" value="<?php print_r($tournament['max_skill_level']); ?>">
                                                                </div>
                                                            </div>

                                                            <div class="col-12">
                                                                <label for="TournamentIMG" class="form-label">Upload
                                                                    Tournament Image</label>
                                                                <input class="form-control" name="TournamentIMG"
                                                                       type="file" id="TournamentIMG">
                                                            </div>

                                                            <div class="col-12">
                                                                <label for="Tournament_Description" class="form-label">Tournament
                                                                    Description</label>
                                                                <textarea class="form-control"
                                                                          id="Tournament_Description" rows="3"
                                                                          name="Tournament_Description"
                                                                          placeholder="Description (Required)"><?php print_r($tournament['tournament_description']); ?></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Basic Information END -->

                                            <!-- Address Start -->
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingPlayPreferences">
                                                    <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#collapsePlayPreferences">
                                                        Where is the tournament?
                                                    </button>
                                                </h2>
                                                <div id="collapsePlayPreferences" class="accordion-collapse collapse">
                                                    <div class="accordion-body">
                                                        <div class="row g-3">
                                                            <div class="col-md-6 mx-auto">
                                                                <label for="address-input" class="form-label">Tourament
                                                                    Location</label>
                                                                <input type="text" class="form-control"
                                                                       id="address-input" name="address"
                                                                       placeholder="Search for a club, park, or enter an address" value="<?php print_r($tournament['address']); ?>">

                                                                <!-- Live Google Maps Preview Location for address above -->
                                                                <div id="map" class="d-none"
                                                                     style="height: 300px; width: 100%; margin-top: 0.5rem;"></div>

                                                                <script>
                                                                    window.addEventListener('load', function () {
                                                                        const input = document.getElementById('address-input');
                                                                        const map = document.getElementById('map');
                                                                        let iframe = null;
                                                                        let autocomplete;

                                                                        if (input.value.length > 0) {
                                                                            map.classList.remove('d-none');
                                                                        }

                                                                        if (!iframe) {
                                                                            iframe = document.createElement('iframe');
                                                                            iframe.width = '100%';
                                                                            iframe.height = '100%';
                                                                            iframe.frameBorder = 0;
                                                                            iframe.style.border = 0;
                                                                            map.appendChild(iframe);
                                                                        }

                                                                        function initAutocomplete() {
                                                                            autocomplete = new google.maps.places.Autocomplete(input);
                                                                            autocomplete.addListener('place_changed', function () {
                                                                                const place = autocomplete.getPlace();

                                                                                if (!place.geometry || !place.geometry.location) {
                                                                                    return;
                                                                                }

                                                                                map.classList.remove('d-none');
                                                                                iframe.src = `https://maps.google.com/?q=${place.geometry.location.lat()},${place.geometry.location.lng()}&output=embed`;
                                                                            });
                                                                        }

                                                                        input.addEventListener('input', function () {
                                                                            if (input.value.length > 0) {
                                                                                map.classList.remove('d-none');
                                                                            } else {
                                                                                map.classList.add('d-none');
                                                                            }

                                                                            iframe.src = `https://maps.google.com/?q=${input.value}&output=embed`;
                                                                        });

                                                                        initAutocomplete();
                                                                    });
                                                                </script>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Address END -->

                                            <!-- When is your tournament Start -->
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingTournyTime">
                                                    <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#collapseTournyTime">
                                                        When is your tournament?
                                                    </button>
                                                </h2>
                                                <div id="collapseTournyTime" class="accordion-collapse collapse">
                                                    <div class="accordion-body">
                                                        <div class="row g-3">
                                                            <div class="col-sm-2 mx-auto">
                                                                <label class="form-label">Date</label>
                                                                <input id="selected_date" type="text"
                                                                       class="form-control datepicker flatpickr-input active"
                                                                       placeholder="Select date" readonly="readonly"
                                                                       value="<?php // date in chicago time
                                                                       $date = new DateTime("now", new DateTimeZone('America/Chicago'));
                                                                       echo $date->format('m-d-Y');
                                                                       ?>">
                                                            </div>

                                                            <div class="col-sm-2 mx-auto">
                                                                <label class="form-label">Time</label>
                                                                <input id="selected_time" type="text"
                                                                       class="form-control timepicker flatpickr-input"
                                                                       placeholder="Select time" readonly="readonly"
                                                                       value="<?php echo "13:00"; ?>">
                                                            </div>

                                                            <div class="col-md-6 mx-auto">
                                                                <label for="selected_details"
                                                                       class="form-label">Details</label>
                                                                <textarea class="form-control" id="selected_details"
                                                                          rows="3"
                                                                          name="selected_details"
                                                                          placeholder="Details (Required)"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <button id="add_button" class="btn btn-primary-soft ms-auto w-100"
                                                            type="button" onclick="add_date()"
                                                            style="margin-bottom: 1rem;">
                                                        Add Date
                                                    </button>

                                                    <!-- Date List of Date, Time and Details -->
                                                    <div id="date_list" class="d-none">
                                                        <table class="table table-striped">
                                                            <thead>
                                                            <tr>
                                                                <th scope="col">Date</th>
                                                                <th scope="col">Time</th>
                                                                <th scope="col">Details</th>
                                                                <th scope="col"></th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                    <script>
                                                        function add_date() {
                                                            // Get the values from the inputs
                                                            let date = document.getElementById("selected_date").value;
                                                            let time = document.getElementById("selected_time").value;
                                                            let details = document.getElementById("selected_details").value;

                                                            // Check if the values are empty
                                                            if (date === "" || time === "" || details === "") {
                                                                alert("Please fill out all the fields");
                                                                return;
                                                            }

                                                            // Create the table row
                                                            let table = document.getElementById("date_list").getElementsByTagName('tbody')[0];
                                                            let row = table.insertRow();
                                                            let cell1 = row.insertCell(0);
                                                            let cell2 = row.insertCell(1);
                                                            let cell3 = row.insertCell(2);
                                                            let cell4 = row.insertCell(3);

                                                            // Add the values to the row
                                                            cell1.innerHTML = '<input type="text" class="form-control timepicker flatpickr-input" placeholder="Select date" readonly="readonly" name="date[]" value="' + date + '"/>'
                                                            cell2.innerHTML = '<input type="text" class="form-control timepicker flatpickr-input" placeholder="Select time" readonly="readonly" name="time[]" value="' + time + '"/>'
                                                            cell3.innerHTML = '<textarea class="form-control" id="selected_details" rows="3" name="details[]">' + details + '</textarea>'
                                                            cell4.innerHTML = '<button type="button" class="btn btn-danger btn-sm" onclick="remove_date(this)">Remove</button>';

                                                            // Clear the values
                                                            document.getElementById("selected_date").value = "";
                                                            document.getElementById("selected_time").value = "";
                                                            document.getElementById("selected_details").value = "";

                                                            // Show the table
                                                            document.getElementById("date_list").classList.remove("d-none");
                                                        }

                                                        function remove_date(e) {
                                                            // Remove the row
                                                            let row = e.parentNode.parentNode;
                                                            row.parentNode.removeChild(row);

                                                            // Check if there are any rows left
                                                            let table = document.getElementById("date_list").getElementsByTagName('tbody')[0];
                                                            if (table.rows.length === 0) {
                                                                // Hide the table
                                                                document.getElementById("date_list").classList.add("d-none");
                                                            }
                                                        }
                                                    </script>
                                                </div>
                                            </div>
                                            <!-- When is your tournament END -->

                                            <!-- TournyPrice Start -->
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingTournyPrice">
                                                    <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#collapseTournyPrice">
                                                        How much will it cost?
                                                    </button>
                                                </h2>
                                                <div id="collapseTournyPrice" class="accordion-collapse collapse">

                                                    <table class="table" style="margin-bottom: 0px;">
                                                        <tbody style="border-bottom: rgba(0,0,0,0);">
                                                        <tr>
                                                            <td>
                                                                <label for="price"
                                                                       class="form-label">Price</label>
                                                                <div class="input-group"><span class="input-group-text"
                                                                                               style="border-bottom-right-radius: 0px; border-top-right-radius: 0px;">$</span><input
                                                                            step="0.01" value="40"
                                                                            id="selected_price" type="number"
                                                                            class="form-control" placeholder="Price"
                                                                            aria-label="Price"
                                                                            aria-describedby="button-addon2">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <label for="details"
                                                                       class="form-label">Events</label>
                                                                <input id="selected_qty" type="number" min="1" max="100"
                                                                       value="1" class="form-control"
                                                                       aria-label="Quantity"
                                                                       aria-describedby="button-addon2"></td>
                                                            <td>
                                                                <label for="add"
                                                                       class="form-label">Add Price</label>
                                                                <button class="btn btn-primary form-control"
                                                                        type="button"
                                                                        onclick="add_price(this)">+
                                                                </button>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>

                                                    <div id="price_list" class="">
                                                        <table class="table">
                                                            <thead>
                                                            <tr class="d-none">
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
                                                                cell1.innerHTML = '<div class="input-group"><span class="input-group-text" style="border-bottom-right-radius: 0px; border-top-right-radius: 0px;">$</span><input name="price[]" step="0.01" type="number" class="form-control price-textbox" value="' + price + '"></div>';
                                                                cell2.innerHTML = '<input name="detail[]" type="number" class="form-control qty-textbox" value="' + qty + '" min="1" max="100">';
                                                                cell3.innerHTML = '<button class="btn btn-danger" type="button" onclick="remove_price(this)">-</button>';
                                                                document.getElementById("selected_price").value = "40";
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
                                                </div>
                                            </div>
                                        </div>
                                        <!-- TournyPrice END -->

                                        <!-- format Start -->
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingTournyFormat">
                                                <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#collapseTournyFormat">
                                                    What is the format?
                                                </button>
                                            </h2>
                                            <div id="collapseTournyFormat" class="accordion-collapse collapse">
                                                <div class="accordion-body">
                                                    <div class="row">
                                                        <div class="col-sm-4 mx-auto">
                                                            <!-- DROPDOWN -->
                                                            <div class="dropdown text-center">
                                                                <button class="btn btn-primary-soft ms-auto w-100 dropdown-toggle"
                                                                        type="button" id="dropdownMenuButton2"
                                                                        data-bs-toggle="dropdown"
                                                                        aria-expanded="false">
                                                                    View Formats
                                                                </button>
                                                                <ul class="dropdown-menu"
                                                                    aria-labelledby="dropdownMenuButton2">
                                                                    <li><a onclick="updateFormat(this, 1)"
                                                                           style="cursor:pointer;"
                                                                           class="dropdown-item">Single-Elimination</a>
                                                                    </li>
                                                                    <li><a onclick="updateFormat(this, 2)"
                                                                           style="cursor:pointer;"
                                                                           class="dropdown-item">Double-Elimination</a>
                                                                    </li>
                                                                    <li><a onclick="updateFormat(this, 3)"
                                                                           style="cursor:pointer;"
                                                                           class="dropdown-item">Round Robin</a></li>
                                                                    <li><a onclick="updateFormat(this, 4)"
                                                                           style="cursor:pointer;"
                                                                           class="dropdown-item">Pool Play</a></li>
                                                                    <li><a onclick="updateFormat(this, 5)"
                                                                           style="cursor:pointer;"
                                                                           class="dropdown-item">Other</a></li>
                                                                </ul>
                                                                <input type="hidden" name="format" id="format"
                                                                       value=""/>
                                                                <script>
                                                                    function updateFormat(e, number) {
                                                                        // update button text
                                                                        document.getElementById("dropdownMenuButton2").innerHTML = e.innerHTML;

                                                                        // update format
                                                                        document.getElementById("format").value = number;
                                                                    }
                                                                </script>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- format END -->

                                        <!-- Participants Start -->
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingTournyParticipants">
                                                <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#collapseTournyParticipants">
                                                    How many participants?
                                                </button>
                                            </h2>
                                            <div id="collapseTournyParticipants"
                                                 class="accordion-collapse collapse">
                                                <div class="accordion-body">
                                                    <div class="row">
                                                        <div class="col-md-7 mx-auto">
                                                            <div class="card card-body text-center p-4 p-sm-5">
                                                                <!-- Title -->
                                                                <h3 class="mb-2">How many participants?</h3>
                                                                <h6 style="font-weight: normal !important;">Select your
                                                                    events by checking the box, then add the max teams
                                                                    you want for that event.</h6>
                                                                <br>
                                                                <h6 style="font-weight: normal !important;">The max is
                                                                    applied to each division. 16 teams = 16 2.5s, 16
                                                                    3.0s, 16,3.5s etc...</h6>

                                                                <!-- Form START -->
                                                                <script>
                                                                    // when a user clicks on a checkbox, enable the corresponding number of teams input
                                                                    function enableTeams(checkbox, teams) {
                                                                        teams = document.getElementById(teams);
                                                                        if (checkbox.checked) {
                                                                            teams.disabled = false;
                                                                        } else {
                                                                            teams.disabled = true;
                                                                            // reset the value to 0
                                                                            teams.value = 0;
                                                                        }
                                                                    }
                                                                </script>
                                                                <table class="table mb-0">
                                                                    <thead>
                                                                    <tr>
                                                                        <th>Events</th>
                                                                        <th>Max Teams</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <tr>
                                                                        <td>
                                                                            <div class="form-check">
                                                                                <input onclick="enableTeams(this, 'teams1')"
                                                                                       class="form-check-input"
                                                                                       type="checkbox"
                                                                                       value="mens_doubles"
                                                                                       id="checkbox1">
                                                                                <label class="form-check-label"
                                                                                       for="checkbox1">
                                                                                    Mens Doubles
                                                                                </label>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <input type="number" class="form-control"
                                                                                   id="teams1" name="mens_doubles"
                                                                                   min="1"
                                                                                   max="100" value="0" disabled>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <div class="form-check">
                                                                                <input onclick="enableTeams(this, 'teams2')"
                                                                                       class="form-check-input"
                                                                                       type="checkbox"
                                                                                       value="womens_doubles"
                                                                                       id="checkbox2">
                                                                                <label class="form-check-label"
                                                                                       for="checkbox2">
                                                                                    Womens Doubles
                                                                                </label>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <input type="number" class="form-control"
                                                                                   id="teams2" name="womens_doubles"
                                                                                   min="1"
                                                                                   max="100" value="0" disabled>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <div class="form-check">
                                                                                <input onclick="enableTeams(this, 'teams3')"
                                                                                       class="form-check-input"
                                                                                       type="checkbox"
                                                                                       value="mixed_doubles"
                                                                                       id="checkbox3">
                                                                                <label class="form-check-label"
                                                                                       for="checkbox3">
                                                                                    Mixed Doubles
                                                                                </label>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <input type="number" class="form-control"
                                                                                   id="teams3" name="mixed_doubles"
                                                                                   min="1"
                                                                                   max="100" value="0" disabled>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <div class="form-check">
                                                                                <input onclick="enableTeams(this, 'teams4')"
                                                                                       class="form-check-input"
                                                                                       type="checkbox"
                                                                                       value="mens_singles"
                                                                                       id="checkbox4">
                                                                                <label class="form-check-label"
                                                                                       for="checkbox4">
                                                                                    Mens Singles
                                                                                </label>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <input type="number" class="form-control"
                                                                                   id="teams4" name="mens_singles"
                                                                                   min="1"
                                                                                   max="100" value="0" disabled>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <div class="form-check">
                                                                                <input onclick="enableTeams(this, 'teams5')"
                                                                                       class="form-check-input"
                                                                                       type="checkbox"
                                                                                       value="womens_singles"
                                                                                       id="checkbox5">
                                                                                <label class="form-check-label"
                                                                                       for="checkbox5">
                                                                                    Womens Singles
                                                                                </label>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <input type="number" class="form-control"
                                                                                   id="teams5" name="womens_singles"
                                                                                   min="1"
                                                                                   max="100" value="0" disabled>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <div class="form-check">
                                                                                <input onclick="enableTeams(this, 'teams6')"
                                                                                       class="form-check-input"
                                                                                       type="checkbox"
                                                                                       value="mens_skinny_singles"
                                                                                       id="checkbox6">
                                                                                <label class="form-check-label"
                                                                                       for="checkbox6">
                                                                                    Mens Skinny Singles
                                                                                </label>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <input type="number" class="form-control"
                                                                                   id="teams6"
                                                                                   name="mens_skinny_singles" min="1"
                                                                                   max="100" value="0" disabled>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <div class="form-check">
                                                                                <input onclick="enableTeams(this, 'teams7')"
                                                                                       class="form-check-input"
                                                                                       type="checkbox"
                                                                                       value="womens_skinny_singles"
                                                                                       id="checkbox7">
                                                                                <label class="form-check-label"
                                                                                       for="checkbox7">
                                                                                    Womens Skinny Singles
                                                                                </label>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <input type="number" class="form-control"
                                                                                   id="teams7"
                                                                                   name="womens_skinny_singles" min="1"
                                                                                   max="100" value="0" disabled>
                                                                        </td>
                                                                    </tr>
                                                                    <!-- Other -->
                                                                    <tr>
                                                                        <td>
                                                                            <div class="form-check">
                                                                                <input onclick="enableTeams(this, 'other')"
                                                                                       class="form-check-input"
                                                                                       type="checkbox" value="other"
                                                                                       id="checkbox8">
                                                                                <label class="form-check-label"
                                                                                       for="checkbox8">
                                                                                    Other
                                                                                </label>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <input type="number" class="form-control"
                                                                                   id="other" name="other_step_6"
                                                                                   min="1"
                                                                                   max="100" value="0" disabled>
                                                                        </td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Participants END -->

                                        <!-- prize Start -->
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingTournyPrize">
                                                <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#collapseTournyPrize">
                                                    Do you have a prize?
                                                </button>
                                            </h2>
                                            <div id="collapseTournyPrize" class="accordion-collapse collapse">
                                                <div class="accordion-body">
                                                    <table class="table" style="margin-bottom: 0px;">
                                                        <tbody style="border-bottom: rgba(0,0,0,0);">
                                                        <tr>
                                                            <td>
                                                                <label for="prize"
                                                                       class="form-label">Prize</label>
                                                                <input id="selected_prize" type="text"
                                                                       class="form-control"
                                                                       placeholder="Type prize here...">

                                                            </td>

                                                            <td>
                                                                <label for="add"
                                                                       class="form-label">Add Prize</label>
                                                                <button class="btn btn-primary form-control"
                                                                        type="button" onclick="add_prize()">+
                                                                </button>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>

                                                    <div id="prize_list" class="d-none">
                                                        <table class="table">
                                                            <thead>
                                                            <tr>
                                                                <th>Prize(s)</th>
                                                                <th></th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                    <script>
                                                        // if the user clicks the add prize button, grab text from id="selected_prize" and add it to the prize_list table
                                                        function add_prize() {
                                                            var prize = document.getElementById("selected_prize").value;
                                                            // verify that the prize is not empty
                                                            if (prize == "") {
                                                                return;
                                                            } else {
                                                                document.getElementById("prize_list").classList.remove("d-none");
                                                                var prize_list = document.querySelector("#prize_list tbody");
                                                                var new_row = prize_list.insertRow();
                                                                var cell1 = new_row.insertCell(0);
                                                                var cell2 = new_row.insertCell(1);
                                                                cell1.innerHTML = `<input type="text" name="prize[]" class="form-control" value="${prize}" required>`;
                                                                cell2.innerHTML = '<button type="button" class="btn btn-danger" onclick="remove_prize(this)">Remove</button>';
                                                                document.getElementById("selected_prize").value = "";
                                                            }
                                                        }

                                                        function remove_prize(button) {
                                                            var row = button.parentNode.parentNode; // get the parent row of the button
                                                            row.parentNode.removeChild(row); // remove the row from the table
                                                            // if no rows are left, hide the table
                                                            if (document.querySelector("#prize_list tbody").childElementCount == 0) {
                                                                document.getElementById("prize_list").classList.add("d-none");
                                                            }
                                                        }
                                                    </script>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- prize END -->

                                        <!-- Registrations Start -->
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingTournyRegistration">
                                                <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#collapseTournyRegistration">
                                                    Registrations Processing
                                                </button>
                                            </h2>
                                            <div id="collapseTournyRegistration"
                                                 class="accordion-collapse collapse">
                                                <div class="accordion-body">
                                                    <h6 style="font-weight: normal !important;">How are you going to
                                                        handle participants signing
                                                        up?</h6>
                                                    <div class="row">
                                                        <div class="col-sm-4 mx-auto">
                                                            <!-- DROPDOWN -->
                                                            <div class="dropdown text-center">
                                                                <button class="btn btn-primary-soft ms-auto w-100 dropdown-toggle"
                                                                        type="button" id="dropdownMenuButton3"
                                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                                    Select a type
                                                                </button>
                                                                <ul class="dropdown-menu"
                                                                    aria-labelledby="dropdownMenuButton2">
                                                                    <li><a onclick="updateType(this, 1)"
                                                                           style="cursor:pointer;"
                                                                           class="dropdown-item">URL</a></li>
                                                                    <li><a onclick="updateType(this, 2)"
                                                                           style="cursor:pointer;"
                                                                           class="dropdown-item">Phone</a></li>
                                                                    <li><a onclick="updateType(this, 3)"
                                                                           style="cursor:pointer;"
                                                                           class="dropdown-item">Email</a></li>
                                                                </ul>
                                                                <div id="dynamic_register">
                                                                </div>
                                                                <script>
                                                                    function updateType(e, number) {
                                                                        // update button text
                                                                        document.getElementById("dropdownMenuButton3").innerHTML = e.innerHTML;

                                                                        // get dynamic_register element
                                                                        var registerDiv = document.getElementById("dynamic_register");

                                                                        // clear the previous input field
                                                                        registerDiv.innerHTML = '';

                                                                        // add proper input field to dynamic_register based on the selection
                                                                        var inputElement = document.createElement('input');
                                                                        inputElement.className = 'form-control mt-2';

                                                                        // create a hidden input for the number
                                                                        var hiddenInput = document.createElement('input');
                                                                        hiddenInput.type = 'hidden';
                                                                        hiddenInput.name = 'register_type';
                                                                        hiddenInput.value = number;
                                                                        registerDiv.appendChild(hiddenInput);

                                                                        switch (number) {
                                                                            case 1:
                                                                                inputElement.type = 'url';
                                                                                inputElement.placeholder = 'Enter URL';
                                                                                // name of url_input
                                                                                inputElement.name = 'url_input';
                                                                                break;
                                                                            case 2:
                                                                                inputElement.type = 'tel';
                                                                                inputElement.placeholder = 'Enter Phone Number';
                                                                                // name of phone_input
                                                                                inputElement.name = 'phone_input';
                                                                                break;
                                                                            case 3:
                                                                                inputElement.type = 'email';
                                                                                inputElement.placeholder = 'Enter Email Address';
                                                                                // name of email_input
                                                                                inputElement.name = 'email_input';
                                                                                break;
                                                                        }

                                                                        // append the created input to the dynamic_register div
                                                                        registerDiv.appendChild(inputElement);
                                                                    }
                                                                </script>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <!-- prize END -->

                                    </div>
                            </div>
                            <!-- Button  -->
                            <div class="col-12 d-flex justify-content-center">
                                <button type="submit" name="submit" class="btn btn-sm btn-primary mb-0">Save
                                    changes
                                </button>
                            </div>
                            </form>
                            <!-- Settings END -->
                        </div>
                        <!-- Card body END -->
                    </div>
                    <!-- Account settings END -->
                </div>
            </div>
            <!-- Setting Tab content END -->
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
<script src="assets/vendor/dropzone/dist/dropzone.js"></script>
<script src="assets/vendor/flatpickr/dist/flatpickr.min.js"></script>
<script src="assets/vendor/pswmeter/pswmeter.min.js"></script>

<!-- Template Functions -->
<script src="assets/js/functions.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Initialize datepicker
        flatpickr(".datepicker", {
            dateFormat: "m-d-Y"
        });

        // Initialize timepicker in 12-hour format
        flatpickr(".timepicker", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "h:i K",
            time_24hr: false
        });
    });

    // simulate click to get a club loaded by default
    // dropdownMenuButton1 is the id of the dropdown button, so get the first element in the dropdown and then click inside ul > li to anchor tag
    document.addEventListener('DOMContentLoaded', function () {
        // Select the first anchor tag inside the specific dropdown with ID dropdownMenuButton1
        let firstAnchor = document.querySelector('#dropdownMenuButton1 + .dropdown-menu a');

        // Simulate a click on the first anchor tag
        if (firstAnchor) {
            firstAnchor.click();
        }
    });


</script>
</body>

</html>

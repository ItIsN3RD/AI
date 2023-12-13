<?php
session_start();
include 'includes/verify_login.php';

?>

<!DOCTYPE html>
<html lang="en">
<!-- =======================
Head START -->
<?php include 'includes/head.php'; ?>
<!-- =======================
Head END -->
<body>

<!-- =======================
Header START -->
<?php include 'includes/header.php'; ?>
<!-- =======================
Header END -->

<!-- **************** MAIN CONTENT START **************** -->
<script>
    let modalcardID = "";
    let _cardList = "";
</script>
<main>

    <!-- Hero event START -->
    <section class="pt-5 pb-0 position-relative"
             style="background-image: url(assets/images/bg/07.jpg); background-repeat: no-repeat; background-size: cover; background-position: top center;">
        <div class="bg-overlay bg-dark opacity-8"></div>
        <!-- Container START -->
        <div class="container">
            <div class="py-5">
                <div class="row position-relative">
                    <div class="col-lg-9 mx-auto">
                        <div class="text-center">
                            <!-- Title -->
                            <h1 class="text-white">Find cards</h1>
                            <p class="text-white">Let's uncover the best cards online!</p>
                        </div>
                        <div class="mx-auto bg-mode shadow rounded p-4 mt-5">
                            <!-- Form START -->
                            <form>
                                <div class="row g-3">
                                    <div class="btn-toolbar justify-content-center" role="toolbar"
                                         aria-label="Toolbar with button groups">
                                        <!-- Language -->
                                        <div class="btn-group me-2 mb-2" role="group"
                                             aria-label="Second group">
                                            <!-- Card Size -->
                                            <div class="col-sm-2">
                                                <!-- Example single danger button -->
                                                <div class="btn-group">
                                                    <button id="btnlanguage" type="button"
                                                            class="btn btn-primary dropdown-toggle button_category"
                                                            data-bs-toggle="dropdown"
                                                            aria-expanded="false">
                                                        English
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><input type="text" class="form-control"
                                                                   placeholder="Search..."
                                                                   aria-label="SearchLanguage"
                                                                   aria-describedby="basic-SearchLanguage"
                                                                   name="SearchLanguage"
                                                                   oninput="search_language(this)"
                                                                   style="border-radius: 0px;"></li>
                                                        <li>
                                                            <hr class="dropdown-divider">
                                                        </li>
                                                        <div id="languagesearchAble">
                                                            <?php
                                                            // database connection
                                                            $serverName = getenv('SERVERNAME');
                                                            $uid = getenv('UID');
                                                            $pwd = getenv('DB_PWD');
                                                            $connectionInfo = array("UID" => $uid, "PWD" => $pwd, "Database" => getenv('DATABASE'));
                                                            $conn = sqlsrv_connect($serverName, $connectionInfo);

                                                            if ($conn === false) {
                                                                echo "Error in connection.";
                                                                die();
                                                            }

                                                            // select * from tblLanguage
                                                            $sql = "SELECT * FROM tblLanguage";
                                                            $stmt = sqlsrv_query($conn, $sql);
                                                            if ($stmt === false) {
                                                                echo "Error in query execution.";
                                                                die(print_r(sqlsrv_errors(), true));
                                                            }

                                                            // loop through all languages
                                                            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                                                echo "<li><a class='dropdown-item' href='#' onclick='select_language(" . $row['LanguageID'] . ", this)'>" . $row['LanguageName'] . "</a></li>";
                                                            }

                                                            sqlsrv_free_stmt($stmt);
                                                            sqlsrv_close($conn);
                                                            ?>
                                                        </div>
                                                    </ul>
                                                    <input type="text" class="form-control d-none"
                                                           placeholder="Language" aria-label="Language"
                                                           aria-describedby="basic-Language"
                                                           name="language" value="2">
                                                    <script>
                                                        function select_language(id, element) {
                                                            // set input name language to the id
                                                            document.getElementsByName("language")[0].value = id;
                                                            // update btnlanguage text from the id text value
                                                            document.getElementById("btnlanguage").innerHTML = element.innerHTML;
                                                        }

                                                        function search_language(element) {
                                                            var input, filter, ul, li, a, i, txtValue;
                                                            input = element.value;
                                                            filter = input.toUpperCase();
                                                            div = document.getElementById("languagesearchAble");
                                                            li = div.getElementsByTagName("li");

                                                            // Loop through all list items, and hide those who don't match the search query
                                                            for (i = 0; i < li.length; i++) {
                                                                a = li[i].getElementsByTagName("a")[0];
                                                                if (a) {
                                                                    txtValue = a.textContent || a.innerText;
                                                                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                                                        li[i].style.display = "";
                                                                    } else {
                                                                        li[i].style.display = "none";
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    </script>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Card-Size -->
                                        <div class="btn-group me-2 mb-2" role="group"
                                             aria-label="Third group">
                                            <!-- Card Size -->
                                            <div class="col-sm-2">
                                                <!-- Example single danger button -->
                                                <div class="btn-group">
                                                    <button id="btncardsize" type="button"
                                                            class="btn btn-primary dropdown-toggle button_category"
                                                            data-bs-toggle="dropdown"
                                                            aria-expanded="false">
                                                        Card Size
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><input type="text" class="form-control"
                                                                   placeholder="Search..."
                                                                   aria-label="SearchSize"
                                                                   aria-describedby="basic-SearchSize"
                                                                   name="SearchSize"
                                                                   oninput="search_size(this)"
                                                                   style="border-radius: 0px;"></li>
                                                        <li>
                                                            <hr class="dropdown-divider">
                                                        </li>
                                                        <div id="sizesearchAble">
                                                            <?php
                                                            // database connection
                                                            $serverName = getenv('SERVERNAME');
                                                            $uid = getenv('UID');
                                                            $pwd = getenv('DB_PWD');
                                                            $connectionInfo = array("UID" => $uid, "PWD" => $pwd, "Database" => getenv('DATABASE'));
                                                            $conn = sqlsrv_connect($serverName, $connectionInfo);

                                                            if ($conn === false) {
                                                                echo "Error in connection.";
                                                                die();
                                                            }

                                                            // select * from tblSize
                                                            $sql = "SELECT * FROM tblSize";
                                                            $stmt = sqlsrv_query($conn, $sql);
                                                            if ($stmt === false) {
                                                                echo "Error in query execution.";
                                                                die(print_r(sqlsrv_errors(), true));
                                                            }

                                                            // loop through all sizes
                                                            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                                                echo "<li><a class='dropdown-item' href='#' onclick='select_card_size(" . $row['SizeID'] . ", this)'>" . $row['SizeDescription'] . "</a></li>";
                                                            }

                                                            sqlsrv_free_stmt($stmt);
                                                            sqlsrv_close($conn);
                                                            ?>
                                                        </div>
                                                    </ul>
                                                    <input type="text" class="form-control d-none"
                                                           placeholder="Card Size" aria-label="CardSize"
                                                           aria-describedby="basic-CardSize"
                                                           name="cardsize">
                                                    <script>
                                                        function select_card_size(id, element) {
                                                            // set input name cardsize to the id
                                                            document.getElementsByName("cardsize")[0].value = id;
                                                            // update btncardsize text from the id text value
                                                            document.getElementById("btncardsize").innerHTML = element.innerHTML;
                                                        }

                                                        function search_size(element) {
                                                            var input, filter, ul, li, a, i, txtValue;
                                                            input = element.value;
                                                            filter = input.toUpperCase();
                                                            div = document.getElementById("sizesearchAble");
                                                            li = div.getElementsByTagName("li");

                                                            // Loop through all list items, and hide those who don't match the search query
                                                            for (i = 0; i < li.length; i++) {
                                                                a = li[i].getElementsByTagName("a")[0];
                                                                if (a) {
                                                                    txtValue = a.textContent || a.innerText;
                                                                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                                                        li[i].style.display = "";
                                                                    } else {
                                                                        li[i].style.display = "none";
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    </script>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Category -->
                                        <div class="btn-group me-2 mb-2" role="group"
                                             aria-label="Fourth group">
                                            <!-- Main Category -->
                                            <div class="col-sm-2">
                                                <div class="btn-group">
                                                    <button id="btncategory" type="button"
                                                            class="btn btn-primary dropdown-toggle button_category"
                                                            data-bs-toggle="dropdown"
                                                            aria-expanded="false">
                                                        Category
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><input type="text" class="form-control"
                                                                   placeholder="Search..."
                                                                   aria-label="SearchCategory"
                                                                   aria-describedby="basic-SearchCategory"
                                                                   name="SearchCategory"
                                                                   oninput="search_category(this)"
                                                                   style="border-radius: 0px;"></li>
                                                        <li>
                                                            <hr class="dropdown-divider">
                                                        </li>
                                                        <div id="categorysearchAble">
                                                            <?php
                                                            // database connection
                                                            $serverName = getenv('SERVERNAME');
                                                            $uid = getenv('UID');
                                                            $pwd = getenv('DB_PWD');
                                                            $connectionInfo = array("UID" => $uid, "PWD" => $pwd, "Database" => getenv('DATABASE'));
                                                            $conn = sqlsrv_connect($serverName, $connectionInfo);

                                                            if ($conn === false) {
                                                                echo "Error in connection.";
                                                                die();
                                                            }

                                                            // select * from tblSize
                                                            $sql = "SELECT * FROM tblCategory";
                                                            $stmt = sqlsrv_query($conn, $sql);
                                                            if ($stmt === false) {
                                                                echo "Error in query execution.";
                                                                die(print_r(sqlsrv_errors(), true));
                                                            }

                                                            // loop through all sizes
                                                            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                                                echo "<li><a class='dropdown-item' href='#' onclick='select_category(" . $row['CategoryID'] . ", this)'>" . $row['CategoryName'] . "</a></li>";
                                                            }

                                                            sqlsrv_free_stmt($stmt);
                                                            sqlsrv_close($conn);
                                                            ?>
                                                        </div>
                                                    </ul>
                                                    <input type="text" class="form-control d-none"
                                                           placeholder="category" aria-label="Category"
                                                           aria-describedby="basic-Category"
                                                           name="category">
                                                    <script>
                                                        function select_category(id, element) {
                                                            // Reset subcategory
                                                            document.getElementsByName("subcategory")[0].value = "";
                                                            document.getElementById("btnsubcategory").innerHTML = "Sub-Category";

                                                            // set input name cardsize to the id
                                                            document.getElementsByName("category")[0].value = id;
                                                            document.getElementById("btncategory").innerHTML = element.innerHTML;

                                                            // pass which category is selected to a php webhook to get subcategories
                                                            // Send the selected category to the PHP webhook via AJAX
                                                            $.ajax({
                                                                url: 'webhook.php',
                                                                type: 'POST',
                                                                data: {category: id},
                                                                success: function (response) {
                                                                    // Assuming the response is a JSON array of sub-categories
                                                                    var subCategories = JSON.parse(response);
                                                                    var $subCategoryList = $('#subcategorysearchAble'); // The ul or ol element

                                                                    //console.log(subCategories);

                                                                    $subCategoryList.empty(); // Remove old li elements
                                                                    $.each(subCategories, function (index, subCategory) {
                                                                        $subCategoryList.append(
                                                                            $("<li>").append(
                                                                                $("<a>").addClass('dropdown-item')
                                                                                    .attr('href', '#')
                                                                                    .attr('onclick', 'select_subcategory(' + subCategory.id + ', this)')
                                                                                    .text(subCategory.name)
                                                                            )
                                                                        );
                                                                    });
                                                                },
                                                                error: function (xhr, status, error) {
                                                                    console.error("An error occurred: " + error);
                                                                }
                                                            });
                                                        }

                                                        function search_category(element) {
                                                            var input, filter, ul, li, a, i, txtValue;
                                                            input = element.value;
                                                            filter = input.toUpperCase();
                                                            div = document.getElementById("categorysearchAble");
                                                            li = div.getElementsByTagName("li");

                                                            // Loop through all list items, and hide those who don't match the search query
                                                            for (i = 0; i < li.length; i++) {
                                                                a = li[i].getElementsByTagName("a")[0];
                                                                if (a) {
                                                                    txtValue = a.textContent || a.innerText;
                                                                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                                                        li[i].style.display = "";
                                                                    } else {
                                                                        li[i].style.display = "none";
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    </script>
                                                </div>

                                            </div>
                                        </div>
                                        <!-- Sub-Category -->
                                        <div class="btn-group me-2 mb-2" role="group"
                                             aria-label="Fifth group">
                                            <!-- Sub Category -->
                                            <div class="col-sm-2">
                                                <div class="btn-group">
                                                    <button id="btnsubcategory" type="button"
                                                            class="btn btn-primary dropdown-toggle button_category"
                                                            data-bs-toggle="dropdown"
                                                            aria-expanded="false">
                                                        Sub-Category
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><input type="text" class="form-control"
                                                                   placeholder="Search..."
                                                                   aria-label="SearchSubCategory"
                                                                   aria-describedby="basic-SearchSubCategory"
                                                                   name="SearchSubCategory"
                                                                   oninput="search_subcategory(this)"
                                                                   style="border-radius: 0px;"></li>
                                                        <li>
                                                            <hr class="dropdown-divider">
                                                        </li>
                                                        <div id="subcategorysearchAble">

                                                        </div>
                                                    </ul>
                                                    <input type="text" class="form-control d-none"
                                                           placeholder="sub-category"
                                                           aria-label="Category"
                                                           aria-describedby="basic-SubCategory"
                                                           name="subcategory">
                                                    <script>
                                                        function select_subcategory(id, element) {
                                                            // set input name cardsize to the id
                                                            document.getElementsByName("subcategory")[0].value = id;
                                                            // update btnsubcategory text
                                                            document.getElementById("btnsubcategory").innerHTML = element.innerHTML;
                                                        }

                                                        function search_subcategory(element) {
                                                            var input, filter, ul, li, a, i, txtValue;
                                                            input = element.value;
                                                            filter = input.toUpperCase();
                                                            div = document.getElementById("subcategorysearchAble");
                                                            li = div.getElementsByTagName("li");

                                                            // Loop through all list items, and hide those who don't match the search query
                                                            for (i = 0; i < li.length; i++) {
                                                                a = li[i].getElementsByTagName("a")[0];
                                                                if (a) {
                                                                    txtValue = a.textContent || a.innerText;
                                                                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                                                        li[i].style.display = "";
                                                                    } else {
                                                                        li[i].style.display = "none";
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    </script>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Adult-Content -->
                                        <div class="btn-group" role="group" aria-label="Sixth group">
                                            <!-- Adult Content  Yes/No-->
                                            <div class="col-sm-2">
                                                <div class="btn-group">
                                                    <button id="btnadult" type="button"
                                                            class="btn btn-primary dropdown-toggle button_category"
                                                            data-bs-toggle="dropdown"
                                                            aria-expanded="false">
                                                        No
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item" href="#"
                                                               onclick="select_adult(1)">Yes</a></li>
                                                        <li><a class="dropdown-item" href="#"
                                                               onclick="select_adult(0)">No</a></li>
                                                        <li><a class="dropdown-item" href="#" onclick="select_adult(3)">Both</a>
                                                        </li>
                                                    </ul>
                                                    <input type="text" class="form-control d-none"
                                                           aria-label="Adult"
                                                           aria-describedby="basic-Adult"
                                                           name="adult" value="0">
                                                    <script>
                                                        function select_adult(id) {
                                                            // update btnadult text
                                                            if (id == 1) {
                                                                document.getElementById("btnadult").innerHTML = "Yes";
                                                                document.getElementsByName("adult")[0].value = 1;
                                                                console.log(document.getElementsByName("adult")[0].value);
                                                            } else if (id == 0) {
                                                                document.getElementById("btnadult").innerHTML = "No";
                                                                document.getElementsByName("adult")[0].value = 0;
                                                                console.log(document.getElementsByName("adult")[0].value);
                                                            } else {
                                                                document.getElementById("btnadult").innerHTML = "Both";
                                                                document.getElementsByName("adult")[0].value = 3;
                                                                console.log(document.getElementsByName("adult")[0].value);
                                                            }
                                                        }
                                                    </script>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <div class="row align-items-end g-4 justify-content-center">
                                    <div class="col-sm-6 col-lg-3">
                                        <a class="btn btn-primary w-100" href="#" onclick="filter_cards()">Filters
                                            Cards</a>
                                        <script>
                                            function filter_cards() {
                                                // get all the values
                                                var language = document.getElementsByName("language")[0].value;
                                                var cardsize = document.getElementsByName("cardsize")[0].value;
                                                var category = document.getElementsByName("category")[0].value;
                                                var subcategory = document.getElementsByName("subcategory")[0].value;
                                                var adult = document.getElementsByName("adult")[0].value;

                                                // pass these values to a php webhook to get the cards
                                                // Send the selected category to the PHP webhook via AJAX
                                                $.ajax({
                                                    url: 'webhook/CardWebhook_Alpha.php',
                                                    type: 'POST',
                                                    data: {
                                                        language: language,
                                                        cardsize: cardsize,
                                                        category: category,
                                                        subcategory: subcategory,
                                                        adult: adult
                                                    },
                                                    success: function (response) {
                                                        // Assuming the response is a JSON array of cards
                                                        var cards = JSON.parse(response);
                                                        var $cardList = $('#CardList'); // The container element for cards

                                                        _cardList = cards;

                                                        $cardList.empty(); // Remove old card elements
                                                        $.each(cards, function (index, card) {
                                                            // Convert datepublished to a readable format
                                                            var date = new Date(card.datepublished * 1000).toLocaleDateString("en-US");

                                                            // Column div
                                                            var $col = $("<div>").addClass("col-sm-6 col-xl-4");

                                                            // Event card
                                                            var $eventCard = $("<div>").addClass("card h-100");

                                                            // Function to handle the click event
                                                            function handleImageContainerClick(id) {
                                                                modalcardID = id;

                                                                // find id in _cardList, which is a global variable thats a list of all cards
                                                                let modal_card = _cardList.find(card => card.id === modalcardID);

                                                                let currency_symbol = "$";

                                                                // set modal preview images
                                                                document.getElementById("modalPreview1").src = modal_card.preview_1;
                                                                document.getElementById("modalPreview2").src = modal_card.preview_2;
                                                                document.getElementById("modalPreview3").src = modal_card.preview_3;
                                                                document.getElementById("modalPreview4").src = modal_card.preview_4;

                                                                // modalLabelCreateEvents == card name and price
                                                                document.getElementById("modalLabelCreateEvents").innerHTML = modal_card.name + " | " + currency_symbol + modal_card.price;

                                                                // reset carousel to first image
                                                                $('#carouselExampleControls').carousel(0);

                                                                // open modal #modalCreateEvents
                                                                $('#modalCreateEvents').modal('show');
                                                            }

                                                            // Image container
                                                            var $imgContainer = $("<div>").addClass("position-relative").css({
                                                                "cursor": "pointer" // Change the cursor to indicate the item is clickable
                                                            }).on('click', function () {
                                                                handleImageContainerClick(card.id);
                                                            });

                                                            $imgContainer.append(
                                                                $("<img>").addClass("img-fluid rounded-top rounded-bottom").attr("src", card.preview_1).attr("alt", card.name),
                                                                $("<div>").addClass("badge bg-danger text-white mt-2 me-2 position-absolute top-0 end-0").text(card.subcategoryName),
                                                                $("<div>").addClass("badge bg-primary text-white mb-2 ms-2 position-absolute bottom-0 start-0").text(card.categoryName)
                                                            );

                                                            $eventCard.append($imgContainer);

                                                            // Card body
                                                            /*var $cardBody = $("<div>").addClass("card-body position-relative pt-0");
                                                            $cardBody.append(
                                                                $("<a>").addClass("btn btn-xs btn-primary mt-n3").attr("href", "event-details-2.html").text(card.categoryName),
                                                                $("<h6>").addClass("mt-3").html('<a href="event-details-2.html">' + card.name + '</a>'),
                                                                $("<p>").addClass("mb-0 small").html('<i class="bi bi-calendar-check pe-1"></i>' + date),
                                                            );*/

                                                            // Interested button
                                                            /*var $interestedButton = $("<div>").addClass("w-100");
                                                            $interestedButton.append(
                                                                $("<input>").addClass("btn-check d-block").attr("type", "button").attr("id", "Interested" + card.id),
                                                                $("<label>").addClass("btn btn-sm btn-outline-success d-block")
                                                                    .attr("for", "Interested" + card.id)
                                                                    .attr("onclick", "viewCard(" + card.id + ");")
                                                                    .html('<i class="fa-solid fa-binoculars me-1"></i> View')
                                                            );
                                                            $cardBody.append($interestedButton);*/

                                                            // Dropdown (if needed, construct similar to the Interested button)

                                                            //$eventCard.append($cardBody);
                                                            $col.append($eventCard);
                                                            $cardList.append($col); // Append the column to the card list
                                                        });
                                                    },
                                                    error: function (xhr, status, error) {
                                                        console.error("An error occurred: " + error);
                                                    }
                                                });
                                                // cardFooter show
                                                document.getElementById("cardFooter").classList.remove("d-none");
                                            }
                                        </script>
                                    </div>
                                </div>
                            </form>
                            <!-- Form END -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero event END -->

    <section class="pt-5">
        <!-- Container START -->
        <div class="container">


            <div class="row g-4">

                <!-- Main content START -->
                <div class="col-12 vstack gap-4">

                    <!-- Card START -->
                    <div class="card">
                        <!-- Card header START -->
                        <div class="card-header d-sm-flex align-items-center text-center justify-content-sm-between border-0 pb-0">
                            <h2 class="h4 card-title">Discover Cards</h2>

                        </div>
                        <!-- Card header START -->
                        <!-- Card body START -->
                        <div class="card-body">
                            <div id="CardList" class="row g-4">

                            </div>
                        </div>
                        <!-- Card body END -->
                        <!-- Card Footer START -->
                        <div id="cardFooter" class="card-footer d-flex justify-content-end d-none">
                            <button type="button" class="btn btn-primary mx-auto me-2">Prev</button>
                            <button type="button" class="btn btn-primary mx-auto">Next</button>
                        </div>
                        <!-- Card Footer END -->
                    </div>
                    <!-- Card END -->
                </div>

            </div> <!-- Row END -->
        </div>
        <!-- Container END -->
    </section>

</main>
<!-- **************** MAIN CONTENT END **************** -->

<!-- Modal create events START -->
<div class="modal fade" id="modalCreateEvents" tabindex="-1" aria-labelledby="modalLabelCreateEvents"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal feed header START -->
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabelCreateEvents">Card Name</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Modal feed header END -->
            <!-- Modal feed body START -->
            <div class="modal-body">
                <!-- Form START -->
                <form class="row g-4">
                    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img id="modalPreview1" src="" class="d-block w-100" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img id="modalPreview2" src="" class="d-block w-100" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img id="modalPreview3" src="" class="d-block w-100" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img id="modalPreview4" src="" class="d-block w-100" alt="...">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls"
                                data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls"
                                data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>

                </form>
                <!-- Form END -->
            </div>
            <!-- Modal feed body END -->
            <!-- Modal footer -->
            <!-- Button -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger-soft me-2" data-bs-dismiss="modal"> Cancel</button>
                <button id="modal_view_button" type="button" class="btn btn-success-soft" onclick="viewDetails()">View
                    Details
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Modal create events END -->

<!-- =======================
JS libraries, plugins and custom scripts -->

<!-- Bootstrap JS -->
<script src="assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

<!-- Vendors -->
<script src="assets/vendor/dropzone/dist/dropzone.js"></script>
<script src="assets/vendor/flatpickr/dist/flatpickr.min.js"></script>
<script src="assets/vendor/choices.js/public/assets/scripts/choices.min.js"></script>

<style>
    .button_category {
        overflow: hidden;
        max-width: 165px;
        min-width: 165px;
    }
</style>

<!-- Theme Functions -->
<script src="assets/js/functions.js"></script>
<script>
    function viewDetails() {
        window.location.href = "card-details.php?id=" + modalcardID;
    }
</script>
</body>
</html>

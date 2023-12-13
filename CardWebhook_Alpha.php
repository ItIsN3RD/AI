<?php

// CardWebhook.php

// Assume you have a database connection set up
// Include your database connection file or write your database connection code here

// Check if the currency, language, cardsize, category, subcategory, adult data is sent via POST

if (isset($_POST['language']) && isset($_POST['cardsize']) && isset($_POST['category']) && isset($_POST['subcategory']) && isset($_POST['adult'])) {
    $selectedLanguage = $_POST['language']; // this is the language id
    $selectedCardSize = $_POST['cardsize']; // this is the cardsize id
    $selectedCategory = $_POST['category']; // this is the category id
    $selectedSubCategory = $_POST['subcategory']; // this is the subcategory id
    $selectedAdult = $_POST['adult']; // this is 1 or 0 or 3 (3 is both)

    $card = array();

    $serverName = getenv('SERVERNAME');
    $uid = getenv('UID');
    $pwd = getenv('DB_PWD');
    $connectionInfo = array("UID" => $uid, "PWD" => $pwd, "Database" => getenv('DATABASE'));
    $conn = sqlsrv_connect($serverName, $connectionInfo);

    if ($conn === false) {
        echo "Error in connection.";
        die();
    }

    // Initialize the base query
    $tsql = "SELECT * FROM tblCards WHERE 1=1";// 1=1 is always true, acts as a no-operation where condition
    $params = array();

    if (isset($selectedLanguage) && !empty($selectedLanguage)) {
        $tsql .= " AND LanguageID = ?";
        $params[] = $selectedLanguage;
    }

    if (isset($selectedCardSize) && !empty($selectedCardSize)) {
        $tsql .= " AND SizeID = ?";
        $params[] = $selectedCardSize;
    }

    if (isset($selectedCategory) && !empty($selectedCategory)) {
        $tsql .= " AND CategoryID = ?";
        $params[] = $selectedCategory;
    }

    if (isset($selectedSubCategory) && !empty($selectedSubCategory)) {
        $tsql .= " AND SubCategoryID = ?";
        $params[] = $selectedSubCategory;
    }

    // adult is boolean in DB, but we receive a 1,0, or 3 (3 is both)
    if (isset($selectedAdult) && $selectedAdult !== null) {
        if ($selectedAdult == 3) {
            $tsql .= " AND (Adult = 1 OR Adult = 0)";
        } else {
            $tsql .= " AND Adult = ?";
            $params[] = $selectedAdult;
        }
    }

    // Add the ORDER BY clause here, after all WHERE conditions
    $tsql .= " ORDER BY DatePublished DESC";

    // Now $tsql and $params are ready to use in your sqlsrv_query call
    $stmt = sqlsrv_query($conn, $tsql, $params);

    if ($stmt === false) {
        echo "Error in query preparation/execution.\n";
        die();
    }

    // foreach card, add it to the array
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        // find category name
        $tsql2 = "SELECT * FROM tblCategory WHERE CategoryID = ?";
        $params2 = array($row['CategoryID']);
        $stmt2 = sqlsrv_query($conn, $tsql2, $params2);

        if ($stmt2 === false) {
            echo "Error in query preparation/execution.\n";
            die();
        }

        $row2 = sqlsrv_fetch_array($stmt2, SQLSRV_FETCH_ASSOC);
        $categoryName = $row2['CategoryName'];

        sqlsrv_free_stmt($stmt2);

        // select * from tblSubCategory where CategoryID = ?
        $tsql2 = "SELECT * FROM tblSubCategory WHERE SubCategoryID = ?";
        $params2 = array($row['SubCategoryID']);
        $stmt2 = sqlsrv_query($conn, $tsql2, $params2);

        if ($stmt2 === false) {
            echo "Error in query preparation/execution.\n";
            die();
        }

        $row2 = sqlsrv_fetch_array($stmt2, SQLSRV_FETCH_ASSOC);
        $subCategoryName = $row2['SubCategoryName'];

        sqlsrv_free_stmt($stmt2);

        $card[] = array(
            'id' => $row['ID'],
            'name' => $row['CardName'],
            'price' => $row['Price'],
            'pdf' => $row['PDF'],
            'description' => $row['CardDescription'],
            'preview_1' => $row['Preview_1'],
            'preview_2' => $row['Preview_2'],
            'preview_3' => $row['Preview_3'],
            'preview_4' => $row['Preview_4'],
            'languageID' => $row['LanguageID'],
            'sizeID' => $row['SizeID'],
            'categoryID' => $row['CategoryID'],
            'subcategoryID' => $row['SubCategoryID'],
            'categoryName' => $categoryName,
            'subcategoryName' => $subCategoryName,
            'adult' => $row['Adult'],
            'datepublished' => $row['DatePublished']
        );
    }

    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn);

    // Encoding the array to JSON format
    echo json_encode($card);
} else {
    // If the language, cardsize, category, subcategory, adult is not set, you can choose to output an error or an empty array
    echo json_encode(array('error' => 'language, cardsize, category or subcategory selected'));
}

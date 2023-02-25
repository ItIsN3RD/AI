<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit_step_3'])) {
        $tournament_dates = array(); // initialize an empty array to store the tournament dates and details
        foreach ($_POST["date"] as $date) {
            $tournament_dates[] = array("date" => $date);
        }
        $_SESSION['tournament_dates'] = $tournament_dates; // store the tournament dates and details in the session


        $tournament_details = array();
        foreach ($_POST["detail"] as $detail) {
            $tournament_details[] = array("detail" => $detail);
        }
        $_SESSION['tournament_details'] = $tournament_details;

        print_r($_SESSION['tournament_details']);
        die();
        // Redirect to next step
        header('Location: https://goplaypickleball.app/tournament_create_4.php');
        exit;
    }
}
?>

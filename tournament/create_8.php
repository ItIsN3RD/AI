<?php
// start the session
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['submit_step_8'])) {
        // Get the file data
        $file = $_FILES['image']['tmp_name'];
        $filename = $_FILES['image']['name'];

        // Move the uploaded file to the images directory
        $destination = 'C:\home\site\images\\' . $filename;
        if (move_uploaded_file($file, $destination)) {
            echo "File uploaded successfully.";
        } else {
            echo "Error uploading file.";
        }

        die();

        // Redirect to next step
        header('Location: https://goplaypickleball.app/tournament/tournament_create_complete.php');
        exit;
    }
}
?>

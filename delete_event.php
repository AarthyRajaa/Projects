<?php
// delete_event.php

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $eventId = $_GET["id"];

    // Database connection parameters
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "diary";

    // Create a connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Delete the event from the database
    $sql = "DELETE FROM events2 WHERE id = $eventId";
    $conn->query($sql);


    

    // Close the database connection
    $conn->close();
}else {
    echo "Invalid request.";
}
?>

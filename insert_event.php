<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

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

    // Get user input
    $date = $_POST["eventDate"];
    $time = $_POST["eventTime"];
    $subject = $_POST["eventSubject"];
    $description = $_POST["eventDescription"];


    // Insert data into the database
    $sql = "INSERT INTO events2 (date, time, description, subject) VALUES ('$date', '$time', '$description', '$subject')";

    if ($conn->query($sql) === TRUE) {
        echo '<script>alert("Events stored successfully.");</script>';
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    header('Location: calendar.html?event_added=true');
    exit();
    // Close the database connection
    $conn->close();

}
?>
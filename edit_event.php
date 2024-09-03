<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Add your head content here -->
    <title>Edit Event</title>
    <style>
        /* Add your CSS styles for the edit page here */
    </style>
</head>

<body>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
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

        // Get the event ID from the URL parameter
        $eventId = $_GET["id"];

        // Fetch event details from the database
        $sql = "SELECT id,date,time,description,subject FROM events2 WHERE id = '$eventId'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // Display a form with current event details for editing
            echo "<form method='post' action='update.html'>
                    <input type='hidden' name='eventId' value='{$eventId}'>
                    <label for='eventDate'>Select Date:</label>
                    <input type='date' id='eventDate' name='eventDate' value='{$row['date']}'>
                    <br>
                    <input type='hidden' name='eventId' value='{$eventId}'>
                    <label for='eventTime'>Select Time:</label>
                    <input type='time' id='eventTime' name='eventTime' value='{$row['time']}'>
                    <br>
                    <input type='hidden' name='eventId' value='{$eventId}'>
                    <label for='eventSubject'>Event Subject:</label>
                    <input type='text' id='eventSubject' name='eventSubject' value='{$row['Subject']}'>
                    <br>
                    <input type='hidden' name='eventId' value='{$eventId}'>
                    <label for='eventDescription'>Event Description:</label>
                    <input type='text' id='eventDescription' name='eventDescription' value='{$row['description']}'>
                    <br>
                    <button type='submit'>Update Changes</button>
                </form>";
        } else {
            echo "Event not found.";
        }

        // Close the database connection
        $conn->close();
    } else {
        // Redirect to the calendar page if accessed without proper parameters
        header("Location: calendar.html");
        exit();
    }
    ?>
</body>

</html>

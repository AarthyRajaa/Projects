<?php
// Retrieve the event ID from the URL parameter
$eventId = isset($_GET['id']) ? intval($_GET['id']) : 0;

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

// Fetch data for the specific event
$sql = "SELECT * FROM events2 WHERE id = $eventId";
$result = $conn->query($sql);

// Check if the event exists
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $eventDate = $row["date"];
    $eventTime = $row["time"];
    $eventDescription = $row["description"];
} else {
    // Redirect to an error page or handle the situation as needed
    header("Location: error.html");
    exit();
}
 
// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Sharing Details</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1020px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f4c4ea;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 15px;
            max-height: 800px;
        }

        h2 {
            color: #333;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Details</h2>
        <p>Date: <?php echo $eventDate; ?></p>
        <p>Time: <?php echo $eventTime; ?></p>
        <p>Description: <?php echo $eventDescription; ?></p>
    </div>

</body>

</html>

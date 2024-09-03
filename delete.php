<?php
$username = 'root';
$password = '';
$database = 'diary';
$host = 'localhost';
$mysqli = new mysqli($host, $username, $password, $database);

// Connect to the database (similar to your existing code)
$mysqli = new mysqli($host, $username, $password, $database);

// Check for connections
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete the row with the specified ID
    $sql = "DELETE FROM personal1 WHERE id = $id";
    $result = $mysqli->query($sql);

    // Check if the delete operation was successful
    if ($result) {
        echo '<script>alert("Record deleted!");history.back();</script>';
        exit();
    } else {
        echo "Error deleting record: " . $mysqli->error;
    }
}

// Close the database connection
$mysqli->close();
?>

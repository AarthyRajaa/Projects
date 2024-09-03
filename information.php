<?php
error_reporting(0);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $host = "localhost";
    $dbname = "diary";
    $username = "root";
    $password = "";
    $connect = mysqli_connect($host, $username, $password, $dbname);

    if (mysqli_connect_error()) {
        die("Connection error: " . mysqli_connect_error());
    }

    $name = $_POST["name"];
    $address = $_POST["address"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $category = $_POST["category"];

    $sql = "INSERT INTO personal (name, address, phone_number, email_id, category) VALUES (?, ?, ?, ?, ?)";

    $stmt = mysqli_stmt_init($connect);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        die(mysqli_error($connect));
    }

    mysqli_stmt_bind_param($stmt, "sssss", $name, $address, $phone, $email, $category);

    if (mysqli_stmt_execute($stmt)) {
        echo "Record Saved";
    } else {
        echo "Error: " . mysqli_error($connect);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($connect);
}
?>

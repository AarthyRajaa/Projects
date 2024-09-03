<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

// Include database connection code
$username = 'root';
$password = '';
$database = 'diary';
$host = 'localhost';
$mysqli = new mysqli($host, $username, $password, $database);

// Checking for connections
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

if (isset($_POST["sendEvent"])) {
    $mail = new PHPMailer(true);

    // Set SMTP configuration
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'aarthy2003r@gmail.com'; // Replace with your Gmail username
    $mail->Password = 'drxyjodzsfbxqrmw'; // Replace with your Gmail password
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    // Set sender email address
    $mail->setFrom('aarthy2003r@gmail.com', 'Aarthy'); // Replace with your name and Gmail address

    // Get selected contacts' details from the form
    $selectedContacts = explode(',', $_POST['selectedContacts']);

    // Get event details from the form
    $eventDate = $_POST['date'];
    $eventTime = $_POST['time'];
    $eventSubject = $_POST['subject'];
    $eventDescription = $_POST['description'];

    foreach ($selectedContacts as $contactID) {
        // Fetch contact details from the database
        $sqlContact = "SELECT * FROM personal WHERE id = $contactID";
        $resultContact = $mysqli->query($sqlContact);
        $contactDetails = $resultContact->fetch_assoc();

        // Set recipient email address
        $mail->addAddress($contactDetails['email_id'], $contactDetails['name']);

        // Set email subject and body
        $subject = "$eventSubject";
        $message = "You are invited to an event on $eventDate at $eventTime. <br>Description:<br> $eventDescription";

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;

        // Send email
        try {
            $mail->send();
            echo "Email sent to " . $contactDetails['email_id'] . "\n";
        } catch (Exception $e) {
            echo "Email sending failed. Error: " . $mail->ErrorInfo;
        }

        // Clear all recipients for the next iteration
        $mail->clearAddresses();
    }

    // Display alert and redirect after sending emails
    echo "<script>alert('Emails sent successfully!'); window.location.href = 'calendar.html';</script>";
}
?>

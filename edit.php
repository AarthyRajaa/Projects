<?php
$username = 'root';
$password = '';
$database = 'diary';
$host = 'localhost';
$mysqli = new mysqli($host, $username, $password, $database);




// Check for connections
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

// Check if the form is submitted for updating data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $name = $_POST["name"];
    $address = $_POST["address"];
    $phone_number = $_POST["phone_number"];
    $email_id = $_POST["email_id"];
    $category = $_POST["category"];

    // Update the data in the database
    $sql = "UPDATE personal SET 
            name = '$name',
            address = '$address',
            phone_number = '$phone_number',
            email_id = '$email_id',
            category = '$category'
            WHERE id = $id";

if ($mysqli->query($sql)) {
    echo '<script>alert("Record updated Successfully"); window.location.href = "index.html";</script>';
    exit();
    } else {
        echo "Error updating record: " . $mysqli->error;
    }
}

// Fetch data for the specified ID
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch data for the specified ID
    $sql = "SELECT * FROM personal WHERE id = $id";
    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    }
}

// Close the database connection
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit User Details</title>
    <!-- Add your styles here -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
    
        .container {
            max-width: 650px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f4c4ea;
           /* background-color: #add8e6;*/
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 15px; /* Add border-radius for curved edges */
        }
    
        form {
            display: grid;
            gap: 10px;
        }
    
        label {
            font-weight: bold;
        }
    
        input,
        select,
        button {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 10px; /* Add border-radius for curved edges */
        }
    
        small {
            color: #888;
        }
    
        .extra-category-container {
            display: grid;
            gap: 10px;
        }
    </style>
</head>

<body>
<a href="index.html" style="position: absolute; top: 10px; left: 10px; text-decoration: none; color: #000;">
        <button style="padding: 8px; background-color: #ccc; border: none; cursor: pointer;">Back</button>
      </a>

    <!-- Add your HTML form here for editing data -->
    <div class="container">
    <h2 ><svg xmlns="http://www.w3.org/2000/svg" width="20" height="18" fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16">
  <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001m-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708l-1.585-1.585z"/>
</svg> Edit User Details</h2>
    <form method="post" action="">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        <label for="name">Name:</label>
        <input type="text" name="name" value="<?php echo $row["name"]; ?>"><br>

        <label for="address">Address:</label>
        <input type="text" name="address" value="<?php echo $row["address"]; ?>"><br>

        <label for="phone_number">Phone number:</label>
        <input type="tel" name="phone_number" value="<?php echo $row["phone_number"]; ?>"><br>

        <label for="email_id">Email ID:</label>
        <input type="text" name="email_id" value="<?php echo $row["email_id"]; ?>"><br>

        <label for="category">Category:</label>
        <input type="text" name="category" value="<?php echo $row["category"]; ?>"><br>

        <input type="submit" value="Update">
        
    </form>
    </div>
</body>

</html>

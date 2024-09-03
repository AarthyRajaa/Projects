<?php
$username = 'root';
$password = '';
$database = 'diary';
$host = 'localhost';
$mysqli = new mysqli($host, $username, $password, $database);

// Checking for connections
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}
// Fetch data for the specific event
$eventId = isset($_GET['eventId']) ? $_GET['eventId'] : null;

// Fetch data for the specific event
if ($eventId !== null) {
    $sql = "SELECT * FROM events2 WHERE id = $eventId";
    $result = $mysqli->query($sql);
}

// Fetch data from the database
$sql = "SELECT * FROM personal";
$result = $mysqli->query($sql);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['sendEvent'])) {
    $selectedContacts = isset($_POST['contact']) ? $_POST['contact'] : [];

    // Fetch details of selected contacts from the database
    $selectedContactsDetails = [];
    foreach ($selectedContacts as $contactID) {
        $sqlContact = "SELECT * FROM personal WHERE id = $contactID";
        $resultContact = $mysqli->query($sqlContact);
        $contactDetails = $resultContact->fetch_assoc();
        $selectedContactsDetails[] = $contactDetails;
    }
    // Log the event sharing activity (you can replace this with your specific logging mechanism)
    foreach ($selectedContactsDetails as $contact) {
        echo "Event selected for sharing with contact ID: " . $contact['id'] . "\n";
    }
}

// Handle search filter
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['search_column']) && isset($_GET['search_value'])) {
    $search_column = $_GET['search_column'];
    $search_value = $_GET['search_value'];

    // SQL query to select filtered data from the database
    $sql = "SELECT * FROM personal WHERE $search_column LIKE '%$search_value%'";
    $result = $mysqli->query($sql);
}
// Fetch distinct categories from the database
$sqlCategories = "SELECT DISTINCT category FROM personal";
$resultCategories = $mysqli->query($sqlCategories);
$categories = array();
while ($row = $resultCategories->fetch_assoc()) {
    $categories[] = $row['category'];
}

$mysqli->close();
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
        .table-container {
            max-height: 450px; /* Set a fixed height for the table container */
            overflow-y: auto; /* Add a vertical scrollbar if needed */
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 15px;
            /*overflow: hidden;
            max-height: 400px; /* Set a fixed height for the table */
        }
        
        th,
        td {
            font-weight: bold;
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f5daef;
        }

        td {
            background-color: #fff;
        }

        .button-container {
        display: flex;
    }

        /* Add styles for the search box */
        .search-container {
            margin-bottom: 20px;
        }

        .search-box {
            margin-right: 10px;
        }

    </style>
</head>

<body>
    <div class="container">
        <h2><svg xmlns="http://www.w3.org/2000/svg" width="20" height="18" fill="currentColor" class="bi bi-file-earmark-text-fill" viewBox="0 0 16 16">
            <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0M9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1M4.5 9a.5.5 0 0 1 0-1h7a.5.5 0 0 1 0 1zM4 10.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m.5 2.5a.5.5 0 0 1 0-1h4a.5.5 0 0 1 0 1z" />
        </svg>  Details</h2>
        <div class="search-container">
            <select class="search-box" name="search_column" id="search_column">
                <option value="name">Name</option>
                <option value="address">Address</option>
                <option value="phone_number">Phone number</option>
                <option value="email_id">Email ID</option>
                
            </select>
           
            <input class="search-box" type="text" name="search_value" id="search_value" placeholder="Search...">
            <!--button onclick="search()">Search</button-->
            <select class="search-box" name="search_category" id="search_category">
                <option value="" selected disabled>Select Category</option>
                <?php foreach ($categories as $category) { ?>
                    <option value="<?php echo $category; ?>"><?php echo $category; ?></option>
                <?php } ?>
            </select>
            <button onclick="searchByCategory()">Search by Category</button>
            <button onclick="resetSearch()">Reset</button>
        </div>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="eventForm">

            <div class="button-container">
                <label><input type="checkbox" id="selectAll" onclick="selectAllContacts()"> Select All</label>
                <button class="add-button" type="submit" name="sendEvent">Send</button>
            </div>
            <!-- TABLE CONSTRUCTION -->
<div class="table-container">
    <table>
        <tr>
            <th>Select</th>
            <th>Name</th>
            <th>Address</th>
            <th>Phone number</th>
            <th>Email ID</th>
            <th>Category</th>
        </tr>
        <!-- PHP CODE TO FETCH DATA FROM ROWS -->
        <?php while ($rows = $result->fetch_assoc()) { ?>
            <tr>
                <!-- ADD CHECKBOX FOR EACH ROW -->
                <td><input type="checkbox" name="contact[]" value="<?php echo $rows['id']; ?>"></td>
                <!-- FETCHING DATA FROM EACH ROW OF EVERY COLUMN -->
                <td><?php echo $rows['name']; ?></td>
                <td><?php echo $rows['address']; ?></td>
                <td><?php echo $rows["phone_number"]; ?></td>
                <td><?php echo $rows["email_id"]; ?></td>
                <td><?php echo str_replace('-', ' ', $rows["category"]); ?></td>
            </tr>
        <?php } ?>
    </table>
    
    <!-- Add a hidden input field to store the selected contacts -->
    <input type="hidden" name="selectedContacts" id="selectedContacts">
</div>

</form>

<script>
    function selectAllContacts() {
        var checkboxes = document.getElementsByName('contact[]');
        var selectAllCheckbox = document.getElementById('selectAll');

        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = selectAllCheckbox.checked;
        }
    }
    function search() {
        var searchColumn = document.getElementById('search_column').value;
        var searchValue = document.getElementById('search_value').value;
        window.location.href = '?search_column=' + searchColumn + '&search_value=' + searchValue;
    }

    function resetSearch() {
    var searchColumn = document.getElementById('search_column').value;
    var searchValue = document.getElementById('search_value').value;
    var searchCategory = document.getElementById('search_category').value;

    var resetUrl = 'share_event.php'; // Replace with the actual filename

    // Include the event ID in the reset URL if it exists
    <?php if ($eventId !== null) { ?>
        resetUrl += '?eventId=<?php echo $eventId; ?>';
    <?php } ?>

    // Redirect to the reset URL
    window.location.href = resetUrl;
}
    function searchByCategory() {
        var searchCategory = document.getElementById('search_category').value;
        window.location.href = '?search_column=category&search_value=' + searchCategory;
    }
        // Add an event listener to trigger search when Enter is pressed in the search box
        document.getElementById('search_value').addEventListener('keyup', function (event) {
                if (event.key === 'Enter') {
                    search();
                }
            });
            

        </script>
    </div>
</body>

</html>
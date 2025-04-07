<?php 
include ('../../login/check_admin.php');

if (isset($_GET['url'])) {
    $url = $_GET['url'];
    header('Location: ' . $url);
    exit;
}

// Check if  parameter is set
$office = isset($_GET['office']) ? $_GET['office'] : '';

// Prepare the SQL query to get user account details 
$query = "SELECT id_number, full_name, phone_number, email FROM technician WHERE deleted = 0"; // Exclude deleted accounts

$result = mysqli_query($conn, $query);

// Error handling
if (!$result) {
    die('Query failed: ' . mysqli_error($conn));
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrator</title>

<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Include Date Range Picker CSS and JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
<script src="https://cdn.jsdelivr.net/npm/moment/min/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="../../dashboard.css?v=1.0">          <!--dashboard css-->
    <link rel="stylesheet" type="text/css" href="../../../css/dateandtime.css?v=1.0">     <!--date and time css-->
    <script src="../../../js/dateandtime.js" defer></script>            <!--date and time javascript-->
    <script src="../../login/auth.js"></script>  <!--login js authorization-->
    <script src="../logout.js" defer></script>    <!--logout overlay js-->
    <link rel="stylesheet" type="text/css" href="../logout.css?v=1.0">   <!--logout overlay css-->
    <script src="../../loading.js" defer></script>    <!--loading js-->
    <link rel="stylesheet" type="text/css" href="../../loading.css?v=1.0">   <!--loading overlay css-->

      <div class="header"> <?php include 'header.php'; ?></div> <!--HEADER ,DATE, LOGO, TIME-->

</head>




    <style>

body, html {
  display: flex;
  flex-direction: column;
  height: 100%;
  margin: 0;
  font-family: Arial, sans-serif;
}

.container {
  position: relative;
  height: 100%;
  
}

.input-group {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    margin-bottom: 1em;
}

.input-group label {
    margin-bottom: 0.5em;
    color: #666;
}

.input-group input,
.input-group select {
    width: 70%;
    padding: 0.5em;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 1em;
    color: #333;
}

.main-body {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  flex-direction: column;
  min-height: 100vh; /* Make the wrapper take up the full height of the viewport */
}
#content-main-body {
  overflow-x: hidden;
  width: 100%;
  padding-top: 1rem;
  padding-bottom: 80px;
  flex: 1; /* Make the content wrapper take up the remaining space */
}

.footer {
    position: fixed; /* Position the footer absolutely */
    bottom: 0; /* Stick the footer to the bottom of the body */
    width: 100%; /* Make the footer take up the full width of the body */
    height: 15px; /* Set the footer's height */
    background-color: #333; /* Set the footer's background color */
    color: #fff; /* Set the footer's text color */
    text-align: center; /* Center the footer's text */
    padding: 10px; /* Add some padding to the footer */
    z-index: 1; /* Set the z-index to a high value */
    font-size: 12px; /* Set the font size to 24px */
}

.badge.incoming{      /*  incoming tab notification   */
    background-color: #AA0000; /* change to your desired color */
    color: #fff;
    font-size: 0.75rem;
    padding: 0.25rem 0.5rem;
    border-radius: 50%;
    position: absolute;
    top: 80px;
    right: 50px;
    transform: translate(50%, -50%);
}

.badge.in_progress{       /*  in progress tab notification   */
    background-color: #AA0000; /* change to your desired color */
    color: #fff;
    font-size: 0.75rem;
    padding: 0.25rem 0.5rem;
    border-radius: 50%;
    position: absolute;
    top: 210px;
    right: 50px;
    transform: translate(50%, -50%);
}

.badge.scheduled{         /*  scheduled tab notification   */
    background-color: #AA0000; /* change to your desired color */
    color: #fff;
    font-size: 0.75rem;
    padding: 0.25rem 0.5rem;
    border-radius: 50%;
    position: absolute;
    top: 275px;
    right: 50px;
    transform: translate(50%, -50%);
}

.user-list {
    margin-left: 270px;
    margin-right: 100px;
    display: grid; /* Change to grid for better layout */
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); /* Responsive columns */
    gap: 15px; /* Space between items */
    padding: 20px; /* Padding around the user list */
    /*border: 2px solid black; /* width, style, color */
}

.user-item {
    background-color: #ffffff; /* White background for cards */
    border-radius: 8px; /* Rounded corners */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow */
    padding: 15px; /* Padding inside cards */
    text-align: center; /* Center text */
    transition: transform 0.3s, box-shadow 0.3s; /* Animation effects */
    border: 2px solid black; /* width, style, color */
}

.user-item:hover {
    transform: translateY(-5px); /* Lift effect on hover */
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); /* Stronger shadow on hover */
    cursor: pointer;
}
/* Overlay container */
#overlay {
    position: fixed;
    top: -100%; /* Start from above the screen */
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.7);
    display: none;  /* Initially hidden */
    justify-content: center;
    align-items: center;
    animation: slideDown 0.5s ease-out forwards; /* Animation for sliding down */
    z-index: 1;
}

/* Overlay content box styling */
#overlay-content {
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    text-align: left;
    max-width: 600px;
    width: 80%;
    box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.1); /* Light shadow for depth */
    transform: translateY(-50%);  /* Center content vertically */
    animation: slideContentUp 0.5s ease-out forwards; /* Animation for content sliding */
}

/* Table styling */
table {
    width: 100%;
    margin-top: 20px;
    border-collapse: collapse;
}

table th, table td {
    padding: 10px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

/* Table header styling */
table th {
    padding: 10px; /* Padding for better readability */
    text-align: left; /* Align text to the left */
    width: 30%; /* Set a fixed width for the columns, or adjust as needed */
}

/* Optional: For alternating row colors for better readability */
table tr:nth-child(even) {
    background-color: #f9f9f9;
}

table tr:nth-child(odd) {
    background-color: #ffffff;
}

table {
    border-collapse: collapse; /* Ensures that the table borders do not double up */
    width: 100%; /* Full width table */
}

table td, table th {
    border: 1px solid #ddd; /* Light gray border for both cells and headers */
}

table td {
    font-size: 16px;
}

button {
    margin-top: 20px;
    padding: 10px 20px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #0056b3;
}

/* Close button for the overlay */
#overlay .close-btn {
    position: absolute;
    top: 10px;
    right: 10px;
    background: transparent;
    border: none;
    font-size: 20px;
    color: #333;
    cursor: pointer;
}

#overlay .close-btn:hover {
    color: #007bff;
}

/* Slide-down animation for overlay */
@keyframes slideDown {
    0% {
        top: -100%;
    }
    100% {
        top: 0;
    }
}

/* Slide-up animation for content */
@keyframes slideContentUp {
    0% {
        transform: translateY(-50%);
        opacity: 0;
    }
    100% {
        transform: translateY(0);
        opacity: 1;
    }
}



.arrow-button {
    font-size: 16px; /* Font size */
    cursor: pointer; /* Pointer cursor on hover */
    transition: background-color 0.3s; /* Transition effect */
}

.arrow-button:hover {
    background-color: #0056b3; /* Darker blue on hover */
}

.arrow-button:focus {
    outline: none; /* Remove outline on focus */
}


    </style>
</head>
<?php include '../../nav-bar.php'; ?>
<body>

   
<div class="dashboard">
            <ul class="sidebar navbar-nav">
                <h3>Dashboard</h3>               
                <li class="nav-item active">
        <a class="nav-link" href="../../home/home.php">
            <span> Home / Incoming Tickets</span>
            <span class="badge incoming">
                <?php
                $query_pending = "SELECT COUNT(*) AS pending FROM ticket WHERE status = 'Pending'";
                $result_pending = mysqli_query($conn, $query_pending);
                $row_pending = mysqli_fetch_assoc($result_pending);
                echo $row_pending['pending'];
                ?>
            </span> 
        </a>
    </li>

    <li class="nav-item active">
        <a class="nav-link" href="../../ticket/ticket.php">
            <span> All Tickets</span>
        </a>
    </li>

    <li class="nav-item active">
        <a class="nav-link" href="../../in_progress/in_progress.php">
            <span>In Progress Tickets</span>
            <span class="badge in_progress">
                <?php
                $query_in_progress = "SELECT COUNT(*) AS in_progress FROM ticket WHERE status = 'In Progress'";
                $result_in_progress = mysqli_query($conn, $query_in_progress);
                $row_in_progress = mysqli_fetch_assoc($result_in_progress);
                echo $row_in_progress['in_progress'];
                ?>
            </span> 
        </a>
    </li>

    <li class="nav-item active">
        <a class="nav-link" href="../../scheduling/scheduling.php">
            <span>Scheduled Tickets</span>
            <span class="badge scheduled">
                <?php
                $query_scheduled = "SELECT COUNT(*) AS scheduled FROM ticket WHERE status = 'Scheduled'";
                $result_scheduled = mysqli_query($conn, $query_scheduled);
                $row_scheduled = mysqli_fetch_assoc($result_scheduled);
                echo $row_scheduled['scheduled'];
                ?>
            </span> 
        </a>
    </li>


                <li class="nav-item active">
                <a class="nav-link"  href="../../repaired/repaired.php">
                        <span>Repaired Tickets</span>
                    </a>
                </li>

                <li class="nav-item active">
                <a class="nav-link"  href="../../closed/closed.php">
                        <span>Closed Tickets</span>
                    </a>
                </li>

                <li class="nav-item active">
                <a class="nav-link"  href="../../offices/offices.php">
                        <span>Barangays / Offices</span>
                    </a>
                </li>

                <li class="nav-item active">
                <a class="nav-link"  href="../../search/search.php">
                        <span>Search Ticket</span>
                    </a>
                </li>

                <li class="nav-item active">
                <a class="nav-link" href="../../account/accounts.php">
                        <span>Accounts</span>
                    </a>
                </li>

                <li class="nav-item active">
                <a class="nav-link" href="../../feedback/feedback.php">
                        <span>Feedback / Comments</span>
                    </a>
                </li>

                <li class="nav-item active">
                <a class="nav-link">
                        <span>Reports</span>
                    </a>
                </li>


               <li class="nav-item active">
               <a class="nav-link" href="#" id="logout-link" >
                        <span>Log Out</span>
                     </a>
                </li>

<div class="confirm-overlay" id="confirm-overlay"> <!-- Logout Confirmation -->
    <div class="confirm-content">
        <p>ARE YOU SURE </p>
        <p>YOU WANT TO LOG OUT?</p>
        <button id="confirm-yes">Yes</button>
        <button id="confirm-no">No</button>
    </div>
</div>

</ul>
        </div>
        <div id="content-loader"></div>
    </div>
</div>

<div class="content-main-body">
    
<a href="../report.php" style="float: left; margin-left: 300px; margin-top: 20px; text-decoration: none;">
    <button class="arrow-button" style="background-color:#AA0000; color: #fff; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; display: flex; align-items: center; gap: 8px; font-weight: bold;">
        &larr; Back
    </button>
</a>


<br>
<br>
<h2 style="
    font-size: 24px;
    color: #006400; 
    text-transform: uppercase;
    font-weight: bold;
     background-color: #E0FFE0; 
    padding: 10px;
    border-radius: 5px;
     border: 2px solid #32CD32;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    margin-left: auto;
    margin-right: auto;
    display: block;
    width: fit-content;
">
    SELECT Technician 
    <br>Accounts
</h2>

<div class="user-list">
    <?php
    // Fetch and display each row as clickable items
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $id_number = htmlspecialchars($row['id_number']);
            $full_name = htmlspecialchars($row['full_name']);
            $phone_number = htmlspecialchars($row['phone_number']);
            $email = htmlspecialchars($row['email']);
            ?>
            <div class="user-item" onclick="openOverlay('<?= $id_number ?>', '<?= $full_name ?>', '<?= $phone_number ?>', '<?= $email ?>')">
                <?= $full_name ?>
            </div>
            <?php
        }
    } else {
        echo "<p>NO USER ACCOUNT FOUND.</p>";
    }
    ?>
</div>

<div id="overlay">
    <div id="overlay-content">
        <!-- Close Button -->
        <button class="close-btn" onclick="closeOverlay()">X</button>
        <h3>Technician Details</h3>
        <table>
            <tr>
                <th>Name</th>
                <td><span id="overlay-full-name"></span></td>
            </tr>
            <tr>
                <th>Phone</th>
                <td><span id="overlay-phone"></span></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><span id="overlay-email"></span></td>
            </tr>
        </table>
        <br><br>

     <!-- Date Range Picker -->
<h4 style="text-align: center; margin-top: 10px; margin-bottom: 20px; color: #333; font-size: 20px; font-weight: bold;">
    Select Date Range
</h4>
<input type="text" id="daterange" name="daterange" style="width: 30%; padding: 10px; border-radius: 5px;">
<span id="selected-daterange" style="font-size: 18px; color: #333; margin-left: 10px;"></span>


<h4 style="text-align: center; margin-top: 10px; margin-bottom: 20px; color: #333; font-size: 20px; font-weight: bold;">
    Ticket Statistics
</h4>
<table>
    <tr>
        <th>Total Tickets</th>
        <td><span id="overlay-total-tickets">0</span></td>
    </tr>
    <tr>
        <th>Repaired Tickets</th>
        <td><span id="overlay-repaired-tickets">0</span></td>
    </tr>
    <tr>
        <th>Closed Tickets</th>
        <td><span id="overlay-closed-tickets">0</span></td>
    </tr>
    <tr>
        <th>In Progress Tickets</th>
        <td><span id="overlay-in-progress-tickets">0</span></td>
    </tr>
</table>


        <div style="display: flex; justify-content: space-between; width: 100%; padding: 10px;">
            <button onclick="closeOverlay()">Close</button>
            <button onclick="generatePDF()"
                    style="background-color: #008CBA; color: white; padding: 5px 15px; border: none; border-radius: 5px; cursor: pointer;">
              Print
            </button>
        </div>
    </div>
</div>

<!-- JavaScript for initializing and handling Date Range Picker -->
<script>
function fetchTicketStats(startDate, endDate) {
    // Retrieve technician name from overlay
    const technicianName = document.getElementById('overlay-full-name').innerText;
    if (!technicianName) {
        console.error("Technician name is missing.");
        return;
    }

    // If no dates provided, get them from daterange input
    if (!startDate || !endDate) {
        const dateRange = document.getElementById('daterange').value.split(" to ");
        if (dateRange.length === 2) {
            startDate = dateRange[0];
            endDate = dateRange[1];
        } else {
            console.error("Date range not properly selected.");
            return;
        }
    }

    // Prepare data to send in the POST request
    const formData = new FormData();
    formData.append("start_date", startDate);
    formData.append("end_date", endDate);
    formData.append("technician_name", technicianName);

    // Fetch data using POST
    fetch('fetch_report.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(ticketData => {
        if (ticketData.error) {
            console.error(ticketData.error);
            return;
        }
        document.getElementById('overlay-total-tickets').innerText = ticketData.totalTickets;
        document.getElementById('overlay-repaired-tickets').innerText = ticketData.repairedTickets;
        document.getElementById('overlay-closed-tickets').innerText = ticketData.closedTickets;
        document.getElementById('overlay-in-progress-tickets').innerText = ticketData.inProgressTickets;
    })
    .catch(error => console.error('Error fetching ticket statistics:', error));
}
$(document).ready(function() {
    // Initialize Date Range Picker
    $('#daterange').daterangepicker({
        locale: { format: 'YYYY-MM-DD' }, // Keep the input format as YYYY-MM-DD
        opens: 'center',
        autoUpdateInput: false,
        minDate: '2024-01-01',
        maxDate: moment().add(10, 'years'),
        ranges: {
            'Today': [moment(), moment()],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
            'This Year': [moment().startOf('year'), moment().endOf('year')],
            'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')]
        }
    });

    // When a date range is applied, update both the input field and the display area
    $('#daterange').on('apply.daterangepicker', function(ev, picker) {
        // Get the start and end dates in the original format (YYYY-MM-DD)
        const startDate = picker.startDate.format('YYYY-MM-DD');
        const endDate = picker.endDate.format('YYYY-MM-DD');
        
        // Set the input field value with the formatted date
        $(this).val(startDate + ' to ' + endDate);
        
        // Format the dates to include the full month name (e.g., "January", "February")
        const startDateFormatted = picker.startDate.format('MMMM DD, YYYY');
        const endDateFormatted = picker.endDate.format('MMMM DD, YYYY');
        
        // Update the display area with the formatted date range
        $('#selected-daterange').text(startDateFormatted + ' to ' + endDateFormatted);

        // Optionally, call fetchTicketStats with the raw date format (YYYY-MM-DD)
        fetchTicketStats(startDate, endDate);

        // Pass the formatted date range to the print function
        window.formattedDateRange = startDateFormatted + ' to ' + endDateFormatted;
    });
});


// Pass the full_name to the function when a user-item is clicked
function openOverlay(id_number, full_name, phone_number, email) {
    document.getElementById('overlay').style.display = 'flex';
    document.getElementById('overlay-full-name').innerText = full_name;
    document.getElementById('overlay-phone').innerText = phone_number;
    document.getElementById('overlay-email').innerText = email;
}

// Function to print the overlay content
// Function to generate the PDF and open it in a new tab
function generatePDF() {
    // Get the technician details and ticket statistics from the overlay
    var technicianName = document.getElementById('overlay-full-name').innerText;
    var phone = document.getElementById('overlay-phone').innerText;
    var email = document.getElementById('overlay-email').innerText;
    var totalTickets = document.getElementById('overlay-total-tickets').innerText;
    var repairedTickets = document.getElementById('overlay-repaired-tickets').innerText;
    var closedTickets = document.getElementById('overlay-closed-tickets').innerText;
    var inProgressTickets = document.getElementById('overlay-in-progress-tickets').innerText;

    // Use the globally stored formatted date range
    var formattedDateRange = window.formattedDateRange;

    // Create a form dynamically to send the data to the server
    var form = document.createElement('form');
    form.method = 'POST';
    form.action = 'print.php';  // Path to your PDF generation script

    // Create hidden input fields and append them to the form
    form.appendChild(createHiddenInput('technician_name', technicianName));
    form.appendChild(createHiddenInput('phone', phone));
    form.appendChild(createHiddenInput('email', email));
    form.appendChild(createHiddenInput('total_tickets', totalTickets));
    form.appendChild(createHiddenInput('repaired_tickets', repairedTickets));
    form.appendChild(createHiddenInput('closed_tickets', closedTickets));
    form.appendChild(createHiddenInput('in_progress_tickets', inProgressTickets));
    form.appendChild(createHiddenInput('formattedDateRange', formattedDateRange));  // Send the formatted date range
    
    // Set the target to open the form result in a new tab
    form.target = '_blank';

    // Append the form to the document body
    document.body.appendChild(form);

    // Submit the form, which will open the PDF in a new tab
    form.submit();

    // Clean up: Remove the form after submission
    document.body.removeChild(form);
}

// Function to create hidden input fields
function createHiddenInput(name, value) {
    var input = document.createElement('input');
    input.type = 'hidden';
    input.name = name;
    input.value = value;
    return input;
}


function closeOverlay() {
    document.getElementById('overlay').style.display = 'none';
}
</script>


</body>
</html>

<footer class="footer">
    @ All Rights Reserved @
</footer>


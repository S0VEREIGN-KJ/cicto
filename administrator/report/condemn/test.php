<?php 
include ('../../login/check_admin.php');

if (isset($_GET['url'])) {
    $url = $_GET['url'];
    header('Location: ' . $url);
    exit;
}
$serial_number = isset($_GET['search_input']) ? $_GET['search_input'] : '';
// Check if the form has been submitted with a serial number

    // Optionally, close the connection once you're done with all queries
    // $conn->close(); // This should be called after all database operations



// Don't close the connection here if you're still using it elsewhere
//$conn->close(); // Remove this line from here
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


/* overlay_container */ /* overlay_container */ /* overlay_container */ /* overlay_container */ /* overlay_container */ /* overlay_container */ /* overlay_container */
  /* overlay_container */
.overlay_container {
    width: 100%;
    max-width: 8.5in; /* Max width to fit half of short bond paper */
    padding: 0.5in; /* Padding for spacing */
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    box-sizing: border-box;
    border: 1px solid #000;
    margin: 0; /* Remove extra margins */
    
}
/* overlay_header */
.overlay_header {
    display: flex;
    align-items: center;
    border-bottom: 2px solid #000;
    padding: 5px 0; /* Reduced padding for overlay_header */
    margin-bottom: 10px; /* Margin between overlay_header and content */
    background-color: rgb(64, 188, 246);
}

.overlay_header img {
    width: 60px;
    height: auto;
    margin-right: 10px; /* Space between logo and text */
    margin-left: 10px; /* Space between logo and text */
}

.overlay_header h1 {
    margin: 0; /* Remove default margin */
    font-size: 18pt; /* Adjust font size for overlay_header */
    text-align: center;
}
/* Form Group */
.overlay_form_group {
    margin-bottom: 10px; /* Spacing between form groups */
    display: flex;
    align-items: center; /* Align items vertically centered */
    justify-content: space-between; /* Space between label and input */
}

label {
    flex: 0 0 150px; /* Set a fixed width for the label */
    margin: 0; /* Remove extra margins */
}

input, select {
    width: 100%;
    padding: 8px; /* Increased padding inside input fields */
    border: 1px solid #000;
    border-radius: 4px;
}

/* Custom Select with Device Image */
.custom-select {
    position: relative;
    width: 100%;
}

.select-box {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 8px; /* Increased padding inside select box */
    border: 1px solid #000;
    border-radius: 4px;
    cursor: pointer;
    background: #fff; /* Added background for select box */
}

.select-box img {
    width: 40px; /* Adjust size of the device image */
    height: auto;
}

.options-overlay_container {
    position: absolute;
    width: calc(100% - 2px); /* Adjust to match select box width */
    background: #fff;
    border: 1px solid #000;
    border-radius: 4px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    display: none;
    z-index: 10;
    top: 100%; /* Position below the select box */
    left: 0; /* Align with left edge of select box */
}

.options-overlay_container.visible {
    display: block;
}

.option {
    display: flex;
    align-items: center;
    padding: 8px; /* Increased padding inside option items */
    border-bottom: 1px solid #ddd; /* Divider between options */
    cursor: pointer;
}

.option:hover {
    background-color: #f2f2f2; /* Highlight on hover */
}

.option img {
    width: 30px; /* Adjust size of option images */
    height: auto;
    margin-right: 10px; /* Space between image and text */
}


.overlay {
    height: 0%;
  width: 80%;
  position: fixed;
  z-index: 1;
  top: 0;
  left: 200px;
  background-color: rgba(255, 255, 255, 0); /* Set opacity to 0 for full transparency */
  justify-content: center;
  display: flex;
  overflow-y: hidden;
  transition: 0.5s;
}

.overlay-content {
  font-size: 12pt;
  font-family: Arial, sans-serif;
  position: relative;
  width: 70%; /* adjust the width as needed */
  text-align: center;
  margin: 0 auto;
  padding: 20px;
  background-color: #FFFFFF;;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(255,255,255,0.5);
  max-height: 80vh; /* adjust the value to your liking */
  overflow-y: auto;
}
.overlay a {
  padding: 8px;
  text-decoration: none;
  font-size: 36px;
  color: #818181;
  display: block;
  transition: 0.3s;
}

.overlay a:hover, .overlay a:focus {
  color: #f1f1f1;
}

.overlay .closebtn {
  position: absolute;
  top: 20px;
  right: 85px;
  font-size: 60px;
  color: #000000; /* or rgb(255, 0, 0) or rgba(255, 0, 0, 1) */
  border: 2px solid #000;
}


@media screen and (max-height: 450px) {
  .overlay {overflow-y: auto;}
  .overlay a {font-size: 20px}
  .overlay .closebtn {
  font-size: 40px;
  top: 15px;
  right: 35px;
  }
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
}
.footer-title {
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
 /* Search form styling */
 .search-form {
    display: flex;
  justify-content: center;
  align-items: center;
    margin-left: 500px;
    margin-top: 20px;
    width: 500px;
    padding: 20px;
    background-color: #f9f9f9;
    border: 1px solid #ccc;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  }
  .search-form input[type="text"] {
    width: 250px;
    height: 30px;
    margin: 10px;
    padding: 10px;
    border: 1px solid #ccc;
  }
  .search-form input[type="submit"] {
    width: 150px;
    height: 30px;
    margin: 10px;
    padding: 10px;
    background-color: #4CAF50;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
  }
  .search-form input[type="submit"]:hover {
    background-color: #3e8e41;
  }
  
    </style>
</head>
<div style="height: 50px;">
  <?php include '../../nav-bar.php'; ?>
</div>
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
    <button class="arrow-button" style="margin-top: 5px; background-color:#AA0000; color: #fff; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; display: flex; align-items: center; gap: 8px; font-weight: bold;">
        &larr; Back
    </button>
</a>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get" class="search-form" autocomplete="off" id="search-form">
  <input type="text" name="search_input" placeholder="Put Serial Number..." value="" required>
  <input type="submit" value="Create Condemn">
</form>

<?php
$serial_number = '';

// If the form is submitted, sanitize the input and execute the query
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['search_input'])) {
    // Sanitize the input to avoid XSS or other injection attacks
    $serial_number = htmlspecialchars(trim($_GET['search_input']));

    // Make sure the connection is still open
    if ($conn) {
        // Query to get the data based on the serial number
        $sql = "SELECT serial_number, unit, category, office, COUNT(serial_number) AS ticket_count
                FROM ticket
                WHERE serial_number = ?
                GROUP BY serial_number, unit, category, office";

        // Prepare the query
        if ($stmt = $conn->prepare($sql)) {
            // Bind the serial_number parameter to the prepared statement
            $stmt->bind_param("s", $serial_number);

            // Execute the query
            $stmt->execute();
            $result = $stmt->get_result();

            // Initialize device_data
            $device_data = null;

            // Check if the query returned any results
            if ($result->num_rows > 0) {
                // Fetch the data
                $device_data = $result->fetch_assoc();
            } else {
                // Handle the case when no data is found
                echo "No data found for the provided serial number.";
            }
            // Close the prepared statement
            $stmt->close();
        } else {
            // Handle query preparation error
            echo "Error preparing query.";
        }
    } else {
        // Handle connection error
        echo "Database connection failed.";
    }
}
?>



<div id="myNav" class="overlay">



<div class="overlay-content">
  <div class="overlay_container">
        <!-- overlay_header with Logo -->
        <div class="overlay_header">
        <img src="../../images/cicto_logo.png" alt="Company Logo">
            <h1>City Information and Communications Technology &nbsp; &nbsp;&nbsp;CERTIFICATE OF CONDEMN</h1>
        </div>

  <form action="" method="post" autocomplete="off">
  <p>Instructions: Please fill out and check the appropriate Box</p>
  <a href="javascript:void(0)" class="closebtn" onclick="closeOverlay()">&times;</a>  <!-- close button for overlay -->

  <div class="overlay_form_group">
    <label for="datetime_req">Date Issued</label>
    <input type="text" id="date_today" name="date_today" value="" readonly required> <!-- date requested -->
</div>

<div class="overlay_form_group">
    <label for="serial_number">Serial No.</label>
    <input type="text" id="serial_number" name="serial_number" value="<?php echo isset($device_data['serial_number']) ? htmlspecialchars($device_data['serial_number']) : ''; ?>" readonly required>
</div>

<div class="overlay_form_group">
    <label for="unit_description">Device Description:</label>
    <input type="text" id="unit_description" name="unit_description" value="<?php echo isset($device_data['unit_description']) ? htmlspecialchars($device_data['unit_description']) : ''; ?>" required> <!-- unit description -->
</div>

<div class="overlay_form_group">
    <label for="unit">Device Type:</label>
    <input type="text" id="unit" name="unit" value="<?php echo isset($device_data['unit']) ? htmlspecialchars($device_data['unit']) : ''; ?>" readonly required>
</div>

<div class="overlay_form_group">
    <label for="category">Category:</label>
    <input type="text" id="category" name="category" value="<?php echo isset($device_data['category']) ? htmlspecialchars($device_data['category']) : ''; ?>" readonly required>
</div>

<div class="overlay_form_group">
    <label for="office">Office</label>
    <input type="text" id="office" name="office" value="<?php echo isset($device_data['office']) ? htmlspecialchars($device_data['office']) : ''; ?>" readonly required>
</div>

<div class="overlay_form_group">
    <label for="ticket_count">Number of Repairs/Tickets:</label>
    <input type="text" id="ticket_count" name="ticket_count" value="<?php echo isset($device_data['ticket_count']) ? htmlspecialchars($device_data['ticket_count']) : '0'; ?>" readonly required>
</div>

<div class="overlay_form_group">
    <label for="requested_by">Requested by</label>
    <input type="text" id="requested_by" name="requested_by" value="<?php echo isset($device_data['requested_by']) ? htmlspecialchars($device_data['requested_by']) : ''; ?>" required> <!-- requester name -->
</div>

<div class="overlay_form_group">
    <label for="condition_status">Condition/Status:</label>
    <input type="text" id="condition_status" name="condition_status" value="<?php echo isset($device_data['condition_status']) ? htmlspecialchars($device_data['condition_status']) : ''; ?>" required> <!-- condition/status -->
</div>

<div class="overlay_form_group">
    <label for="reason_condemnation">Reason of Condemnation:</label>
    <input type="text" id="reason_condemnation" name="reason_condemnation" value="<?php echo isset($device_data['reason_condemnation']) ? htmlspecialchars($device_data['reason_condemnation']) : ''; ?>" required> <!-- reason for condemnation -->
</div>

<div class="overlay_form_group">
    <label for="comment_text">Comment:</label>
    <input type="text" id="comment_text" name="comment_text" value="<?php echo isset($device_data['comment_text']) ? htmlspecialchars($device_data['comment_text']) : ''; ?>" required> <!-- comment -->
</div>

      
    <div class="overlay_form_group">
      <br>
      <div style="display: right; justify-content: space-between; width: 100%; padding: 10px;">
        
        <button onclick="printTicket()" 
                style="background-color: #008CBA; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">
          Print Condemnation
        </button>
  
</form>
    </div>
    </div>

</div>

<!-- JavaScript for initializing and handling Date Range Picker -->
<script>
  window.onload = function() {
    var form = document.getElementById('search-form');
    
    // If there was no serial number submitted (initial page load), reset the form
    if (!document.getElementById('search-form').elements['search_input'].value) {
      form.reset();
    }
  };
 window.onload = function() {
    // Get current date
    var today = new Date();
    
    // Array of month names
    var monthNames = [
        "January", "February", "March", "April", "May", "June", 
        "July", "August", "September", "October", "November", "December"
    ];
    
    // Get the formatted date as Month / Day / Year
    var formattedDate = monthNames[today.getMonth()] + " / " + today.getDate() + " / " + today.getFullYear();
    
    // Set the value of the input field to today's formatted date
    document.getElementById('date_today').value = formattedDate;
};

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

function openOverlay() {
    document.getElementById('myNav').style.height = '100%';
}

function closeOverlay() {
    document.getElementById('myNav').style.height = '0%';
}

 // Attach the openOverlay function to the form submission
 document.getElementById('search-form').addEventListener('submit', function(event) {
    event.preventDefault();  // Prevent the form from actually submitting
    openOverlay();  // Open the overlay
  });
  
</script>


</body>
</html>

<footer class="footer">
    @ All Rights Reserved @
</footer>


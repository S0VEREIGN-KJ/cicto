<?php 
include ('../../login/check_admin.php');


if (isset($_GET['url'])) {
  $url = $_GET['url'];
  header('Location: ' . $url);
  exit;
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


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<script src="jQuery.js"></script>

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
    margin-left: -450px;
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

<div style="height: 50px;">
  <?php include '../../nav-bar.php'; ?>
</div>
<body>

<div id="loadingOverlay" class="loadingOverlay">  <!--LOADING SCREEN-->
        <div class="loader">
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
        </div>
    </div> 
    

<div class="dashboard">
            <ul class="sidebar navbar-nav">
                <h3>Dashboard</h3>               
                <li class="nav-item active">
                    <a class="nav-link" href="../../home/home.php">
                    <span> Home / Incoming Tickets</span>
                    <span class="badge incoming">    <?php
          $query = "SELECT COUNT(*) AS pending FROM ticket WHERE status = 'Pending'";
          $result = mysqli_query($conn, $query);
          $row = mysqli_fetch_assoc($result);
          echo $row['pending'];
        ?></span> 
                    </a>
                </li>

                <li class="nav-item active">
                <a class="nav-link" href="../../ticket/ticket.php">
                        <span> All Tickets</span>
                    </a>
                </li>
    
                <li class="nav-item active">
                    <a class="nav-link"  href="../../in_progress/in_progress.php">
                        <span>In Progress Tickets</span>
                        <span class="badge in_progress">    <?php
          $query = "SELECT COUNT(*) AS in_progress FROM ticket WHERE status = 'In Progress'";
          $result = mysqli_query($conn, $query);
          $row = mysqli_fetch_assoc($result);
          echo $row['in_progress'];
        ?></span> 
                    </a>
                </li>

                <li class="nav-item active">
                <a class="nav-link"  href="../../scheduling/scheduling.php">
                        <span>Scheduled Tickets</span>
                        <span class="badge scheduled">    <?php
          $query = "SELECT COUNT(*) AS scheduled FROM ticket WHERE status = 'Scheduled'";
          $result = mysqli_query($conn, $query);
          $row = mysqli_fetch_assoc($result);
          echo $row['scheduled'];
        ?></span> 
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
                <a class="nav-link" href="../../offices/offices.php" >
                        <span>Barangays / Offices</span>
                    </a>
                </li>

                <li class="nav-item active">
                <a class="nav-link" href="../../search/search.php" >
                        <span>Search Ticket</span>
                    </a>
                </li>

                <li class="nav-item active">
                <a class="nav-link"  href="../../account/accounts.php">
                        <span>Accounts</span>
                    </a>
                </li>

                <li class="nav-item active">
                <a class="nav-link" href="../../feedback/feedback.php">
                        <span>Feedback / Comments</span>
                    </a>
                </li>
                
                <li class="nav-item active">
                <a class="nav-link" href="../../report/report.php">
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

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get" class="search-form" autocomplete="off">
  <input type="text" name="search_input" placeholder="Search...">
  <input type="submit" value="Search">
</form>

  <!--TABLE TICKETS SUMMARY-->
  <div style=" margin-left: 100px; text-align: center;margin-bottom: 50px;margin-right: -100px; margin-top: 25px;">   <!--FULL TABLE CSS-->
  <?php
$conn = mysqli_connect($servername, $username, $password, $db_name);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$search_query = "
    SELECT serial_number, unit, category, office, COUNT(DISTINCT serial_number) AS ticket_count
    FROM ticket
    WHERE status != 'Pending'
    GROUP BY unit, category, office
";

$stmt = $conn->prepare($search_query);
$stmt->execute();
$result = $stmt->get_result();


?>


<table border="3" style="border-collapse: collapse;width: 80%;font-size: 18px; line-height: 24px; margin: 0 auto; margin-left: 170px;">
  <tr>
    <th>Serial #</th>
    <th>Number of Tickets</th>
    <th>Device Type</th>
    <th>Category</th>
    <th>Office</th>
    <th>View/Print</th>
  </tr>

  <?php
  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      echo "<tr>";
      echo "<td>" . htmlspecialchars($row["serial_number"]) . "</td>";
      echo "<td>" . $row["ticket_count"] . "</td>";
      echo "<td>" . htmlspecialchars($row["unit"]) . "</td>";
      echo "<td>" . htmlspecialchars($row["category"]) . "</td>";
      echo "<td>" . htmlspecialchars($row["office"]) . "</td>";
      echo '<td><a href="#" onclick="openNav(\'' . htmlspecialchars($row["serial_number"]) . '\')">View/Print</a></td>';
      echo "</tr>";
    }
  } else {
    echo "<tr><td colspan='6'>No data found</td></tr>";
  }
  ?>
</table>
        </table>
        </div></div>
        </section>
  


 
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
    <input type="text" id="serial_number" name="serial_number" value="" readonly required>
</div>

<div class="overlay_form_group">
    <label for="unit_description">Device Description:</label>
    <input type="text" id="unit_description" name="unit_description" value="" required> <!-- unit description -->
</div>

<div class="overlay_form_group">
    <label for="unit">Device Type:</label>
    <input type="text" id="unit" name="unit" value="" readonly required>
</div>

<div class="overlay_form_group">
    <label for="category">Category:</label>
    <input type="text" id="category" name="category" value="" readonly required>
</div>

<div class="overlay_form_group">
    <label for="office">Office</label>
    <input type="text" id="office" name="office" value="" readonly required>
</div>

<div class="overlay_form_group">
    <label for="ticket_count">Number of Repairs/Tickets:</label>
    <input type="text" id="ticket_count" name="ticket_count" value="" readonly required>
</div>

<div class="overlay_form_group">
    <label for="requested_by">Requested by</label>
    <input type="text" id="requested_by" name="requested_by" value="" required> <!-- requester name -->
</div>

<div class="overlay_form_group">
    <label for="condition_status">Condition/Status:</label>
    <input type="text" id="condition_status" name="condition_status" value="" required> <!-- condition/status -->
</div>

<div class="overlay_form_group">
    <label for="reason_condemnation">Reason of Condemnation:</label>
    <input type="text" id="reason_condemnation" name="reason_condemnation" value="" required> <!-- reason for condemnation -->
</div>

<div class="overlay_form_group">
    <label for="comment_text">Comment:</label>
    <input type="text" id="comment_text" name="comment_text" value="" required> <!-- comment -->
</div>

    <div class="overlay_form_group">
      <br>
      <div style="display: right; justify-content: space-between; width: 100%; padding: 10px;">
        
        <button onclick="printTicket()" 
                style="background-color: #008CBA; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">
          Print Condemnation
        </button>
  
    </div>
    </div>

</div>

<script>
  function printTicket() {   ///print.php
    var ticketNumber = document.getElementById('ticket_number').value;
    if (ticketNumber) {
        window.open('print.php?ticket_number=' + ticketNumber, '_blank');
    } else {
        alert("Ticket number is missing.");
    }
}
const token = localStorage.getItem('token');
isAuthenticated().then((response) => {
  if (response) {
    // User is authenticated, allow access to dashboard page
  } else {
    // User is not authenticated, redirect to login form page
    window.location.replace('../login/login.php');
  }
}).catch((error) => {
  console.error(error);
});


function loadContent(url) {      ///no cache function
    $.ajax({
        url: url,
        cache: false,
        headers: {
            'Cache-Control': 'no-cache',
            'Pragma': 'no-cache'
        },
        success: function(data) {
            console.log('Loaded content:', data);
            $('#content-loader').html(data);
            window.location.hash = url;
          
        }
    });
}

function openNav(ticketNumber) {
    // Fetch ticket details using AJAX
    $.ajax({
        type: 'GET',
        url: 'fetch_report.php',  // Make sure this path is correct
        data: { ticket_number: ticketNumber },
        cache: false, // Prevent caching
        success: function(data) {
            var ticketDetails = JSON.parse(data);
            
            if (ticketDetails.error) {
                alert(ticketDetails.error);  // Show error message if there's an issue
                return;
            }

            // Populate form fields with fetched data
            document.getElementById('serial_number').value = ticketDetails.serial_number;
            document.getElementById('unit').value = ticketDetails.unit;
            document.getElementById('category').value = ticketDetails.category;
            document.getElementById('office').value = ticketDetails.office;
            document.getElementById('ticket_count').value = ticketDetails.ticket_count;
        },
        error: function(xhr, status, error) {
            console.error('Error fetching ticket details:', error);
        },
        complete: function() {
            console.log('AJAX request complete!');
        }
    });


    // Open the overlay
    document.getElementById("myNav").style.height = "100%";
}

function closeOverlay() {
    document.getElementById("myNav").style.height = "0%";
}


// Get the datetime input element
const datetimeInput = document.getElementById('datetime_req');

// Add an event listener to the input element
datetimeInput.addEventListener('input', () => {
  // Get the value of the input element
  const datetimeValue = datetimeInput.value;

  // Format the time as AM/PM
  const formattedTime = new Date(datetimeValue).toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true });

  // Update the input element with the formatted time
  datetimeInput.value = formattedTime;
});

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

</script>

<footer class="footer">
    <h2 class="footer-title">@ All Rights Reserved @</h2>
</footer>

</body>
</php>




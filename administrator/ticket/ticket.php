<?php 
include ('../login/check_admin.php');

if (isset($_GET['url'])) {
  $url = $_GET['url'];
  header('Location: ' . $url);
  exit;
}

// Retrieve data from database, ordered by specified column
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'datetime_req';
$order = isset($_GET['order']) ? $_GET['order'] : 'DESC';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrator</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   
    <link rel="stylesheet" type="text/css" href="../dashboard.css?v=1.0">          <!--dashboard css-->
    <link rel="stylesheet" type="text/css" href="../../css/dateandtime.css?v=1.0">     <!--date and time css-->
    <script src="../../js/dateandtime.js" defer></script>            <!--date and time javascript-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../login/auth.js"></script>  <!--login js authorization-->
    <script src="logout.js" defer></script>    <!--logout overlay js-->
    <link rel="stylesheet" type="text/css" href="logout.css?v=1.0">   <!--logout overlay css-->
    <script src="../loading.js" defer></script>    <!--loading js-->
    <link rel="stylesheet" type="text/css" href="../loading.css?v=1.0">   <!--loading overlay css-->

      <div class="header"> <?php include '../header.php'; ?></div> <!--HEADER ,DATE, LOGO, TIME-->


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
    position: fixed; /* Position the footer absolutely */
    bottom: 0; /* Stick the footer to the bottom of the body */
    width: 100%; /* Make the footer take up the full width of the body */
    height: 15px; /* Set the footer's height */
    background-color: #333; /* Set the footer's background color */
    color: #fff; /* Set the footer's text color */
    text-align: center; /* Center the footer's text */
    padding: 10px; /* Add some padding to the footer */
    z-index: 1; /* Set the z-index to a high value */
    margin-left: -100px;
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
  </style>  <!--OVERLAY CSS--> <!--OVERLAY CSS--> <!--OVERLAY CSS--> <!--OVERLAY CSS--> <!--OVERLAY CSS--> <!--OVERLAY CSS--> <!--OVERLAY CSS-->

<?php include '../nav-bar.php'; ?>

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
                    <a class="nav-link" href="../home/home.php">
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
                    <a class="nav-link">
                        <span> All Tickets</span>
                        
                    </a>
                </li>
    
                <li class="nav-item active">
                    <a class="nav-link"  href="../in_progress/in_progress.php">
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
                <a class="nav-link"  href="../scheduling/scheduling.php">
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
                <a class="nav-link"  href="../repaired/repaired.php">
                        <span>Repaired Tickets</span>
                    </a>
                </li>

                <li class="nav-item active">
                <a class="nav-link"  href="../closed/closed.php">
                        <span>Closed Tickets</span>
                    </a>
                </li>

                <li class="nav-item active">
                <a class="nav-link"  href="../offices/offices.php">
                        <span>Barangays / Offices</span>
                    </a>
                </li>

                <li class="nav-item active">
                <a class="nav-link"  href="../search/search.php">
                        <span>Search Ticket</span>
                    </a>
                </li>

                <li class="nav-item active">
                <a class="nav-link"  href="../account/accounts.php">
                        <span>Accounts</span>
                    </a>
                </li>

                <li class="nav-item active">
                <a class="nav-link" href="../feedback/feedback.php">
                        <span> Feedback / Comments</span>
                    </a>
                </li>
                
                <li class="nav-item active">
                <a class="nav-link" href="../report/report.php">
                        <span> Reports</span>
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
  <!--TABLE TICKETS SUMMARY-->
  <div style="width: 100%; margin-left: 100px; text-align:center; margin-bottom: 50px; margin-top: 150px;">   <!--FULL TABLE CSS-->



  <table style="display: inline-block; margin: 10px; border: 3px solid black; font-size: 24px;">
    <tr>
      <th style="border-bottom: 1px solid black;">Pending Tickets:</th>   <!--PENDING TICKETS SUMMARY-->
    </tr>
    <tr>
      <td style="border-bottom: 1px solid black;">
      <a href="../home/home.php" style="text-decoration: none; color: #000;">  <!-- Add link to ticket list page -->
        <?php
          $query = "SELECT COUNT(*) AS pending_tickets FROM ticket WHERE status = 'Pending'";
          $result = mysqli_query($conn, $query);
          $row = mysqli_fetch_assoc($result);
          echo $row['pending_tickets'];
        ?>
      </td>
    </tr>

  </table>
  <table style="display: inline-block; margin: 10px; border: 3px solid black; font-size: 24px;">
    <tr>
      <th style="border-bottom: 1px solid black;">In Progress:</th>   <!--IN PROGRESS TICKETS SUMMARY-->
    </tr>
    <tr>
      <td style="border-bottom: 1px solid black;">
      <a href="../in_progress/in_progress.php" style="text-decoration: none; color: #000;">  <!-- Add link to ticket list page -->
        <?php
          $query = "SELECT COUNT(*) AS in_progress FROM ticket WHERE status = 'In Progress'";
          $result = mysqli_query($conn, $query);
          $row = mysqli_fetch_assoc($result);
          echo $row['in_progress'];
        ?>
      </td>
    </tr>
  </table>

  <table style="display: inline-block; margin: 10px; border: 3px solid black; font-size: 24px;">
    <tr>
      <th style="border-bottom: 1px solid black;">Finished Tickets:</th>   <!--FINISHED TICKETS SUMMARY-->
    </tr>
    <tr>
      <td style="border-bottom: 1px solid black;">
      <a href="../repaired/repaired.php" style="text-decoration: none; color: #000;">  <!-- Add link to ticket list page -->
        <?php
          $query = "SELECT COUNT(*) AS finished_tickets FROM ticket WHERE status = 'Repaired'";
          $result = mysqli_query($conn, $query);
          $row = mysqli_fetch_assoc($result);
          echo $row['finished_tickets'];
        ?>
      </td>
    </tr>
  </table>

  <table style="display: inline-block; margin: 10px; border: 3px solid black; font-size: 24px;">
    <tr>
      <th style="border-bottom: 1px solid black;">Closed Tickets:</th>   <!--FINISHED TICKETS SUMMARY-->
    </tr>
    <tr>
      <td style="border-bottom: 1px solid black;">
      <a href="../closed/closed.php" style="text-decoration: none; color: #000;">  <!-- Add link to ticket list page -->
        <?php
          $query = "SELECT COUNT(*) AS finished_tickets FROM ticket WHERE status = 'Closed'";
          $result = mysqli_query($conn, $query);
          $row = mysqli_fetch_assoc($result);
          echo $row['finished_tickets'];
        ?>
      </td>
    </tr>
  </table>

  <table style="display: inline-block; margin: 10px; border: 3px solid black; font-size: 24px;">
    <tr>
      <th style="border-bottom: 1px solid black;">Total Tickets:</th>   <!--TOTAL TICKETS SUMMARY-->
    </tr>
    <tr>
      
      <td style="border-bottom: 1px solid black;">
      
        <?php
          $query = "SELECT COUNT(*) AS total_tickets FROM ticket";
          $result = mysqli_query($conn, $query);
          $row = mysqli_fetch_assoc($result);
          echo $row['total_tickets'];
        ?>
      </td>
    </tr>
  </table>



  <br>
  <br>
  <?php
// SQL query to get serial numbers with total, repaired, closed, and in-progress (including pending) tickets
$sql = "
    SELECT 
        serial_number,
        COUNT(*) AS total_tickets,
        SUM(CASE WHEN status = 'Repaired' THEN 1 ELSE 0 END) AS repaired_tickets,
        SUM(CASE WHEN status = 'Closed' THEN 1 ELSE 0 END) AS closed_tickets,
        SUM(CASE WHEN status = 'In Progress' THEN 1 ELSE 0 END) AS in_progress_tickets
    FROM ticket
    GROUP BY serial_number
    ORDER BY total_tickets DESC
";

$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    echo '<table style="border: 3px solid black; font-size: 18px; width: 80%; margin-top: 20px; margin-left:200px;">';
    echo '<tr>
            <th style="border-bottom: 1px solid black;">Serial Number</th>
            <th style="border-bottom: 1px solid black;">Total Tickets</th>
            <th style="border-bottom: 1px solid black;">Repaired Tickets</th>
            <th style="border-bottom: 1px solid black;">Closed Tickets</th>
            <th style="border-bottom: 1px solid black;">In Progress</th>
            
          </tr>';
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        echo '<td style="border-bottom: 1px solid black;">' . htmlspecialchars($row['serial_number']) . '</td>';
        echo '<td style="border-bottom: 1px solid black; text-align: center;">' . $row['total_tickets'] . '</td>';
        echo '<td style="border-bottom: 1px solid black; text-align: center;">' . $row['repaired_tickets'] . '</td>';
        echo '<td style="border-bottom: 1px solid black; text-align: center;">' . $row['closed_tickets'] . '</td>';
        echo '<td style="border-bottom: 1px solid black; text-align: center;">' . $row['in_progress_tickets'] . '</td>';
        echo '</tr>';
    }
    echo '</table>';
} else {
    echo '<p style="text-align: center; margin-top: 20px;">No data available for serial numbers.</p>';
}
?>


<script>
  
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
</script>

<footer class="footer">
    <h2 class="footer-title">@ All Rights Reserved @</h2>
</footer>

</body>
</php>




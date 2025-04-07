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
    <script src="../../js/dateandtime.js" defer></script>   
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../login/auth.js"></script>  <!--login js authorization-->
    <script src="logout.js" defer></script>    <!--logout overlay js-->
    <link rel="stylesheet" type="text/css" href="logout.css?v=1.0">   <!--logout overlay css-->
    <script src="../loading.js" defer></script>    <!--loading js-->
    <link rel="stylesheet" type="text/css" href="../loading.css?v=1.0">   <!--loading overlay css-->

      <div class="header"> <?php include '../header.php'; ?></div> <!--HEADER ,DATE, LOGO, TIME-->
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
 /* Define specific column widths */
 th:nth-child(1), td:nth-child(1) { width: 6%; } /* Ticket # */
  th:nth-child(2), td:nth-child(2) { width: 10%; } /* Serial # */
  th:nth-child(3), td:nth-child(3) { width: 10%; } /* Date/Time Requested */
  th:nth-child(4), td:nth-child(4) { width: 10%; } /* Office */
  th:nth-child(5), td:nth-child(5) { width: 12%; } /* Requester Name */
  th:nth-child(6), td:nth-child(6) { width: 10%; } /* Unit */
  th:nth-child(7), td:nth-child(7) { width: 10%; } /* Category */
  th:nth-child(8), td:nth-child(8) { width: 12%; } /* Assigned to */
  th:nth-child(9), td:nth-child(9) { width: 10%; } /* Priority */
  th:nth-child(10), td:nth-child(10) { width: 10%; } /* Status */
  th:nth-child(11), td:nth-child(11) { width: 8%; } /* Serial # Record */
  th:nth-child(12), td:nth-child(12) { width: 8%; } /* Edit */
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
          $query = "SELECT COUNT(*) AS incoming FROM ticket WHERE status = 'Pending'";
          $result = mysqli_query($conn, $query);
          $row = mysqli_fetch_assoc($result);
          echo $row['incoming'];
        ?></span> 
                    </a>
                </li>

                <li class="nav-item active">
                <a class="nav-link" href="../ticket/ticket.php">
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
                    <a class="nav-link" >
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
                        <span>Feedback / Comments</span>
                    </a>
                </li>
                
                <li class="nav-item active">
                <a class="nav-link" href="../report/report.php">
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
<a href="filter_repaired.php" style="float: right; margin-right: 300px; margin-top: 20px;">
<button class="arrow-button" style="background-color:#008000; color: #fff; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; display: flex; align-items: center; gap: 8px; font-weight: bold;">
         Filter Ticket&rarr;
    </button>
</a>

<!--TABLE TICKETS SUMMARY-->
<div style="width: 100%; text-align: center;margin-bottom: 50px;">   <!--FULL TABLE CSS-->
<table style="display: inline-block; margin: 10px; border: 3px solid black; font-size: 24px;margin-left: 500px">
    <tr>
      <th style="border-bottom: 1px solid black;">Repaired Tickets:</th>   <!--TOTAL TICKETS SUMMARY-->
    </tr>
    <tr>
      <td style="border-bottom: 1px solid black;">
        <?php
        $query = "SELECT COUNT(*) AS repaired FROM ticket WHERE status = 'Repaired'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        echo $row['repaired'];
        ?>
      </td>
    </tr>
  </table>
<br>
  <br>
  <!--TABLE TICKETS SUMMARY-->

  <div style="display: flex; flex-direction: column; align-items: center; margin-top: 20px; line-height: 1; margin-left: 60px;">
  <label style="font-size: 18px; font-weight: bold; margin-bottom: -130px;">Sort by Date:</label>
  <div style="margin-top: 4px;">
    <select name='date_req_sort' onchange='location.href=this.value' style="font-size: 16px; padding: 5px; width: 120px;">
      <option value="<?php echo $_SERVER['PHP_SELF']; ?>?sort=datetime_req&order=ASC" <?php if ($sort == 'datetime_req' && $order == 'ASC') echo 'selected'; ?>>Oldest</option>
      <option value="<?php echo $_SERVER['PHP_SELF']; ?>?sort=datetime_req&order=DESC" <?php if ($sort == 'datetime_req' && $order == 'DESC') echo 'selected'; ?>>Newest</option>
    </select>
  </div>
</div>

<br>
  <!--TABLE TICKETS SUMMARY-->

<?php
// Get Data from Database
if ($sort == 'datetime_req') {
  $sql = "SELECT t.*, 
                 (SELECT COUNT(*) FROM ticket WHERE serial_number = t.serial_number) AS ticket_count,
                 DATE(t.datetime_req) AS req_date
          FROM ticket t 
          WHERE t.status='Repaired' 
          ORDER BY t.datetime_req " . ($order == 'ASC' ? 'ASC' : 'DESC');
} elseif ($sort == 'priority') {
  $sql = "SELECT t.*, 
                 (SELECT COUNT(*) FROM ticket WHERE serial_number = t.serial_number) AS ticket_count,
                 DATE(t.datetime_req) AS req_date
          FROM ticket t 
          WHERE t.status='Repaired' 
          ORDER BY FIELD(t.priority, 'Low', 'Medium', 'High') " . ($order == 'ASC' ? '' : 'DESC');
} elseif ($sort == 'status') {
  $sql = "SELECT t.*, 
                 (SELECT COUNT(*) FROM ticket WHERE serial_number = t.serial_number) AS ticket_count,
                 DATE(t.datetime_req) AS req_date
          FROM ticket t 
          WHERE t.status='Repaired' 
          ORDER BY FIELD(t.status, 'Pending', 'In Progress', 'Closed') " . ($order == 'ASC' ? '' : 'DESC');
} else {
  $sql = "SELECT t.*, 
                 (SELECT COUNT(*) FROM ticket WHERE serial_number = t.serial_number) AS ticket_count,
                 DATE(t.datetime_req) AS req_date
          FROM ticket t 
          WHERE t.status='Repaired' 
          ORDER BY t.datetime_req DESC";
}

$result = $conn->query($sql);

// Initialize the current date variable
$current_date = '';


$today = date("F / d / Y");
$firstRow = true;

while ($row = $result->fetch_assoc()) {
  $ticket_number = $row["ticket_number"];
  $priority = $row['priority'];
  $status = $row['status'];
  $ticket_date = date("F / d / Y", strtotime($row["req_date"]));

  if ($ticket_date != $current_date) {
    // Close previous table
    if (!$firstRow) {
      echo "</tbody></table></div><br>";
    }

    $current_date = $ticket_date;
    $firstRow = false;



    // Create collapsible for old dates
    if ($ticket_date !== $today) {
      echo "<button onclick=\"toggleVisibility('table_$current_date')\" style='display: block; width: 80%; margin-left: 300px; padding: 10px 20px; text-align: center;'> <span style=\"padding-right: 150px;\">$current_date ▼</span></button>";

      echo "<div id='table_$current_date' style='display: none;'>";
    } else {
      echo "<div>";
      echo "<h3 style='text-align:center; background:#f2f2f2; padding:10px;'>$current_date</h3>";
    }

    echo "<table border='3' style='border-collapse: collapse;width: 80%;font-size: 20px; line-height: 24px; margin-left: 300px;'>";
    echo "<thead><tr>
            <th>Ticket #</th>
            <th>Serial #</th>
            <th>Date/Time Requested</th>
            <th>Office</th>
            <th>Requester Name</th>
            <th>Unit</th>
            <th>Category</th>
            <th>Assigned to</th>
            <th>Priority</th>
            <th>Status</th>
            <th>Serial # Record</th>
            <th>Edit</th>
          </tr></thead><tbody>";
  }

  echo "<tr>";
  echo "<td>" . $row["ticket_number"] . "</td>";
  echo "<td>" . $row["serial_number"] . "</td>";
  echo "<td>" . date("m/d/Y - g:i A", strtotime($row["datetime_req"])) . "</td>";
  echo "<td>" . $row["office"] . "</td>";
  echo "<td>" . $row["req_name"] . "</td>";
  echo "<td>" . $row["unit"] . "</td>";
  echo "<td>" . $row["category"] . "</td>";
  echo "<td>" . $row["assigned_name"] . "</td>";

  echo "<td>";
  if ($priority == "High") {
    echo "<span style='color: #FF0000'>&#9679;</span> High";
  } elseif ($priority == "Medium") {
    echo "<span style='color: #FFA500'>&#9679;</span> Medium";
  } elseif ($priority == "Low") {
    echo "<span style='color: #FFFF80'>&#9679;</span> Low";
  } elseif (is_null($priority) || $priority === "") {
    echo "<span style='color: #808080'>&#9679;</span> Unset";
  }
  echo "</td>";

  echo "<td>" . $row["status"] . "</td>";
  echo "<td>" . $row["ticket_count"] . "</td>";
  echo '<td><a href="#" onclick="openNav(' . $row["ticket_number"] . ')">Edit Priority</a></td>';
  echo "</tr>";
}

if (!$firstRow) {
  echo "</tbody></table></div>";
} else {
  echo "<tr><td colspan='12'>No data found</td></tr>";
}


// Close database connection
$conn->close();
?>

   
  </table>

  </table> <!--TABLE-->
  </div> </div>
</section> <!--BODY-->



<div id="myNav" class="overlay">



<div class="overlay-content">
  <div class="overlay_container">
        <!-- overlay_header with Logo -->
        <div class="overlay_header">
        <img src="../images/cicto_logo.png" alt="Company Logo">
            <h1>City Information and Communications Technology &nbsp; &nbsp;&nbsp;JOB ORDER SLIP</h1>
        </div>

  <form action="" method="post" autocomplete="off">
  <p>Instructions: Please fill out and check the appropriate Box</p>
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>  <!-- close button for overlay -->
  <div class="overlay_form_group">
                <label for="ticket_number">Ticket ID:</label>
                <input type="text" id="ticket_number" name="ticket_number"  value="<?php echo $ticket_data['ticket_number']; ?>" readonly required> <!-- date_req -->
            </div>
            
        <div class="overlay_form_group">
                <label for="serial_number">Serial No.</label>
                <input type="text" id="serial_number" name="serial_number"  value="<?php echo $ticket_data['serial_number']; ?>" readonly required> <!-- serial_number -->
            </div>

          <div class="overlay_form_group">
                <label for="datetime_req">Date and TIme Requested</label>
                <input type="datetime-local" id="datetime_req" name="datetime_req"  value="<?php echo $ticket_data['datetime_req']; ?>" readonly required>    <!-- date requested -->
            </div>

          <div class="overlay_form_group">
                <label for="id_number">Employee ID</label>
                <input type="text" id="id_number" name="id_number" value="<?php echo $ticket_data['id_number']; ?>" readonly required> <!-- id_number -->
            </div>
          <div class="overlay_form_group">
                <label for="req_name">Requester Name</label>
                <input type="text" id="req_name" name="req_name" value="<?php echo $ticket_data['req_name']; ?>" readonly required> <!-- ful name -->
            </div>
          <div class="overlay_form_group">
                <label for="office">Office</label>
                <input type="text" id="office" name="office" value="<?php echo $ticket_data['office']; ?>" readonly required> <!-- office -->
            </div>
          <div class="overlay_form_group">
                <label for="phone_number">Phone Number:</label>
                <input type="text" id="phone_number" name="phone_number"  value="<?php echo $ticket_data['phone_number']; ?>"readonly required> <!-- phone_number -->
            </div>
            <div class="overlay_form_group">
                <label for="email">Email Address</label>
                <input type="text" id="email" name="email"  value="<?php echo $ticket_data['email']; ?>"readonly required> <!-- email -->
            </div>
            <div class="overlay_form_group">
                <label for="subject">Subject</label>
                <input type="text" id="subject" name="subject"   value="<?php echo $ticket_data['subject']; ?>" readonly required><!-- subject -->
            </div>
   
 <!-- Department and Barangay Selection -->
          
 <div class="overlay_form_group">
            
            </div>
           
            <div class="overlay_form_group">
                <label for="unit">Select Device:</label>
                <input type="text" id="unit" name="unit"   readonly required> <!-- unit -->
            </div>

            <div class="overlay_form_group">
                <label for="category">Category:</label>
                <input type="text" id="category" name="category"   readonly required> <!-- unit -->
            </div>

     <!-- Accessories Table -->
     <div class="overlay_form_group">
                <label>Accessories:</label><!-- accessories -->
                <input type="text" id="accessories" name="accessories"   readonly required> <!-- unit -->
            </div>
            <!-- Additional Repair Information -->
            <div class="overlay_form_group">
                <label for="item_date_received">Item Date Received:</label><!-- item_date_received -->
                <input type="date" id="item_date_received" name="item_date_received" value="<?php echo $item_date_received; ?>" readonly>
            </div>

            <div class="overlay_form_group">
                <label for="received_by">Received by:</label><!-- received_by -->
                <input type="text" id="received_by" name="received_by" value="<?php echo $received_by; ?>" readonly>
            </div>

            <div class="overlay_form_group">
                <label for="assigned_name">Name of Technician:</label>
                <input type="text" id="assigned_name" name="assigned_name" value="<?php echo $assigned_name; ?>" readonly><!-- assigned_name -->
            </div>

            <div class="overlay_form_group">
                <label for="diagnostic">Diagnostic:</label>
                <input type="text" id="diagnostic" name="diagnostic" value="<?php echo $diagnostic; ?>" readonly><!-- diagnostic-->
            </div>

            <div class="overlay_form_group">
    <label for="status">Priority:</label>
    <input id="priority" name="priority" value="<?php echo $priority; ?>" readonly><!-- status-->
    </input>
</div>

            <div class="overlay_form_group">
                <label for="status">Status:</label>
                <input id="status" name="status" value="<?php echo $status; ?> " readonly><!-- status-->
                </input>
            </div>

            <div class="overlay_form_group">
                <label for="comment">Recommendation:</label>
                <input type="text" id="comment" name="comment" value="<?php echo $comment; ?>"readonly><!-- comment -->
            </div>

            <div class="overlay_form_group">
                <label for="approved_by">Approved for Release by:</label>
                <input type="text" id="approved_by" name="approved_by"  value="<?php echo $approved_by; ?>"readonly><!-- approved_by -->
            </div>

            <div class="overlay_form_group">
                <label for="release_date">Release Date:</label>
                <input type="date" id="release_date" name="release_date"  value="<?php echo $release_date; ?>"readonly><!-- release_date -->
            </div>
            <div class="overlay_form_group">
    <label>Image:</label>
    <img id="image" src="" alt="Image" style="max-width: 80%; height: auto; object-fit: contain;">
</div>
            <br>
            <br>
            <H3><u>ERWIN G. MANADAO</u></H3>
            <p>CICTO Department head</p>
     
      
    <div class="overlay_form_group">
      <br>
      <div style="display: flex; justify-content: space-between; width: 100%; padding: 10px;">
        
        <button onclick="printTicket()" 
                style="background-color: #008CBA; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">
          Print Ticket
        </button>
  
</form>
    </div>
    </div>


  </div>
</div>
<script>
function printTicket() {
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

function toggleVisibility(id) {
  const elem = document.getElementById(id);
  if (elem.style.display === "none") {
    elem.style.display = "block";
  } else {
    elem.style.display = "none";
  }
}

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
        url: 'fetch_ticket.php',
        
        data: {ticket_number: ticketNumber, table_name: 'ticket'},
        cache: false, // Add this to prevent caching
        success: function(data) {
            // Populate form fields with fetched data
            var ticketDetails = JSON.parse(data);
            document.getElementById('ticket_number').value = ticketDetails.ticket_number;
            document.getElementById('serial_number').value = ticketDetails.serial_number;
            document.getElementById('datetime_req').value = ticketDetails.datetime_req;
            document.getElementById('id_number').value = ticketDetails.id_number;
            document.getElementById('req_name').value = ticketDetails.req_name;
            document.getElementById('office').value = ticketDetails.office;
            document.getElementById('phone_number').value = ticketDetails.phone_number;
            document.getElementById('email').value = ticketDetails.email;
            document.getElementById('subject').value = ticketDetails.subject;
            document.getElementById('unit').value = ticketDetails.unit;
            document.getElementById('category').value = ticketDetails.category;
            document.getElementById('accessories').value = ticketDetails.accessories;
            document.getElementById('item_date_received').value = ticketDetails.item_date_received;
            document.getElementById('received_by').value = ticketDetails.received_by;
            document.getElementById('assigned_name').value = ticketDetails.assigned_name;
            document.getElementById('diagnostic').value = ticketDetails.diagnostic;
            document.getElementById('priority').value = ticketDetails.priority;
            document.getElementById('status').value = ticketDetails.status;
            document.getElementById('comment').value = ticketDetails.comment;
            document.getElementById('approved_by').value = ticketDetails.approved_by;
            document.getElementById('release_date').value = ticketDetails.release_date;
            document.getElementById('image').value = ticketDetails.image;
                         // Display the image
                         var imageBase64 = ticketDetails['image'];
            var imageElement = document.getElementById('image');
            imageElement.src = 'data:image/jpeg;base64,' + imageBase64;
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

function closeNav() {
    document.getElementById("myNav").style.height = "0";
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
</script>


</body>
</php>



<footer class="footer">
    <h2 class="footer-title">@ All Rights Reserved @</h2>
</footer>





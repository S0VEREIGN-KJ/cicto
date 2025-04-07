<?php 
include ('../login/check_admin.php');  //check admin login
include ('db_conn.php');  //check admin login

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
    <link rel="stylesheet" type="text/css" href="../dashboard.css?v=1.0">          <!--dashboard css-->
    <link rel="stylesheet" type="text/css" href="../../css/dateandtime.css?v=1.0">     <!--date and time css-->
    <script src="../../js/dateandtime.js" defer></script>            <!--date and time javascript-->
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
.content-main-body {
margin-left: 300px;
  overflow-x: hidden;
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

/* Date Range Picker */
#daterange {
  padding: 10px;
  font-size: 16px;
  border: 1px solid #ccc;
  border-radius: 4px;
  margin-bottom: 10px;
  width: 20%;
  box-sizing: border-box;
}

#fetch-tickets-btn {
  background-color: #4CAF50;
  color: white;
  border: none;
  border-radius: 4px;
  padding: 12px 20px;
  font-size: 16px;
  cursor: pointer;
  transition: background-color 0.3s ease;
  width: 10%;
  box-sizing: border-box;
  margin-top: 10px;
}

#fetch-tickets-btn:hover {
  background-color: #45a049;
}

/* Table Styling */
#ticket-table {
  width: 90%;
  margin-top: 20px;
  border-collapse: collapse;
}

#ticket-table th, #ticket-table td {
  padding: 12px;
  text-align: left;
  border: 1px solid #ddd;
  min-width: 100px; /* Ensures columns don’t shrink too small */
  width: auto; /* Allow the column width to adjust based on content */
}

#ticket-table th {
  background-color: #2c3e50;
  color: white;
}

#ticket-table td {
  background-color: #ecf0f1;
}

/* Responsive layout */
@media (max-width: 768px) {
  .sidebar {
    width: 100%;
    height: auto;
  }

  .content-main-body {
    margin-left: 0;
  }

  #daterange {
    width: 100%;
  }
}

</style> 


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
          $feedbackResult = mysqli_query($conn, $query);
          $row = mysqli_fetch_assoc($feedbackResult);
          echo $row['pending'];
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
          $feedbackResult = mysqli_query($conn, $query);
          $row = mysqli_fetch_assoc($feedbackResult);
          echo $row['in_progress'];
        ?></span> 
                    </a>
                </li>

                <li class="nav-item active">
                <a class="nav-link"  href="../scheduling/scheduling.php">
                        <span>Scheduled Tickets</span>
                        <span class="badge scheduled">    <?php
          $query = "SELECT COUNT(*) AS scheduled FROM ticket WHERE status = 'Scheduled'";
          $feedbackResult = mysqli_query($conn, $query);
          $row = mysqli_fetch_assoc($feedbackResult);
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
<div class="confirm-overlay" id="confirm-overlay">
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
        <!-- Date Range Picker -->
        <div id="date-range-picker">
            <label for="daterange">Select Date Range</label>
            <input type="text" id="daterange" name="daterange" readonly />
            <button id="fetch-tickets-btn" onclick="fetchTickets()">OK</button>
      
            <a href="technician/show_technician.php">
    <button id="create-tech-report-btn" style="float: right; margin-right: 250px;margin-top: 10px; background-color: #4CAF50; color: white; border: none; padding: 10px 20px; font-size: 16px; cursor: pointer;">
    👤Create Tech Report
    </button>
</a>

<a href="condemn/condemn.php">
    <button id="create-tech-report-btn" style="float: right; margin-right: 100px;margin-top: 10px; background-color: #4CAF50; color: white; border: none; padding: 10px 20px; font-size: 16px; cursor: pointer;">
    📜Certificate of Condemn
    </button>
</a>

        </div>

<!-- Table to Display Tickets -->
<div id="ticket-list">
    <h2>Tickets <span id="selected-date-range"></span></h2> <!-- Placeholder for the date range description -->

    <?php if (isset($report)) : ?>
      <!-- Display the generated report -->
      <div id="report-summary">
      
      </div>
    <?php else: ?>
      <p>Please select a date range to generate the report.</p>
    <?php endif; ?>
</div>


    <table id="ticket-table">
       
    
  
        <tbody></tbody>
    </table>
</div>

    </div>


<script>
$(document).ready(function() {
    // Initialize the Date Range Picker
    $('#daterange').daterangepicker({
        locale: {
            format: 'YYYY-MM-DD', // Date format
        },
        opens: 'center', // Popup position
        autoUpdateInput: false, // Don't update the input field automatically
        minDate: '2024-01-01', // Minimum date (2024 onwards)
        maxDate: moment().add(10, 'years'), // Maximum date (10 years ahead)
        ranges: {
            'Today': [moment(), moment()],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
            'This Year': [moment().startOf('year'), moment().endOf('year')],
            'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')],
        }
    });

    // When a date range is applied, update the input field and the display
    $('#daterange').on('apply.daterangepicker', function(ev, picker) {
        const startDate = picker.startDate.format('YYYY-MM-DD');
        const endDate = picker.endDate.format('YYYY-MM-DD');

        // Optionally update the input field (if you want to show it there too)
        $(this).val(startDate + ' to ' + endDate);

        // Determine the selected date range
        let rangeText = '';
        const selectedRange = $(this).val();

        // Handle specific predefined ranges like "Today" and "Last 7 Days"
        if (selectedRange === 'Today') {
            rangeText = 'for Today';
        } else if (selectedRange === 'Last 7 Days') {
            rangeText = 'for the Last 7 Days';
        } else if (selectedRange === 'This Year') {
            const year = picker.startDate.format('YYYY');
            rangeText = `for ${year}`;
        } else if (selectedRange === 'Last Year') {
            const year = picker.startDate.format('YYYY');
            rangeText = `for ${year}`;
        } else {
            const startMonth = picker.startDate.format('MMMM'); // Full month name
            const startYear = picker.startDate.format('YYYY'); // Year
            const endMonth = picker.endDate.format('MMMM'); // Full month name (if different month)
            
            if (startMonth === endMonth) {
                rangeText = `for ${startMonth} ${startYear}`;
            } else {
                rangeText = `from ${startMonth} ${startYear} to ${endMonth} ${startYear}`;
            }
        }

        // Update the <h2> to show the selected range
        $('#selected-date-range').text(rangeText);
    });

    // Show the Date Range Picker automatically on page load
    $('#date-range-picker').show();
});

// Fetch tickets based on selected date range
function fetchTickets() {
    const selectedRange = $('#daterange').val().split(' to ');
    const startDate = selectedRange[0];
    const endDate = selectedRange[1];

    $.ajax({
        url: 'fetch_ticket.php',
        type: 'POST',
        data: {
            startDate: startDate,
            endDate: endDate
        },
        success: function(response) {
            $('#ticket-table tbody').html(response);
        }
    });
}

</script>



</body>


<footer class="footer">
    @ All Rights Reserved @
</footer>

</php>








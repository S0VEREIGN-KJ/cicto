<?php 
include('../login/check_admin.php');  // Check admin login
include('db_conn.php');  // Database connection

if (isset($_GET['url'])) {
    $url = $_GET['url'];
    header('Location: ' . $url);
    exit;
}

// Query for feedback
$query = "SELECT full_name, feedback FROM feedback";
$feedback = mysqli_query($conn, $query);

// Error handling for query execution
if (!$feedback) {
    die('<p style="color:red;">Query failed: ' . mysqli_error($conn) . '</p>');
}

// Count the number of rows
$num_rows = mysqli_num_rows($feedback);
if ($num_rows == 0) {
    $noFeedbackMessage = "<p>No feedback available.</p>";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrator</title>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
#content-main-body {
  overflow-x: hidden;
  width: 100%;
  padding-top: 1rem;
  padding-bottom: 80px;
  flex: 1; /* Make the content wrapper take up the remaining space */
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
       /* Table Styles */
       table {
            width: 80%;
            margin: 50px auto;
            border-collapse: collapse;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
            background-color: #ffffff;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            transition: background-color 0.3s;
        }

        th {
            background-color: #4CAF50; /* Header background color */
            color: white; /* Header text color */
            font-weight: bold;
        }

        tr:hover {
            background-color: #f1f1f1; /* Row hover color */
        }

        /* Alternate row colors */
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:nth-child(odd) {
            background-color: #ffffff;
        }

        /* Responsive Design */
        @media (max-width: 600px) {
            table {
                width: 100%;
            }
            th, td {
                padding: 10px;
            }
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
                <a class="nav-link">
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

<a href="print.php" target="_blank" style="float: right; margin-right: 450px; margin-top: 20px;">
    <button class="arrow-button" style="background-color: #ADD8E6; color: #000; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; display: flex; align-items: center; gap: 8px; font-weight: bold;">
    🖨️ Print Feedback
    </button>
</a>




    <div style="width: 100%; margin-left: 100px; text-align: center; margin-bottom: 50px;">
        <h2 style="text-align: center;
            color: #333;
            margin-left: 600px;">Feedback / Comments</h2>
        <table style="width: 80%; margin: auto; border-collapse: collapse; text-align: left;">
            <thead>
                <tr>
                <th style="border: 1px solid #ddd; padding: 8px; width: 80%;">Feedback to the Service / Ticket</th>
                    <th style="border: 1px solid #ddd; padding: 8px; width: 20%;">The Technician</th>
          
                </tr>
            </thead>
            <tbody>
                <?php
                if ($num_rows > 0) {
                    while ($row = mysqli_fetch_assoc($feedback)) {
                        echo "<tr>
                            <td>" . htmlspecialchars($row['feedback']) . "</td>
                            <td>" . htmlspecialchars($row['full_name']) . "</td>
                        </tr>";
                    }
                } else {
                    echo "<tr>
                        <td colspan='2' style='text-align:center;'>No feedback available.</td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

  </div> </div>

<script>

const token = localStorage.getItem('token');
isAuthenticated().then((response) => {
  if (response) {
    // User is authenticated, allow access to dashboard page
  } else {
    // User is not authenticated, redirect to login form page
    window.location.replace('/login');
  }
}).catch((error) => {
  console.error(error);
});

            // Check if the page is already open
            if (window.opener && window.opener.location.href == window.location.href) {
                // If the page is already open, close this window
                window.close();
            } else {
                // If the page is not already open, set the opener to this window
                window.opener = window;
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


</script>


</body>


<footer class="footer">
    @ All Rights Reserved @
</footer>

</php>







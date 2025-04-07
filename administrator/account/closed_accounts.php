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
   
    <link rel="stylesheet" type="text/css" href="../dashboard.css?v=1.1">          <!--dashboard css-->
    <link rel="stylesheet" type="text/css" href="../../css/dateandtime.css?v=1.1">     <!--date and time css-->
    <script src="../../js/dateandtime.js" defer></script>            <!--date and time javascript-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../login/auth.js"></script>  <!--login js authorization-->
    <script src="logout.js" defer></script>    <!--logout overlay js-->
    <link rel="stylesheet" type="text/css" href="logout.css?v=1.1">   <!--logout overlay css-->
    <script src="../loading.js" defer></script>    <!--loading js-->
    <link rel="stylesheet" type="text/css" href="../loading.css?v=1.1">   <!--loading overlay css-->


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
  margin-bottom: -5px;
  margin-left: -283px;
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


<a href="users_account.php" style="float: left; margin-left: 300px; margin-top: 20px; text-decoration: none;">
    <button class="arrow-button" style="background-color:#AA0000; color: #fff; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; display: flex; align-items: center; gap: 8px; font-weight: bold;">
        &larr; Open Accounts
    </button>
</a>


<h2 style="
    font-size: 24px;
    color: #FF0000; /* Red to signify closed */
    text-transform: uppercase;
    font-weight: bold;
    background-color: #FFEDED; /* Light red background */
    padding: 10px;
    border-radius: 5px;
    border: 2px solid #FF0000;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    margin-left: auto;
    margin-right: auto;
    display: block;
    width: fit-content;
">
    CLOSED Accounts
</h2>



  <!--TABLE TICKETS SUMMARY-->
  <div style=" margin-left: 280px; text-align: center; margin-bottom: 50px; margin-top: 100px; margin-right: 50px;">
  
  <?php
  // SQL query to get the count of accounts for each office
  $query = "SELECT office, COUNT(*) AS total_accounts 
  FROM account 
  WHERE deleted = 1  -- show deleted accounts
  GROUP BY office 
  ORDER BY total_accounts DESC";
  
  $result = mysqli_query($conn, $query);

  while ($row = mysqli_fetch_assoc($result)) {
    $office = $row['office'];
    $total_accounts = $row['total_accounts'];
    ?>
     <a href="show_closed.php?office=<?=$office?>">
    <table style="display: inline-block; margin: 10px; border: 3px solid black; font-size: 24px;">
      <tr>
        <th style="border-bottom: 1px solid black;" colspan="2"><?=$office?>:</th>
      </tr>
      <tr>
        <td style="border-bottom: 1px solid black;"><?=$total_accounts?> Accounts</td>
      </tr>
    </table>
    <?php
  }
  ?>
  
  <br><br>

 

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

<footer>
    <h2 class="footer">@ All Rights Reserved @</h2>
</footer>

</body>
</php>




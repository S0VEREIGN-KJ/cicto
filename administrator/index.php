<?php


if (isset($_GET['url'])) {
    $url = $_GET['url'];
    header('Location: ' . $url);
    exit;
}

header_remove('ETag');
header_remove('Pragma');
header_remove('Cache-Control');
header_remove('Last-Modified');
header_remove('Expires');
ini_set('opcache.enable', 0);

// Start the session
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrator</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   
    <link rel="stylesheet" type="text/css" href="dashboard.css?v=1.0">          <!--dashboard css-->
    <link rel="stylesheet" type="text/css" href="../css/dateandtime.css?v=1.0">     <!--date and time css-->
    <script src="../js/dateandtime.js" defer></script>            <!--date and time javascript-->
    <script src="../jQuery.js"></script>
    
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
.header {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  background-color: #f0f0f0;
  padding: 20px;
  text-align: center;
  z-index: 1;
  height:160px;
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
    height: 25px; /* Set the footer's height */
    background-color: #333; /* Set the footer's background color */
    color: #fff; /* Set the footer's text color */
    text-align: center; /* Center the footer's text */
    padding: 10px; /* Add some padding to the footer */
    z-index: 1; /* Set the z-index to a high value */
}
.footer-title {
  font-size: 12px; /* Set the font size to 24px */
}
    </style>
    <?php include 'nav-bar.php'; ?>

<body>



        <div class="dashboard">
            <ul class="sidebar navbar-nav">
                <h3>Dashboard</h3>
                <li class="nav-item active">
                    <a class="nav-link" href="#" onclick="loadContent('home.php'); return false;">
                        <span> Home</span>
                    </a>
                </li>

                <li class="nav-item active">
                    <a class="nav-link" href="#" onclick="loadContent('ticket.php'); return false;">
                        <span> All Tickets</span>
                    </a>
                </li>
    
                <li class="nav-item active">
                    <a class="nav-link" href="#" onclick="loadContent('open.php'); return false;">
                        <span> Open</span>
                    </a>
                </li>

                <li class="nav-item active">
                    <a class="nav-link" href="#" onclick="loadContent('closed.php'); return false;">
                        <span> Closed</span>
                    </a>
                </li>

                <li class="nav-item active">
                    <a class="nav-link" href="#" onclick="loadContent('pending.php'); return false;">
                        <span> Pending</span>
                    </a>
                </li>

                <li class="nav-item active">
                    <a class="nav-link" href="#" onclick="loadContent('unassigned.php'); return false;">
                        <span> Unassigned</span>
                    </a>
                </li>
                
                <li class="nav-item active">
                    <a class="nav-link" href="#" onclick="loadContent('barangays_offices.php'); return false;">
                        <span> Barangays/ Offices</span>
                    </a>
                </li>
            </ul>
        </div>
        <div id="content-loader"></div>
    </div>
</div>

<script>

function loadContent(url) {
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

        </ul>


     </div>

 
   
    </div>
    
    </div>
    </div>
    
  
    <footer class="footer">
    <h2 class="footer-title">@ All Rights Reserved @</h2>
</footer>
</body>

</php>

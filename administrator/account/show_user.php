<?php 
include ('../login/check_admin.php');

if (isset($_GET['url'])) {
    $url = $_GET['url'];
    header('Location: ' . $url);
    exit;
}

// Check if office parameter is set
$office = isset($_GET['office']) ? $_GET['office'] : '';

// Prepare the SQL query to get user account details filtered by office
$query = "SELECT id_number, full_name, phone_number, email, office 
          FROM account 
          WHERE deleted = 0 AND account_activation_hash IS NULL";   // Exclude deleted accounts

if ($office) {
    $query .= " AND office = '" . mysqli_real_escape_string($conn, $office) . "'"; // Use AND to add office filter
}
$query .= " ORDER BY office";
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
h2 {
            font-size: 24px; /* Set the font size */
            color: #333; /* Dark gray color for the text */
            margin: 20px 0; /* Margin above and below the heading */
            padding: 10px; /* Padding inside the heading */
            text-align: center; /* Center the text */
            font-weight: bold; /* Make the text bold */
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
    margin-left: -150px;
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

/* Unique Overlay Styles */
.custom-overlay {
    display: none; /* Initially hidden */
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.6); /* Darker semi-transparent background */
    backdrop-filter: blur(5px); /* Adds a background blur */
    justify-content: center;
    align-items: center;
    z-index: 1000;
    animation: customFadeIn 0.3s ease; /* Fade-in animation */
}

.custom-overlay-content {
    background: linear-gradient(135deg, #ffffff, #f0f4f8); /* Gradient background */
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.15); /* Soft shadow */
    text-align: left;
    width: 90%;
    max-width: 400px;
    animation: customSlideDown 0.3s ease; /* Slide-down animation */
}

@keyframes customFadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes customSlideDown {
    from { transform: translateY(-20px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

.custom-overlay h3 {
    font-size: 1.5rem;
    color: #333;
    margin-bottom: 1rem;
}

.custom-overlay p {
    font-size: 1rem;
    color: #555;
    margin: 0.5rem 0;
}

.custom-overlay-close-btn {
    display: inline-block;
    margin-top: 15px;
    background-color: #007bff;
    color: white;
    border: none;
    padding: 10px 15px;
    cursor: pointer;
    border-radius: 8px;
    font-size: 0.9rem;
    transition: background-color 0.3s;
    width: 48%;
    margin-right: 4%;
}

.custom-overlay-close-btn:hover {
    background-color: #0056b3;
}

.custom-overlay-delete-btn {
    background-color: #dc3545; /* Red color for delete */
}

.custom-overlay-delete-btn:hover {
    background-color: #c82333;
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
<?php include '../nav-bar.php'; ?>
<body>

   
<div class="dashboard">
            <ul class="sidebar navbar-nav">
                <h3>Dashboard</h3>               
                <li class="nav-item active">
        <a class="nav-link" href="../home/home.php">
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
        <a class="nav-link" href="../ticket/ticket.php">
            <span> All Tickets</span>
        </a>
    </li>

    <li class="nav-item active">
        <a class="nav-link" href="../in_progress/in_progress.php">
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
        <a class="nav-link" href="../scheduling/scheduling.php">
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
                <a class="nav-link">
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
    
<a href="users_account.php" style="float: left; margin-left: 300px; margin-top: 20px;">
<button class="arrow-button" style="background-color:#AA0000; color: #fff; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; display: flex; align-items: center; gap: 8px; font-weight: bold;">
        &larr; Back
    </button>
</a>


<br>
<br>
<h2>User Accounts for Office: <?= htmlspecialchars($office) ?></h2>
<div class="user-list">
    <?php
    // Fetch and display each row as clickable items
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $id_number = htmlspecialchars($row['id_number']);
            $full_name = htmlspecialchars($row['full_name']);
            $phone_number = htmlspecialchars($row['phone_number']);
            $email = htmlspecialchars($row['email']);
            $office = htmlspecialchars($row['office']);
            ?>
            <div class="user-item" onclick="openOverlay('<?= $id_number ?>', '<?= $full_name ?>', '<?= $phone_number ?>', '<?= $email ?>', '<?= $office ?>')">
                <?= $full_name ?>
            </div>
            <?php
        }
    } else {
        echo "<p>No user accounts found for this office.</p>";
    }
    ?>
</div>
<!-- User Details Overlay -->
<div class="custom-overlay" id="overlay">
    <div class="custom-overlay-content" id="overlay-content">
        <h3>User Details</h3>
        <p><strong>ID:</strong> <span id="user-id"></span></p>
        <p><strong>Name:</strong> <span id="user-name"></span></p>
        <p><strong>Phone Number:</strong> <span id="user-phone"></span></p>
        <p><strong>Email:</strong> <span id="user-email"></span></p>
        <p><strong>Office:</strong> <span id="user-office"></span></p>
        <button class="custom-overlay-close-btn" onclick="closeOverlay()">Close</button>
        <button class="custom-overlay-close-btn custom-overlay-delete-btn" id="delete-btn" onclick="showAuthForm()">Delete Account</button>
    </div>
</div>

<!-- Authorization Overlay -->
<div class="custom-overlay" id="auth-overlay">
    <div class="custom-overlay-content" id="auth-overlay-content">
        <h3>Admin Authorization</h3>
        <p>Please enter your username and password to delete this account:</p>
        <input type="text" id="admin-username" placeholder="Username" required autocomplete="off" />
        <input type="password" id="admin-password" placeholder="Password" required  autocomplete="off"/>
        <button class="custom-overlay-close-btn" onclick="closeAuthOverlay()">Cancel</button>
        <button class="custom-overlay-close-btn custom-overlay-delete-btn" onclick="confirmDelete()">Confirm Delete</button>
    </div>
</div>
<!-- Confirmation Overlay -->
<div class="custom-overlay" id="confirm-delete-overlay">
    <div class="custom-overlay-content" id="confirm-delete-content">
        <h3>Confirm Deletion</h3>
        <p>Are you sure you want to delete this account?</p>
        <button class="custom-overlay-close-btn" onclick="closeConfirmDeleteOverlay()">No</button>
        <button class="custom-overlay-close-btn custom-overlay-delete-btn" id="confirm-delete-btn" onclick="executeDelete()">Yes</button>
    </div>
</div>


</div>
<script>
    let currentUserId; // Store the current user's ID for deletion

    function openOverlay(id, name, phone, email, office) {
        currentUserId = id; // Set the current user ID for deletion
        document.getElementById('user-id').innerText = id;
        document.getElementById('user-name').innerText = name;
        document.getElementById('user-phone').innerText = phone;
        document.getElementById('user-email').innerText = email;
        document.getElementById('user-office').innerText = office;
        document.getElementById('overlay').style.display = 'flex'; // Show the user details overlay
    }

    function closeOverlay() {
        document.getElementById('overlay').style.display = 'none';
    }

    function showAuthForm() {
        closeOverlay(); // Hide the user details overlay
        document.getElementById('auth-overlay').style.display = 'flex'; // Show the authorization overlay
    }

    function closeAuthOverlay() {
        document.getElementById('auth-overlay').style.display = 'none';
    }

    function confirmDelete() {
    const username = document.getElementById('admin-username').value;
    const password = document.getElementById('admin-password').value;

    // Validate inputs
    if (!username || !password) {
        alert("Please enter both username and password.");
        return;
    }

    // Send AJAX request to validate credentials
    $.post("validate_admin.php", { username: username, password: password }, function(response) {
        if (response.success) {
            // Hide the authorization overlay
            closeAuthOverlay();
            // Show the confirmation overlay if credentials are valid
            document.getElementById('confirm-delete-overlay').style.display = 'flex';
        } else {
            alert(response.message); // Show error message if credentials are invalid
        }
    }, "json").fail(function(jqXHR, textStatus, errorThrown) {
        console.error("AJAX Error: " + textStatus + ": " + errorThrown);
        alert("Failed to validate credentials. Please try again.");
    });
}


    function closeConfirmDeleteOverlay() {
        document.getElementById('confirm-delete-overlay').style.display = 'none';
    }
    function executeDelete() {
    const username = document.getElementById('admin-username').value;
    const password = document.getElementById('admin-password').value;

    // Check if username and password are provided
    if (!username || !password) {
        alert("Please enter both username and password.");
        return;
    }

    // Redirect to the delete script with authorization
    window.location.href = 'delete_account.php?id=' + currentUserId + '&username=' + encodeURIComponent(username) + '&password=' + encodeURIComponent(password);
}
</script>

</script>

</body>
</html>

<?php
// Close database connection
mysqli_close($conn);
?>

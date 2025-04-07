<?php
header_remove('ETag');
header_remove('Pragma');
header_remove('Cache-Control');
header_remove('Last-Modified');
header_remove('Expires');
ini_set('opcache.enable', 0);

// Start the session
session_start();

?>
<style>

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
.overlay .closebtn:hover {
    background-color:  #FF0000;
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
</style>
<form>
<a href="#" onclick="openNav()">Details</a>
</form>
<div id="myNav" class="overlay">

  <link rel="stylesheet" href="../ticket_flow/.css"> <!-- Link to the external CSS file -->
  <div class="overlay-content">
  <div class="overlay_container">
        <!-- overlay_header with Logo -->
        <div class="overlay_header">
            <img src="../images/logo.jpg" alt="Company Logo">
            <h1>City Information and Communications Technology &nbsp; &nbsp;&nbsp;JOB ORDER SLIP</h1>
        </div>

  <form action="submit_ticket.php" method="post" autocomplete="off">
  <p>Instructions: Please fill out and check the appropriate Box</p>
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <div class="overlay_form_group">
    
                <label for="ticket_number">Ticket ID:</label>
                <input type="text" id="ticket_number" name="ticket_number" value="<?php echo $ticket_number; ?>" readonly required> <!-- date_req -->
            </div>
        <div class="overlay_form_group">
                <label for="serial_number">Serial No.</label>
                <input type="text" id="serial_number" name="serial_number" value="<?php echo $serial_number; ?>" readonly required> <!-- serial_number -->
            </div>

          <div class="overlay_form_group">
                <label for="date_req">Date Requested</label>
                <input type="date" id="date_req" name="date_req" value="<?php echo $date_req; ?>" readonly required>    <!-- date requested -->
            </div>

          <div class="overlay_form_group">
                <label for="time_req">Time Requested</label>
                <input type="time" id="time_req" name="time_req" value="<?php echo $time_req; ?>" readonly required> <!-- time_req -->
            </div>
          <div class="overlay_form_group">
                <label for="id_number">Employee ID</label>
                <input type="text" id="id_number" name="id_number" value="<?php echo $id_number; ?>" readonly required> <!-- id_number -->
            </div>
          <div class="overlay_form_group">
                <label for="req_name">Requester Name</label>
                <input type="text" id="req_name" name="req_name" value="<?php echo $full_name; ?>" readonly required> <!-- ful name -->
            </div>
          <div class="overlay_form_group">
                <label for="office">Office</label>
                <input type="text" id="office" name="office" value="<?php echo $office; ?>" readonly required> <!-- office -->
            </div>
          <div class="overlay_form_group">
                <label for="phone_number">Phone Number:</label>
                <input type="text" id="phone_number" name="phone_number" value="<?php echo $phone_number; ?>" readonly required> <!-- phone_number -->
            </div>
            <div class="overlay_form_group">
                <label for="email">Email Address</label>
                <input type="text" id="email" name="email" value="<?php echo $email; ?>" readonly required> <!-- email -->
            </div>
            <div class="overlay_form_group">
                <label for="subject">Subject</label>
                <input type="text" id="subject" name="subject"  value="<?php echo $subject; ?>" readonly required><!-- subject -->
            </div>
   
 <!-- Department and Barangay Selection -->
          
 <div class="overlay_form_group">
            <label for="office" required>Office:</label>
            <input type="text" id="office" name="office"  value="<?php echo $office; ?>" readonly required> <!-- office -->
            </div>
           
            <div class="overlay_form_group">
                <label for="unit">Select Device:</label>
                <input type="text" id="unit" name="unit"  value="<?php echo $unit; ?>" readonly required> <!-- unit -->
            </div>

            <div class="overlay_form_group">
                <label for="category">Category:</label>
                <input type="text" id="category" name="category"  value="<?php echo $category; ?>" readonly required> <!-- unit -->
            </div>

     <!-- Accessories Table -->
     <div class="overlay_form_group">
                <label>Accessories:</label><!-- accessories -->
                <input type="text" id="accessories" name="accessories"  value="<?php echo $accessories; ?>" readonly required> <!-- unit -->
            </div>
            <!-- Additional Repair Information -->
            <div class="overlay_form_group">
                <label for="date_received">Date Received:</label><!-- date_received -->
                <input type="date" id="date_received" name="date_received">
            </div>

            <div class="overlay_form_group">
                <label for="received_by">Received by:</label><!-- received_by -->
                <input type="text" id="received_by" name="received_by">
            </div>

            <div class="overlay_form_group">
                <label for="assign_name">Name of Technician:</label>
                <input type="text" id="assign_name" name="assign_name"><!-- assign_name -->
            </div>

            <div class="overlay_form_group">
                <label for="diagnostic">Diagnostic:</label>
                <input type="text" id="diagnostic" name="diagnostic"><!-- diagnostic-->
            </div>

            <div class="overlay_form_group">
                <label for="status">Status:</label>
                <select id="status" name="status"><!-- status-->
                    <option disabled selected> </option>
                    <option value="repaired">Repaired</option>
                    <option value="not_repaired">Not Repaired</option>
                </select>
            </div>

            <div class="overlay_form_group">
                <label for="comment">Recommendation:</label>
                <input type="text" id="comment" name="comment"><!-- comment -->
            </div>

            <div class="overlay_form_group">
                <label for="approve_by">Approved for Release by:</label>
                <input type="text" id="approve_by" name="approve_by"><!-- approve_by -->
            </div>

            <div class="overlay_form_group">
                <label for="release_date">Release Date:</label>
                <input type="date" id="release_date" name="release_date"><!-- release_date -->
            </div>
            <br>
            <br>
            <H3><u>EDWIN G. MANADAO</u></H3>
            <p>CICTO Department head</p>
     
            <div class="overlay_form_group">
        <button type="submit">Save Record</button>
    </div>
    </div>


  </div>
</div>


<script>
function openNav() {
  document.getElementById("myNav").style.height = "100%";
}

function closeNav() {
  document.getElementById("myNav").style.height = "0";
}

$(document).ready(function() {
    $('#overlay-content').DataTable({
      "ajax": {
        "url": "fetch_ticket.php",
        "type": "GET",
        "data": function(d) {
          d.ticketNumber = $('#ticket_number').val();
        }
      },
      "serverSide": false, // Set server-side processing to false
      "initComplete": function(settings, json) {
        // No need to filter data here, as it's already filtered on the server-side
      }
    });
  });

</script>
</body>
</html>

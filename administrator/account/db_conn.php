<?php
$servername = "karbenjyle.com";
$username = "wdwhhklr_karbenjyle";
$password = "5H;Vf_&O]zP4";
$db_name = "wdwhhklr_cicto";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $db_name);


// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully";

?>
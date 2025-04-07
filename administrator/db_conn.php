<?php
$servername = "localhost";
$username = "root";
$password = "";
$db_name = "cicto";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $db_name);


// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully";

?>
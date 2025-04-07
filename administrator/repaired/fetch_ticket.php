<?php

include ('db_conn.php');

// Get the ticket number and table name from the GET request
$ticket_number = $_GET['ticket_number'];
$table_name = $_GET['table_name'];

// Prepare the query
$stmt = $conn->prepare("SELECT *, image FROM $table_name WHERE ticket_number = ?");
$stmt->bind_param("s", $ticket_number);
$stmt->execute();

// Fetch the ticket data
$result = $stmt->get_result();
$ticket_data = $result->fetch_assoc();

// Encode the image data as a base64 string
$ticket_data['image'] = base64_encode($ticket_data['image']);

// Encode the data as JSON
$json_data = json_encode($ticket_data);

// Return the JSON data
echo $json_data;

// Close the database connection
$conn->close();
?>
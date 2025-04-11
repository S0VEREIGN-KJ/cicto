<?php
// fetch_report.php
include '../db_conn.php';  // Include your DB connection file

// Check if the ticket_number is set
if (isset($_GET['ticket_number'])) {
    $ticket_number = $_GET['ticket_number'];

    // Prepare SQL query to select data based on ticket_number
    $stmt = $conn->prepare("
        SELECT serial_number, unit, category, office, 
               COUNT(serial_number) AS ticket_count
        FROM ticket
        WHERE serial_number = ?
        GROUP BY serial_number
    ");

    // Bind ticket_number to the prepared statement
    $stmt->bind_param("s", $ticket_number);

    // Execute the query
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the query returned any result
    if ($result->num_rows > 0) {
        // Fetch the ticket details
        $ticket_details = $result->fetch_assoc();
        // Return the ticket details as JSON
        echo json_encode($ticket_details);
    } else {
        // If no result, return an error message
        echo json_encode(['error' => 'No data found for the provided ticket number.']);
    }
} else {
    echo json_encode(['error' => 'Invalid or missing ticket number.']);
}
?>

<?php
// Include the necessary DB connection
include '../db_conn.php';  

function getTicketSummary($conn, $ticket_number = null) {
    // Base query
    $search_query = "
        SELECT serial_number, unit, category, office, COUNT(DISTINCT serial_number) AS ticket_count
        FROM ticket 
    ";

    // Add the WHERE condition only if ticket_number is provided
    if ($ticket_number) {
        $search_query .= " WHERE serial_number = ?";
    }

    // Add the GROUP BY clause
    $search_query .= " GROUP BY serial_number";

    // Prepare the query
    $stmt = $conn->prepare($search_query);

    // If ticket_number is provided, bind the parameter
    if ($ticket_number) {
        $stmt->bind_param("s", $ticket_number);
    }

    // Execute the query
    $stmt->execute();
    return $stmt->get_result();
}

?>

<?php
// fetch_report.php
include '../db_conn.php';  // Include your DB connection file

// Check if both startDate and endDate are set and not empty
if (isset($_POST['start_date'], $_POST['end_date'], $_POST['technician_name']) &&
    !empty($_POST['start_date']) && !empty($_POST['end_date']) && !empty($_POST['technician_name'])) {

    // Get the date range and technician name from the POST parameters
    $startDate = $_POST['start_date'];
    $endDate = $_POST['end_date'];
    $technicianName = $_POST['technician_name'];

    // Query to fetch ticket statistics based on date range and assigned technician name
    $sql = "SELECT 
                COUNT(*) AS totalTickets,
                SUM(CASE WHEN status = 'Repaired' THEN 1 ELSE 0 END) AS repairedTickets,
                SUM(CASE WHEN status = 'Closed' THEN 1 ELSE 0 END) AS closedTickets,
                SUM(CASE WHEN status = 'In Progress' THEN 1 ELSE 0 END) AS inProgressTickets
            FROM ticket
            WHERE datetime_req BETWEEN ? AND ?
            AND assigned_name = ?";

    // Prepare and execute the query
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sss', $startDate, $endDate, $technicianName);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch the data
    $data = $result->fetch_assoc();

    // Return the data as a JSON response
    echo json_encode($data);
} else {
    echo json_encode(['error' => 'Invalid or missing parameters.']);
}
?>

<?php
include ('db_conn.php');

// Define search variables
$search_ticket_number = $_GET['search_ticket_number'];
$search_serial_number = $_GET['search_serial_number'];
$search_req_name = $_GET['search_req_name'];
$search_unit = $_GET['search_unit'];
$search_category = $_GET['search_category'];
$search_assigned_name = $_GET['search_assigned_name'];

// Define search query
$search_query = "SELECT * FROM ticket";

// Add search conditions
if (!empty($search_ticket_number)) {
  $search_query .= " AND ticket_number LIKE '%$search_ticket_number%'";
}
if (!empty($search_serial_number)) {
  $search_query .= " AND serial_number LIKE '%$search_serial_number%'";
}
if (!empty($search_req_name)) {
  $search_query .= " AND req_name LIKE '%$search_req_name%'";
}
if (!empty($search_unit)) {
  $search_query .= " AND unit LIKE '%$search_unit%'";
}
if (!empty($search_category)) {
  $search_query .= " AND category LIKE '%$search_category%'";
}
if (!empty($search_assigned_name)) {
  $search_query .= " AND assigned_name LIKE '%$search_assigned_name%'";
}

// Add sorting and ordering
if ($sort == 'datetime_req') {
  $search_query .= " ORDER BY datetime_req " . ($order == 'ASC' ? 'ASC' : 'DESC');
} elseif ($sort == 'priority') {
  $search_query .= " ORDER BY FIELD(priority, 'Low', 'Medium', 'High') " . ($order == 'ASC' ? '' : 'DESC');
} elseif ($sort == 'status') {
  $search_query .= " ORDER BY FIELD(status, 'Pending', 'In Progress', 'Closed') " . ($order == 'ASC' ? '' : 'DESC');
} else {
  $search_query .= " ORDER BY datetime_req DESC";
  $order = 'ASC';
}

// Execute search query
$result = $conn->query($search_query);

// Output data in table body
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    // Output data in table format
  }
} else {
  echo "<tr><td colspan='11'>No data found</td></tr>";
}

// Close database connection
$conn->close();
?>
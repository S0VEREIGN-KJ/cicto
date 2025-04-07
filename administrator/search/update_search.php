<?php
include ('db_conn.php');

// List of all fields you expect from the form
$fields = [
    'serial_number', 'subject', 'category', 'accessories', 'item_date_received',
    'received_by', 'assigned_name', 'diagnostic', 'priority', 'status', 'comment',
    'approved_by', 'release_date', 'ticket_number'
];

// Array to store sanitized values
$data = [];

// Loop through each field and sanitize input
foreach ($fields as $field) {
    $data[$field] = isset($_POST[$field]) && is_string($_POST[$field])
                    ? mysqli_real_escape_string($conn, $_POST[$field])
                    : null; // Use null or a default value if not set
}

// Ensure that 'release_date' is set and sanitized if it is a valid date
$release_date = isset($_POST['release_date']) && $_POST['release_date'] !== ''
    ? mysqli_real_escape_string($conn, $_POST['release_date'])
    : null; // Set to NULL if not provided or if it's an empty string

// Check that all variables are set before binding
if ($stmt = $conn->prepare("UPDATE ticket SET
  serial_number = ?, 
  subject = ?, 
  unit = ?, 
  category = ?, 
  accessories = ?, 
  item_date_received = ?,
  received_by = ?,
  assigned_name = ?,
  diagnostic = ?,
  priority = ?,
  status = ?,
  comment = ?,
  approved_by = ?,
  release_date = ?
  WHERE ticket_number = ?")) {

    $stmt->bind_param("sssssssssssssss", 
        $data['serial_number'], $data['subject'], $unit, $data['category'], 
        $data['accessories'], $data['item_date_received'], $data['received_by'], 
        $data['assigned_name'], $data['diagnostic'], $data['priority'], 
        $data['status'], $data['comment'], $data['approved_by'], 
        $release_date, $data['ticket_number']); // Bind all variables

    if ($stmt->execute()) {
        echo '<div class="toast">Ticket updated successfully!</div>';
        header('Location: search.php');
        exit;
    } else {
        echo "Error executing statement: " . $stmt->error;
    }
} else {
    echo "Error preparing statement: " . $conn->error;
}



// Close the connection
mysqli_close($conn);
?>

?>



<style>
    .toast {
    position: fixed;
    top: 0;
    left: 50%;
    transform: translateX(-50%);
    background-color: #4CAF50;
    color: #fff;
    padding: 10px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    animation: toast 5s;
}

@keyframes toast {
    0% {
        opacity: 0;
        transform: translateX(-50%) translateY(-100%);
    }
    10% {
        opacity: 1;
        transform: translateX(-50%) translateY(0);
    }
    90% {
        opacity: 1;
        transform: translateX(-50%) translateY(0);
    }
    100% {
        opacity: 0;
        transform: translateX(-50%) translateY(-100%);
    }
}
</style>
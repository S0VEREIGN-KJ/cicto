<?php

include ('db_conn.php');


// Update ticket details in the database

if (isset($_POST['item_date_received'])) {
    $item_date_received = mysqli_real_escape_string($conn, $_POST['item_date_received']);
} else {
    $item_date_received = null; // or some default value
}

if (isset($_POST['received_by'])) {
    $received_by = mysqli_real_escape_string($conn, $_POST['received_by']);
} else {
    $received_by = null; // or some default value
}
if (isset($_POST['assigned_name'])) {
    $assigned_name = mysqli_real_escape_string($conn, $_POST['assigned_name']);
} else {
    $assigned_name = null; // or some default value
}


if (isset($_POST['diagnostic'])) {
    $diagnostic = mysqli_real_escape_string($conn, $_POST['diagnostic']);
} else {
    $diagnostic = null; // or some default value
}

if (isset($_POST['priority'])) {
    $priority = mysqli_real_escape_string($conn, $_POST['priority']);
} else {
    $priority = null; // or some default value
}

if (isset($_POST['status'])) {
    $status = mysqli_real_escape_string($conn, $_POST['status']);
} else {
    $status = null; // or some default value
}

if (isset($_POST['comment'])) {
    $comment = mysqli_real_escape_string($conn, $_POST['comment']);
} else {
    $comment = null; // or some default value
}

if (isset($_POST['approved_by'])) {
    $approved_by = mysqli_real_escape_string($conn, $_POST['approved_by']);
} else {
    $approved_by = null; // or some default value
}

if (isset($_POST['release_date'])) {
    $release_date = mysqli_real_escape_string($conn, $_POST['release_date']);
} else {
    $release_date = null; // or some default value
}

if (isset($_POST['ticket_number'])) {
    $ticket_number = mysqli_real_escape_string($conn, $_POST['ticket_number']);
} else {
    $ticket_number = null; // or some default value
}

// Update database query
if ($stmt = $conn->prepare("UPDATE ticket SET 
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

    $stmt->bind_param("ssssssssss", $item_date_received, $received_by, $assigned_name, $diagnostic,$priority, $status, $comment, $approved_by, $release_date, $ticket_number);

    $stmt->execute();

    // Display a toast notification
    echo '<div class="toast">Ticket updated successfully!</div>';
    // Redirect the user back to the previous page
    header('Location: ticket.php');// Replace 'ticket.php' with the actual URL of the previous page
    exit;
} else {
    echo "Error updating ticket: " . $stmt->error;
}

// Close the connection
mysqli_close($conn);
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
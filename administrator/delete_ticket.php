<?php
include ('../database/db_conn.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ticket_number = $_POST['ticket_number'];

    // Query to delete the ticket
    $query = "DELETE FROM ticket WHERE ticket_number = '$ticket_number'";
    mysqli_query($conn, $query);

    // Refresh the page to reset the table
    header("Location: index.php");
    exit;
}
?>
<?php
include('db_conn.php');

// Get the current date and time
$current_time = date("Y-m-d H:i:s");

// SQL query to delete rows from `account` table where activation expiry is older than 24 hours
$sql_account = "DELETE FROM account WHERE activation_expiry < DATE_SUB(?, INTERVAL 24 HOUR) AND account_activation_hash IS NOT NULL";
$stmt_account = $conn->prepare($sql_account);
$stmt_account->bind_param("s", $current_time);

if ($stmt_account->execute()) {
    // Get the number of rows affected by the DELETE query for `account`
    $deleted_account_rows = $stmt_account->affected_rows;
    
    if ($deleted_account_rows > 0) {
        echo "<script>alert('$deleted_account_rows expired activation tokens older than 24 hours have been deleted from the `account` table.'); window.location.href = 'accounts.php';</script>";
    } else {
        echo "<script>alert('No expired activation tokens found to delete in the `account` table.'); window.location.href = 'accounts.php';</script>";
    }
} else {
    echo "<script>alert('Error deleting expired rows in the `account` table: " . $stmt_account->error . "'); window.location.href = 'accounts.php';</script>";
}

// SQL query to delete rows from `technician` table where activation expiry is older than 24 hours
$sql_technician = "DELETE FROM technician WHERE activation_expiry < DATE_SUB(?, INTERVAL 24 HOUR) AND account_activation_hash IS NOT NULL";
$stmt_technician = $conn->prepare($sql_technician);
$stmt_technician->bind_param("s", $current_time);

if ($stmt_technician->execute()) {
    // Get the number of rows affected by the DELETE query for `technician`
    $deleted_technician_rows = $stmt_technician->affected_rows;
    
    if ($deleted_technician_rows > 0) {
        echo "<script>alert('$deleted_technician_rows expired activation tokens older than 24 hours have been deleted from the `technician` table.'); window.location.href = 'accounts.php';</script>";
    } else {
        echo "<script>alert('No expired activation tokens found to delete in the `technician` table.'); window.location.href = 'accounts.php';</script>";
    }
} else {
    echo "<script>alert('Error deleting expired rows in the `technician` table: " . $stmt_technician->error . "'); window.location.href = 'accounts.php';</script>";
}

// Close the statements and the connection
$stmt_account->close();
$stmt_technician->close();
$conn->close();
?>

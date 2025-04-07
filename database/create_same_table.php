<?php

include ('db_conn.php');

// Create a new table with the same columns as the original table
$sql = "CREATE TABLE incoming LIKE ticket";
mysqli_query($conn, $sql);

// Check if the table was created successfully
if (mysqli_query($conn, $sql)) {
    echo "Table created successfully";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}

// Duplicate data from the original table
$sql = "INSERT INTO incoming SELECT * FROM ticket";
mysqli_query($conn, $sql);

// Check if the data was duplicated successfully
if (mysqli_query($conn, $sql)) {
    echo "Data duplicated successfully";
} else {
    echo "Error duplicating data: " . mysqli_error($conn);
}

// Close the connection
mysqli_close($conn);
?>
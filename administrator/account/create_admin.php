<?php
include 'db_conn.php';

$password = 'admin_cicto0987654321';
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Now, insert this hashed password into the database
$sql = "INSERT INTO admin (username, password) VALUES ('cicto_admin', ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $hashedPassword);
$stmt->execute();

?>
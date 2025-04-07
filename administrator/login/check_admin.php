<?php
session_start();
include('db_conn.php');

header_remove('ETag');
header_remove('Last-Modified');
ini_set('opcache.enable', 0);
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');


if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login/login.php");
    exit();
}
// Check if the user has been logged out
if (isset($_SESSION['logged_out'])) {
    header("Location: ../logout.php");
    exit();
}
// Set a session variable indicating that the user is authenticated
$_SESSION['authenticated'] = true;


// You can use the session variable directly
$login_user = $_SESSION['username'];


?>
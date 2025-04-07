<?php
session_start();

// Unset the session variables
unset($_SESSION['username']);
unset($_SESSION['role']);
unset($_SESSION['admin_token']);

// Destroy the session
session_destroy();

// Delete the session cookie
setcookie(session_name(), '', time() - 3600, '/', '', true, true);

// Redirect to the login page
header('Location: login/login.php');
exit;
?>
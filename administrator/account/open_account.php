<?php
include('../login/check_admin.php');

// Function to validate admin credentials against the database
function validateAdmin($conn, $username, $password) {
    $stmt = $conn->prepare("SELECT password FROM admin WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows === 1) {
        $stmt->bind_result($hashedPassword);
        $stmt->fetch();
        return password_verify($password, $hashedPassword);
    }
    return false;
}

// Check if the 'id', 'username', and 'password' parameters are set in the URL
if (isset($_GET['id']) && isset($_GET['username']) && isset($_GET['password'])) {
    $id = (int) $_GET['id']; // Make sure the ID is an integer for safety
    $username = $_GET['username'];
    $password = $_GET['password'];

    if (validateAdmin($conn, $username, $password)) {
        // Ensure the SQL query matches the purpose of updating the account status
        $query = "UPDATE account SET deleted = 0 WHERE id_number = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            header('Location: closed_accounts.php?message=Account+OPENED+successfully');
        } else {
            header('Location: closed_accounts.php?message=Error+OPENING+account');
        }
    } else {
        header('Location: closed_accounts.php?message=Invalid+admin+credentials');
    }
} else {
    header('Location: closed_accounts.php');
}

mysqli_close($conn);
?>

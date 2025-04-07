<?php
include ('../login/check_admin.php');

// Function to validate admin credentials against the database
function validateAdmin($conn, $username, $password) {
    // Prepare the SQL query to prevent SQL injection
    $stmt = $conn->prepare("SELECT password FROM admin WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    
    // Check if the username exists
    if ($stmt->num_rows === 1) {
        $stmt->bind_result($hashedPassword);
        $stmt->fetch();
        
        // Verify the password (assumes passwords are hashed in the database)
        return password_verify($password, $hashedPassword);
    }
    
    return false; // Username not found
}

// Check if the 'id', 'username', and 'password' parameters are set in the URL
if (isset($_GET['id']) && isset($_GET['username']) && isset($_GET['password'])) {
    $id = $_GET['id']; // This would refer to the account ID being deleted
    $username = $_GET['username'];
    $password = $_GET['password'];

    // Validate the admin credentials
    if (validateAdmin($conn, $username, $password)) {
        // SQL query to mark the account as deleted by updating the deleted column only
        $query = "UPDATE account SET deleted = 1 WHERE id_number = ?";
        
        // Prepare and execute the query with parameterized placeholders
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            // Redirect back to the user accounts page with a success message
            header('Location: users_account.php?message=Account+deleted+successfully');
        } else {
            // Redirect back with an error message
            header('Location: users_account.php?message=Error+deleting+account');
        }
    } else {
        // Redirect back with an error message if validation fails
        header('Location: users_account.php?message=Invalid+admin+credentials');
    }
} else {
    // Redirect back if no ID is provided
    header('Location: users_account.php');
}

// Close database connection
mysqli_close($conn);
?>

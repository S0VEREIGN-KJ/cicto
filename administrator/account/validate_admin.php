<?php
// Start the session
session_start();

// Include the database connection file
include('db_conn.php');

// Get the POST data
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// Initialize response array
$response = ['success' => false, 'message' => 'Invalid admin credentials.'];

// Check for empty credentials
if (empty($username) || empty($password)) {
    $response['message'] = 'Username and password cannot be empty.';
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

try {
    // Prepare the SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT password FROM admin WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    
    // Fetch the admin's hashed password
    $result = $stmt->get_result();
    if ($result && $row = $result->fetch_assoc()) {
        $hashedPassword = $row['password'];

        // Verify the provided password with the hashed password
        if (password_verify($password, $hashedPassword)) {
            $response['success'] = true;
            $response['message'] = 'Admin credentials validated successfully.';
        } else {
            $response['message'] = 'Invalid username or password.';
        }
    } else {
        $response['message'] = 'Admin not found.';
    }

    $stmt->close();
} catch (Exception $e) {
    // Handle any potential errors
    $response['message'] = 'Database error: ' . $e->getMessage();
}

// Return the JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>

<?php
include ('../login/check_admin.php');

// Get user ID from POST data
$userId = $_POST['userId'] ?? null;

$response = ['success' => false, 'message' => 'Unable to update account opening status.'];

// Ensure user ID is provided
if (!$userId) {
    $response['message'] = 'User ID is required.';
    echo json_encode($response);
    exit;
}

try {
    // Prepare the update statement
    $stmt = $conn->prepare("UPDATE technician SET deleted = 0 WHERE id_number = ?");
    $stmt->bind_param("i", $userId);

    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = 'Account opened successfully.';
    } else {
        $response['message'] = 'Error updating opening status. Please try again.';
    }
} catch (Exception $e) {
    $response['message'] = 'Database error: ' . $e->getMessage();
}

// Output JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>

<?php
include('db_conn.php');
include('mailer.php');

// Get form data
$id_number = $_POST['id_number'];
$password = $_POST['password'];
$hashed_password = password_hash($password, PASSWORD_DEFAULT);  // Hash the password
$full_name = $_POST['first_name'] . ' ' . $_POST['middle_name'] . ' ' . $_POST['last_name'];
$phone_number = $_POST['phone_number'];
$email = $_POST["email"];

// Generate a random activation token and hash it
$activation_token = bin2hex(random_bytes(16));
$activation_token_hash = hash("sha256", $activation_token);

// Set the activation expiry time (e.g., 30 minutes from now)
$activation_expiry = date("Y-m-d H:i:s", time() + 60 * 30); // 30 minutes

// Determine office based on which select has a value
$office = !empty($_POST['department']) ? $_POST['department'] : (!empty($_POST['barangay']) ? $_POST['barangay'] : '');

// Check if an active account or technician with the same ID number, phone number, or email exists
$sql = "
    SELECT id_number, phone_number, email FROM account WHERE (id_number = ? OR phone_number = ? OR email = ?) AND deleted = 0
    UNION
    SELECT id_number, phone_number, email FROM technician WHERE (id_number = ? OR phone_number = ? OR email = ?) AND deleted = 0
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssss", $id_number, $phone_number, $email, $id_number, $phone_number, $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // An active account or technician with the same details exists, display an error message
    echo '<script>alert("ID number, phone number, or email already registered and active. Please try again."); window.location.href = "show_technician.php";</script>';
    exit;
} else {
    // No active account or technician exists, proceed with creating a new account
    $sql = "INSERT INTO technician (id_number, password, full_name, email, phone_number, account_activation_hash, activation_expiry, deleted) 
            VALUES (?, ?, ?, ?, ?, ?, ?, 0)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $id_number, $hashed_password, $full_name, $email, $phone_number, $activation_token_hash, $activation_expiry); // Bind the parameters

    if ($stmt->execute()) {
        // Send the activation email
        $emailStatus = sendActivationEmail($email, $_POST['first_name'], $activation_token);

        if ($emailStatus === true) {
            echo '<script>alert("Check your email to activate your account!"); window.location.href = "show_technician.php";</script>';
        } else {
            echo '<script>alert("Message could not be sent. ' . $emailStatus . '"); window.location.href = "show_technician.php";</script>';
        }
        exit;
    } else {
        // Handle error on insert
        if ($stmt->errno === 1062) {
            echo '<script>alert("Email already taken!"); window.location.href = "show_technician.php";</script>';
        } else {
            echo '<script>alert("Error inserting data: ' . $stmt->error . '"); window.location.href = "show_technician.php";</script>';
        }
        exit;
    }
}

// Close connection
$conn->close();
?>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$db_name = "cicto";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $db_name);


// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
// Create a new user
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert the user into the database
    $query = "INSERT INTO admin (username, password) VALUES ('$username', '$hashed_password')";
    if ($conn->query($query) === TRUE) {
        echo "User created successfully!";
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
<form action="" method="post">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username"><br><br>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password"><br><br>
    <input type="submit" value="Create User">
</form>
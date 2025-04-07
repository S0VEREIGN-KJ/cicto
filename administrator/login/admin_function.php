<?php
session_start();
include ('db_conn.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if (empty($username)) {
            echo "Username is required";
        } elseif (empty($password)) {
            echo "Password is required";
        } else {
            $query = "SELECT * FROM admin WHERE username = '$username' LIMIT 1";
   
            $result = mysqli_query($conn, $query);

            if (!$result) {
                echo "Error: " . mysqli_error($conn);
                exit();
            }

            $user_data = mysqli_fetch_array($result, MYSQLI_ASSOC);

            if ($user_data) {
             
                $hashed_password = $user_data['password']; // Get the hashed password from the database
    
                if (password_verify($password, $hashed_password)) {
                 
                    if ($user_data['username'] == $username) {
                        $_SESSION['username'] = $user_data['username'];
                        $_SESSION['role'] = 'admin'; // Set the role session variable
                        header("Location: ../home/home.php");
                        exit(); // Add this to stop the script from continuing
                    }
                }
            }
        }
    }
}
?>
<?php
header_remove('ETag');
header_remove('Last-Modified');
ini_set('opcache.enable', 0);
header('Cache-Control: no-cache, no-store, must-revalid_numberate');
header('Pragma: no-cache');
header('Expires: 0');

   
if (isset($_GET['url'])) {
  $url = $_GET['url'];
  header('Location: ' . $url);
  exit;
}
$token = $_GET["token"];

$token_hash = hash("sha256", $token);

$mysqli = require __DIR__ . "/database.php";

$sql = "SELECT * FROM technician
        WHERE account_activation_hash = ?";

$stmt = $mysqli->prepare($sql);

$stmt->bind_param("s", $token_hash);

$stmt->execute();

$result = $stmt->get_result();

$user = $result->fetch_assoc();


if ($user === null) {
    // Redirect to no-token.php if token is not found
    header('Location: no-token.php');
    exit;
}
$sql = "UPDATE technician
        SET account_activation_hash = NULL, activation_expiry = NULL
        WHERE id_number = ?";

$stmt = $mysqli->prepare($sql);

$stmt->bind_param("s", $user["id_number"]);

$stmt->execute();
?>
<style>
     h2 {
        font-size: 2.5em; /* Increase the font size */
    }

    p {
        font-size: 1.5em; /* Increase the font size for the paragraph */
    }
</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="wid_numberth=device-wid_numberth, initial-scale=1.0">
    <title>Activation Page</title>
    <link rel="stylesheet" href="log_in.css?v=1.2">
</head>
<body>
    <div class="background-image"></div>
    <div class="overlay"></div>
<header>
    <img src="../images/cicto_logo.png" alt="App Logo">
    <h1>CICTO TABUK CITY</h1>
    <h1>City Information Communication Technology Office</h1>
</header>

    <main>
        <div class="main-image"></div>
        <div class="main-overlay"></div>
        <div class="login-container">
            
            <h2>Technician Account Activated</h2>

<p>Account activated successfully. You can now login in the app<p>

    </main>

</body>

</html>

<script>
       function loadContent(url) {      ///no cache function
    $.ajax({
        url: url,
        cache: false,
        headers: {
            'Cache-Control': 'no-cache',
            'Pragma': 'no-cache'
        },
        success: function(data) {
            console.log('Loaded content:', data);
            $('#content-loader').html(data);
            window.location.hash = url;
          
        }
    });
}
function preventBack() {
    window.history.pushState(null, '', window.location.href);
}

// Call it once to set the current state
preventBack();

// Use popstate to detect back navigation and prevent it
window.addEventListener('popstate', function () {
    preventBack();
});

        </script>
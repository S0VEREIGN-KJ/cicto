<?php
header_remove('ETag');
header_remove('Last-Modified');
ini_set('opcache.enable', 0);
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

if (isset($_GET['url'])) {
    $url = $_GET['url'];
    header('Location: ' . $url);
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NO TOKEN FOUND</title>
    <link rel="stylesheet" href="log_in.css?v=1.2">
</head>
<style>
    h2 {
    font-size: 2.5em; /* Larger font size for the heading */
    color: #ff6347; /* Change the text color to a shade of red */
    text-align: center; /* Center align the text */
    margin-bottom: 20px; /* Add space below the heading */
}

p {
    font-size: 1.5em; /* Increase font size for the paragraph */
    color: #fff; /* Set the text color to white */
    text-align: center; /* Center align the text */
    margin-top: 10px; /* Add space above the paragraph */
}

    </style>
<body>
    <div class="background-image"></div>
    <div class="overlay"></div>
<header>
    <img src="images/cicto_logo.png" alt="App Logo" style="width: 30%; height: auto;">
    <h1>CICTO TABUK CITY</h1>
    <h1>City Information Communication Technology Office</h1>
</header>

    <main>
        <div class="main-image"></div>
        <div class="main-overlay"></div>
        <div class="login-container">
   
        <h2>NO TOKEN FOUND</h2>

<p>NO TOKEN FOUND.... PLEASE CHECK EMAIL<p>

        </div>
    </main>

</body>

</html>

<script>
    function loadContent(url) {  // No cache function
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

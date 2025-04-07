<?php
   include('admin_function.php');     // ...ADMIN LOGIN FUNCTION

   header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

// Set a session variable indicating that the user is logged in
$_SESSION['logged_in'] = true;
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN Login Page</title>
    <link rel="stylesheet" href="log_in.css?v=1.0">
 

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
            <h2>Log In</h2>


             <?php if (isset($error) && !empty($error)) : ?>  <!--error logging in -->
    <div class="alert alert-warning" role="alert">
        <?php echo $error; ?>
    </div>
    <script>
        var alertElement = document.querySelector('.alert');
        alertElement.style.opacity = 0;
        setTimeout(function() {
            alertElement.style.opacity = 1;
            setTimeout(function() {
                alertElement.style.opacity = 0;
                setTimeout(function() {
                    alertElement.parentNode.removeChild(alertElement);
                }, 1000);
            }, 3000);
        }, 100);
    </script>
<?php endif; ?>      <!--error logging in -->



<form action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="POST">
    <div class="input-group">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
        </svg>
        <input type="text" id="username" name="username" placeholder="Username" autocomplete="off" required>
    </div>
    <div class="input-group">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 0 1 3 3m3 0a6 6 0 0 1-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1 1 21.75 8.25Z" />
        </svg>
        <input type="password" id="password" name="password" placeholder="Password" required>

        
    </div>
    
    <button for="login_button" type="submit" id="login_button" name="submit">Login</button>
</form>

       
    </main>


    <footer>
        
     
    </footer>
</body>

</html>

<script>
    
         function preventBack(){window.history.forward()};
      setTimeout("preventBack()",0);
        window.onunload=function(){null:}
        </script>
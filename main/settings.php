<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: sign-in.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <head>
          <link rel="stylesheet" href="css/recents.css">
          <link rel="stylesheet" href="css/settings.css">
    </head>   

    <body>

        <div class="sidenav">
            <h3>Movie & Book Tracker</h3>
            <h4>Welcome, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>!</h4>
            <a href="recents.php" id="recents">User's Feed</a>
            <a href="movies.html">Your Movies</a>
            <a href="books.html">Your Books</a>
            <a href="settings.php" id="settings" style="font-weight: bold; background-color:gray;">Settings</a>
        </div>
        <div class ="main">
            <header>
                <h2>Settings</h2> 
                <div class="function-settings">
                    <!-- TODO: reset username -->
                    <!-- <a href="reset-password.php" class="btn btn-warning">Reset Your Password</a> -->
                    <a href="logout.php" class="btn btn-danger">Sign Out</a>
                </div>
            </header>
        </div>
    </body>
</html>

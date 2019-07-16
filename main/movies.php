<?php
// initializes session
session_start();
 
// if user is not logged in, redirect to sign-in page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: sign-in.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <head>
        <!-- <link rel="stylesheet" href="css/sign-in.css"> -->
        <link rel="stylesheet" href="css/recents.css">
    </head>  

    <body>

        <!-- TODO: Highlight the link the page is on -->
        <div class="sidenav">
            <h3>Movie & Book Tracker</h3>
            <h4>Welcome, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>!</h4>
            <a href="recents.php" id="recents">User's Feed</a>
            <a href="movies.php" style="font-weight: bold; background-color:gray;">Your Movies</a>
            <a href="books.php">Your Books</a>
            <a id="settings" href="settings.php">Settings</a>
        </div>

        <div class="main">
            <h2>Movies</h2>
            <div class="no-entry">
                <p>You don't have any entries! Add a movie...</p>
                <p class="add__button"><input type="submit" name="add" value="Add"></p>
            </div>
        </div>
    </body>
</html>

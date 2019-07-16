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
          <link rel="stylesheet" href="css/recents.css">
    </head>   

    <body>

        <div class="sidenav">
            <h3>Movie & Book Tracker</h3>
            <h4>Welcome, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>!</h4>
            <a href="recents.php" id="recents" style="font-weight: bold; background-color:gray;">User's Feed</a>
            <a href="movies.php">Your Movies</a>
            <a href="books.php">Your Books</a>
            <a href="settings.php" id="settings">Settings</a>
        </div>
        <div class ="main">
            <header>
                <h2>Recents</h2> 
                <div class="no-entry">
                    <p>You don't have any entries! Add a book or movie...</p>
                    <p class="add__button"><input type="submit" name="add" value="Add"></p>
                </div>
            </header>
        </div>

        <script>
            function openCity(evt, cityName) {
                var i, x, tablinks;
                x = document.getElementsByClassName("city");
                for (i = 0; i < x.length; i++) {
                    x[i].style.display = "none";
                }
                tablinks = document.getElementsByClassName("tablink");
                for (i = 0; i < x.length; i++) {
                    tablinks[i].className = tablinks[i].className.replace(" w3-red", ""); 
                }
                document.getElementById(cityName).style.display = "block";
                evt.currentTarget.className += " w3-red";
            }
</script>
    </body>
</html>

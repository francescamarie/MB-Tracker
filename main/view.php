<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: sign-in.php");
    exit;
}

// Include config file
require_once "config.php";

$id=$_REQUEST['id'];
$query = "SELECT * FROM Entries WHERE id=$id"; 
$result = mysqli_query($link, $query) or die ( mysqli_error());
    if ($result->num_rows > 0) {
    //output data of each row
        while($row = $result->fetch_assoc()) { 
            echo "<p><a style='margin-left:170px;' href='javascript:history.back()''>< Back to recents</a></p>
            	<table align='center';>
                    <tr>
                        <td><img src='img/script.png'/></td>

                    </tr>
                    <tr>
                    	<td><a href='edit.php?id=".$row["id"]."'>Edit</a></td>
                        <td><a href='delete.php?id=".$row["id"]."'>Delete</a></td>
                    </tr>
                    <tr>
                      <td><p style='text-align:center;'>Title: ".$row["Name"]."</p></td>
					</tr>
                    <tr>
                    	<td><p style='text-align:center;'>Year: ".$row["Year_ID"]."</p></td>
                    </tr>
                    <tr>
                    	<td><p style='text-align:center;'>Author (if book): ".$row["Author"]."</p></td>
                    </tr>
                    <tr>
                    	<td><p style='text-align:center;'>Rating: ".$row["Rating"]."</p></td>
                    </tr>
                    <tr>
                    	<td><p style='text-align:center;'>Review: ".$row["Review"]."</p></td>
                    </tr>
                    <tr>
                    	<td><p style='text-align:center;'>Type: ".$row["Type"]."</p></td>
                    </tr>
                 </table>";
        }
    } else {
        echo "0 results";
    }
    $link->close();
?>

<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
<head>
    <link rel="stylesheet" href="css/recents.css">
</head>

<body>
	<div class="sidenav">
        <h3>Movie & Book Tracker</h3>
        <h4>Welcome, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>!</h4>
        <a href="recents.php" id="recents" >User's Feed</a>
        <a href="movies.php">Your Movies</a>
        <a href="books.php">Your Books</a>
        <a href="logout.php" id="settings">Sign Out</a>
    </div>
</body>
</html>
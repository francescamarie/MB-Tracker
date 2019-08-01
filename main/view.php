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
            echo "<p><a style='margin-left:190px; font-size: 18px;' href='javascript:history.back()''>< Back</a></p>
            	<table align='center'; style='padding-left:200px;'>
                    <tr>
                        <td><img style='padding-left:50px;'src='img/script.png'/></td>

                    </tr>
                    <tr>
                    	<td><a href='edit.php?id=".$row["id"]."'>Edit</a></td>
                        <td><a href='delete.php?id=".$row["id"]."'>Delete</a></td>
                    </tr>
                    <tr>
                      <td><p style='text-align:center; font-size: 25px; font-weight: bold;'>Title: ".$row["Name"]."</p></td>
					</tr>
                    <tr>
                    	<td><p style='text-align:center; font-size: 20px;'>Year: ".$row["Year_ID"]."</p></td>
                    </tr>
                    <tr>
                    	<td><p style='text-align:center; font-size: 20px;'>Author or Director: ".$row["Author"]."</p></td>
                    </tr>
                    <tr>
                    	<td><p style='text-align:center; font-size: 20px;'>Rating: ".$row["Rating"]."</p></td>
                    </tr>
                    <tr>
                    	<td><p style='text-align:center; font-size: 20px;'>Review: ".$row["Review"]."</p></td>
                    </tr>
                    <tr>
                    	<td><p style='text-align:center; font-size: 20px;'>Type: ".$row["Type"]."</p></td>
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
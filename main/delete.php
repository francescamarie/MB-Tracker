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
$query = "DELETE FROM Entries WHERE id=$id"; 
$result = mysqli_query($link, $query) or die ( mysqli_error());
header("Location: recents.php"); 
?>
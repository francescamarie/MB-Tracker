<?php
// initializes session
session_start();
 
// unset session variables
$_SESSION = array();
 
// destroy session.
session_destroy();
 
// redirect to sign-in page
header("location: sign-in.php");
exit;
?>


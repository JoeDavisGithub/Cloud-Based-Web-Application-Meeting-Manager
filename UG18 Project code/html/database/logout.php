<?php 
// Ends all sessions and goes back to login page
session_start();
session_unset();
session_destroy();
header("location: ../login.php");
?>
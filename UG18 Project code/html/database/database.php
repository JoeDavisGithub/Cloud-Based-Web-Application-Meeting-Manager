<?php
// Connection to the database
$host = "database-meeting-maker.cka8gk92y7qg.us-east-1.rds.amazonaws.com";
$dbname = "meeting_maker";
$username = "root";
$password = "dbpass100";

$db = new mysqli($host, $username, $password, $dbname, );

if ($db->connect_errno) {
	die("Connection To Database Invalid, Error: " . $db->connect_error);
}

return $db;
?>
<?php
$host = 'localhost';
$db = 'lawyers_portal';
$user = 'root';
$pass = ''; // update if needed

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

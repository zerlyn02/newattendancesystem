<?php
$servername = "localhost";
$username = "root"; // Default username in XAMPP
$password = ""; // Default password in XAMPP
$dbname = "melaka_high_school";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Database connection details
$servername = "localhost"; // Your database host
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "melaka_high_school"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to get all students from classB1 including checkbox status
$sql = "SELECT id, name, icnumber, checkbox FROM classB1"; // Ensure 'checkbox' is selected
$result = $conn->query($sql);

// Fetch all rows as an associative array
$students = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $students[] = $row;
    }
} else {
    echo "0 results";
    exit;
}

$conn->close();

// Set the content type to JSON and output the students data
header('Content-Type: application/json');
echo json_encode($students);
?>

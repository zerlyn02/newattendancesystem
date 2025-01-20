<?php
// profile.php
header('Content-Type: application/json');
session_start();

// Database connection details
$servername = "localhost";
$username = "root"; // Update with your DB username
$password = ""; // Update with your DB password
$dbname = "melaka_high_school";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]);
    exit();
}

// Assuming the user is logged in and their ID is stored in the session
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "message" => "User not logged in."]);
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user data from the database
$sql = "SELECT name, email, date_of_birth AS dob, address, profile_picture FROM registration WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    echo json_encode(["success" => true, "name" => $user['name'], "email" => $user['email'], "dob" => $user['dob'], "address" => $user['address'], "profile_picture" => $user['profile_picture']]);
} else {
    echo json_encode(["success" => false, "message" => "User data not found."]);
}

$stmt->close();
$conn->close();
?>

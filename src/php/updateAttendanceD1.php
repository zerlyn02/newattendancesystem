<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Check if we are receiving a POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Read the raw POST data
    $inputData = json_decode(file_get_contents('php://input'), true);

    // Validate the input data
    if (isset($inputData['id']) && isset($inputData['attendance'])) {
        // Database connection details
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "melaka_high_school"; 

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            echo json_encode(['success' => false, 'error' => 'Connection failed: ' . $conn->connect_error]);
            exit;
        }

        // Get student ID and attendance value from the POST data
        $studentId = $inputData['id'];
        $attendance = $inputData['attendance']; // The attendance value (1 for checked, 0 for unchecked)

        // Prepare the SQL statement to update attendance
        $sql = "UPDATE classD1 SET checkbox = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            echo json_encode(['success' => false, 'error' => 'SQL error: ' . $conn->error]);
            exit;
        }

        // Bind parameters and execute the query
        $stmt->bind_param("ii", $attendance, $studentId);

        if ($stmt->execute()) {
            // Return success response in JSON format
            echo json_encode(['success' => true]);
        } else {
            // Return error message in JSON format
            echo json_encode(['success' => false, 'error' => 'Failed to update attendance']);
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid input data']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}
?>

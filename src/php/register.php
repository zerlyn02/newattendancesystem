<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $dob = $_POST['dob'];
    $address = $_POST['address'];
    $role = $_POST['role'];
    $teacher_card = null;
    $subject_taught = null;
    $enrolment_letter = null;
    $classes_studying = null;

    if ($role == "Teacher") {
        $teacher_card = $_FILES['teacher_card']['name'];
        $subject_taught = $_POST['subject_taught'];

        // Upload teacher card
        move_uploaded_file($_FILES['teacher_card']['tmp_name'], "uploads/" . $teacher_card);
    } elseif ($role == "Guardian") {
        $enrolment_letter = $_FILES['enrolment_letter']['name'];
        $classes_studying = implode(", ", $_POST['classes']);

        // Upload enrolment letter
        move_uploaded_file($_FILES['enrolment_letter']['tmp_name'], "uploads/" . $enrolment_letter);
    }

    $sql = "INSERT INTO registration (name, email, password, date_of_birth, address, role, teacher_card, subject_taught, enrolment_letter, classes_studying) 
            VALUES ('$name', '$email', '$password', '$dob', '$address', '$role', '$teacher_card', '$subject_taught', '$enrolment_letter', '$classes_studying')";

    if ($conn->query($sql) === TRUE) {
        echo "Registration successful!";
        header("Location: /index.html");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

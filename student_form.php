<?php
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'student_db';

// Establishing a database connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $email = $_POST['email'];
    $course = $_POST['course'];

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO students (name, age, email, course) VALUES (?, ?, ?, ?)");

    // Bind the parameters
    $stmt->bind_param("siss", $name, $age, $email, $course);

    // Execute the statement and check for success
    if ($stmt->execute()) {
        echo "Student data stored successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Data Form</title>
</head>
<body>
<h1>Enter Student Data</h1>
<form action="" method="post">
    <label for="name">Name: </label>
    <input type="text" id="name" name="name" required> <br><br>
    <label for="age">Age: </label>
    <input type="number" id="age" name="age" required> <br><br>
    <label for="email">Email: </label>
    <input type="email" id="email" name="email" required> <br><br>
    <label for="course">Course: </label>
    <input type="text" id="course" name="course" required> <br><br>
    <button type="submit">Submit</button>
</form>
</body>
</html>

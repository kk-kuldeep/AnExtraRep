<?php
// Database connection
$host = 'localhost';
$dbName = 'your_database_name';
$username = 'your_username';
$password = 'your_password';

try {
  $conn = new PDO("mysql:host=$host;dbname=$dbName", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
  die('Database connection failed: ' . $e->getMessage());
}

// Get form data
$name = $_POST['name'];
$age = $_POST['age'];
$weight = $_POST['weight'];
$email = $_POST['email'];
$healthReportName = $_FILES['healthReport']['name'];
$healthReportTmpName = $_FILES['healthReport']['tmp_name'];

// Upload the health report file
$uploadDir = 'uploads/';
$uploadedFilePath = $uploadDir . $healthReportName;
move_uploaded_file($healthReportTmpName, $uploadedFilePath);

// Insert user details and file path into the database
$stmt = $conn->prepare('INSERT INTO users (name, age, weight, email, health_report) VALUES (?, ?, ?, ?, ?)');
$stmt->execute([$name, $age, $weight, $email, $uploadedFilePath]);

// Close database connection
$conn = null;
?>

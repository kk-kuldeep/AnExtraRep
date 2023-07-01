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

// Get email from request
$email = $_GET['email'];

// Fetch the health report file path from the database
$stmt = $conn->prepare('SELECT health_report FROM users WHERE email = ?');
$stmt->execute([$email]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

// Send the health report file as a response
$filePath = $row['health_report'];
header('Content-type: application/pdf');
header('Content-Disposition: inline; filename="' . basename($filePath) . '"');
header('Content-Length: ' . filesize($filePath));
readfile($filePath);

// Close database connection
$conn = null;
?>

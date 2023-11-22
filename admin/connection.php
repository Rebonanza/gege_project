<?php
// Database configuration
$hostname = 'localhost';  // Change this to your database host
$database = 'gege_db';  // Change this to your database name
$username = 'root';  // Change this to your database username
$password = '';  // Change this to your database password

try {
    // Create a PDO instance
    $pdo = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);

    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Display a success message
    echo "Connected to the database successfully";
} catch (PDOException $e) {
    // Display an error message
    echo "Connection failed: " . $e->getMessage();
}
?>

<?php
// Database configuration template
// Copy this file to www/html/db.php and fill in your actual credentials

$DB_HOST = "localhost";          // Your MySQL host
$DB_NAME = "periodictracker";    // Your database name
$DB_USER = "your_username";      // Your MySQL username
$DB_PASS = "your_password";      // Your MySQL password
$DB_PORT = 3306;                 // MySQL port (usually 3306)

try {
    $pdo = new PDO(
        "mysql:host=$DB_HOST;port=$DB_PORT;dbname=$DB_NAME;charset=utf8mb4",
        $DB_USER,
        $DB_PASS,
        [ PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ]
    );
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
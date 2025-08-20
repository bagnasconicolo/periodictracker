<?php
// db.php - Database connection file

$DB_HOST = "localhost";
$DB_NAME = "periodictracker";
$DB_USER = "periodicuser";
$DB_PASS = "SecurePassword123!";
$DB_PORT = 3306;

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
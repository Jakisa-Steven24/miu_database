<?php
/**
 * Database connection.
 * Adjust host / user / password / database name to match your XAMPP setup.
 */

$host = "localhost";
$user = "root";
$pass = "";
$db   = "miu";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

require_once __DIR__ . "/functions.php";

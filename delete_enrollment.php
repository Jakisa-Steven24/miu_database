<?php
require_once "db.php";

$id = isset($_GET["id"]) ? (int) $_GET["id"] : 0;

if ($id <= 0) {
    redirect_to("enrollment.php", "Invalid enrollment id.", "error");
}

$stmt = $conn->prepare("DELETE FROM enrollment WHERE enrollment_id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    redirect_to("enrollment.php", "Enrollment deleted successfully.");
}

redirect_to("enrollment.php", "Delete failed: " . $stmt->error, "error");

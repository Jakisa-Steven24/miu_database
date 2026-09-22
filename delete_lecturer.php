<?php
require_once "db.php";

$id = isset($_GET["id"]) ? (int) $_GET["id"] : 0;

if ($id <= 0) {
    redirect_to("lecturer.php", "Invalid lecturer id.", "error");
}

$stmt = $conn->prepare("DELETE FROM lecturer WHERE lecturer_id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    redirect_to("lecturer.php", "Lecturer deleted successfully.");
}

if ($conn->errno === 1451 || $conn->errno === 1452) {
    redirect_to("lecturer.php", "Delete failed: this lecturer is still assigned to one or more courses.", "error");
}

redirect_to("lecturer.php", "Delete failed: " . $stmt->error, "error");

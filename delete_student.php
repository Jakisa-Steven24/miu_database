<?php
require_once "db.php";

$id = isset($_GET["id"]) ? (int) $_GET["id"] : 0;

if ($id <= 0) {
    redirect_to("student.php", "Invalid student id.", "error");
}

$stmt = $conn->prepare("DELETE FROM student WHERE student_id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    redirect_to("student.php", "Student deleted successfully.");
}

if ($conn->errno === 1451 || $conn->errno === 1452) {
    redirect_to("student.php", "Delete failed: this student still has enrollments or payments.", "error");
}

redirect_to("student.php", "Delete failed: " . $stmt->error, "error");

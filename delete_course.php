<?php
require_once "db.php";

$id = isset($_GET["id"]) ? (int) $_GET["id"] : 0;

if ($id <= 0) {
    redirect_to("course.php", "Invalid course id.", "error");
}

$stmt = $conn->prepare("DELETE FROM course WHERE course_id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    redirect_to("course.php", "Course deleted successfully.");
}

if ($conn->errno === 1451 || $conn->errno === 1452) {
    redirect_to("course.php", "Delete failed: students or enrollments still reference this course.", "error");
}

redirect_to("course.php", "Delete failed: " . $stmt->error, "error");

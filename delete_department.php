<?php
require_once "db.php";

$id = isset($_GET["id"]) ? (int) $_GET["id"] : 0;

if ($id <= 0) {
    redirect_to("department.php", "Invalid department id.", "error");
}

$stmt = $conn->prepare("DELETE FROM department WHERE dept_id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    redirect_to("department.php", "Department deleted successfully.");
}

if ($conn->errno === 1451 || $conn->errno === 1452) {
    redirect_to("department.php", "Delete failed: this department is still used by lecturers or courses.", "error");
}

redirect_to("department.php", "Delete failed: " . $stmt->error, "error");

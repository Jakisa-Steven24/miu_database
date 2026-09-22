<?php
require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    redirect_to("enrollment.php", "Only POST requests are allowed here.", "error");
}

$studentId      = (int) ($_POST["student_id"] ?? 0);
$courseId       = (int) ($_POST["course_id"] ?? 0);
$enrollmentDate = trim($_POST["enrollment_date"] ?? "");
$status         = trim($_POST["status"] ?? "Enrolled");
$recordId       = (int) ($_POST["record_id"] ?? 0);

$allowedStatuses = ["Enrolled", "Dropped", "Completed"];

if (!in_array($status, $allowedStatuses, true)) {
    $status = "Enrolled";
}

if ($studentId <= 0 || $courseId <= 0) {
    redirect_to("enrollment.php", "Please select both a student and a course.", "error");
}

if ($enrollmentDate === "") {
    redirect_to("enrollment.php", "Enrollment Date is required.", "error");
}

if ($recordId > 0) {
    $stmt = $conn->prepare("UPDATE enrollment SET student_id = ?, course_id = ?, enrollment_date = ?, status = ? WHERE enrollment_id = ?");
    $stmt->bind_param("iissi", $studentId, $courseId, $enrollmentDate, $status, $recordId);
    $page    = "enrollment.php?edit=" . $recordId;
    $message = "Enrollment updated successfully.";
} else {
    $stmt = $conn->prepare("INSERT INTO enrollment (student_id, course_id, enrollment_date, status) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss", $studentId, $courseId, $enrollmentDate, $status);
    $page    = "enrollment.php";
    $message = "Enrollment saved successfully.";
}

if (!$stmt->execute()) {
    redirect_to("enrollment.php", "Save failed: " . $stmt->error, "error");
}

redirect_to($page, $message);

<?php
require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    redirect_to("course.php", "Only POST requests are allowed here.", "error");
}

$courseCode  = trim($_POST["course_code"] ?? "");
$courseTitle = trim($_POST["course_title"] ?? "");
$credits     = (int) ($_POST["credits"] ?? 0);
$deptId      = (int) ($_POST["dept_id"] ?? 0);
$lecturerId  = (int) ($_POST["lecturer_id"] ?? 0);
$recordId    = (int) ($_POST["record_id"] ?? 0);

if ($courseCode === "" || $courseTitle === "") {
    redirect_to("course.php", "Course Code and Course Title are required.", "error");
}

if ($credits < 1) {
    redirect_to("course.php", "Credits must be at least 1.", "error");
}

if ($deptId <= 0 || $lecturerId <= 0) {
    redirect_to("course.php", "Please select both a department and a lecturer.", "error");
}

if ($recordId > 0) {
    $stmt = $conn->prepare("UPDATE course SET course_code = ?, course_title = ?, credits = ?, dept_id = ?, lecturer_id = ? WHERE course_id = ?");
    $stmt->bind_param("ssiiii", $courseCode, $courseTitle, $credits, $deptId, $lecturerId, $recordId);
    $page    = "course.php?edit=" . $recordId;
    $message = "Course updated successfully.";
} else {
    $stmt = $conn->prepare("INSERT INTO course (course_code, course_title, credits, dept_id, lecturer_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiii", $courseCode, $courseTitle, $credits, $deptId, $lecturerId);
    $page    = "course.php";
    $message = "Course registered successfully.";
}

if (!$stmt->execute()) {
    redirect_to("course.php", "Save failed: " . $stmt->error, "error");
}

redirect_to($page, $message);

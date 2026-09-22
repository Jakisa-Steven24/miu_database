<?php
require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    redirect_to("student.php", "Only POST requests are allowed here.", "error");
}

$registrationNumber = trim($_POST["registration_number"] ?? "");
$firstName          = trim($_POST["first_name"] ?? "");
$lastName           = trim($_POST["last_name"] ?? "");
$gender             = trim($_POST["gender"] ?? "");
$dateOfBirth        = trim($_POST["date_of_birth"] ?? "");
$email              = trim($_POST["email"] ?? "");
$address            = trim($_POST["address"] ?? "");
$courseId           = (int) ($_POST["course_id"] ?? 0);
$recordId           = (int) ($_POST["record_id"] ?? 0);

// Empty date_of_birth must be stored as NULL, not as an empty string.
if ($dateOfBirth === "") {
    $dateOfBirth = null;
}

if ($registrationNumber === "" || $firstName === "" || $lastName === "") {
    redirect_to("student.php", "Registration Number, First Name and Last Name are required.", "error");
}

if ($courseId <= 0) {
    redirect_to("student.php", "Please select a course.", "error");
}

if ($recordId > 0) {
    $stmt = $conn->prepare("UPDATE student SET registration_number = ?, first_name = ?, last_name = ?, gender = ?, date_of_birth = ?, email = ?, address = ?, course_id = ? WHERE student_id = ?");
    $stmt->bind_param("sssssssii", $registrationNumber, $firstName, $lastName, $gender, $dateOfBirth, $email, $address, $courseId, $recordId);
    $page    = "student.php?edit=" . $recordId;
    $message = "Student updated successfully.";
} else {
    $stmt = $conn->prepare("INSERT INTO student (registration_number, first_name, last_name, gender, date_of_birth, email, address, course_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssi", $registrationNumber, $firstName, $lastName, $gender, $dateOfBirth, $email, $address, $courseId);
    $page    = "student.php";
    $message = "Student registered successfully.";
}

if (!$stmt->execute()) {
    redirect_to("student.php", "Save failed: " . $stmt->error, "error");
}

redirect_to($page, $message);

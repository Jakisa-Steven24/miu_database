<?php
require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    redirect_to("lecturer.php", "Only POST requests are allowed here.", "error");
}

$staffNo   = trim($_POST["staff_no"] ?? "");
$firstName = trim($_POST["first_name"] ?? "");
$lastName  = trim($_POST["last_name"] ?? "");
$email     = trim($_POST["email"] ?? "");
$phone     = trim($_POST["phone"] ?? "");
$deptId    = (int) ($_POST["dept_id"] ?? 0);
$recordId  = (int) ($_POST["record_id"] ?? 0);

if ($staffNo === "" || $firstName === "" || $lastName === "") {
    redirect_to("lecturer.php", "Staff Number, First Name and Last Name are required.", "error");
}

if ($deptId <= 0) {
    redirect_to("lecturer.php", "Please select a department.", "error");
}

if ($recordId > 0) {
    $stmt = $conn->prepare("UPDATE lecturer SET staff_no = ?, first_name = ?, last_name = ?, email = ?, phone = ?, dept_id = ? WHERE lecturer_id = ?");
    $stmt->bind_param("sssssii", $staffNo, $firstName, $lastName, $email, $phone, $deptId, $recordId);
    $page    = "lecturer.php?edit=" . $recordId;
    $message = "Lecturer updated successfully.";
} else {
    $stmt = $conn->prepare("INSERT INTO lecturer (staff_no, first_name, last_name, email, phone, dept_id) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssi", $staffNo, $firstName, $lastName, $email, $phone, $deptId);
    $page    = "lecturer.php";
    $message = "Lecturer registered successfully.";
}

if (!$stmt->execute()) {
    redirect_to("lecturer.php", "Save failed: " . $stmt->error, "error");
}

redirect_to($page, $message);

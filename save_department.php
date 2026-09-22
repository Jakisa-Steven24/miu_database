<?php
require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    redirect_to("department.php", "Only POST requests are allowed here.", "error");
}

$deptCode       = trim($_POST["dept_code"] ?? "");
$deptName       = trim($_POST["dept_name"] ?? "");
$officeLocation = trim($_POST["office_location"] ?? "");
$phone          = trim($_POST["phone"] ?? "");
$headOfDept     = trim($_POST["head_of_dept"] ?? "");
$email          = trim($_POST["email"] ?? "");
$recordId       = (int) ($_POST["record_id"] ?? 0);

if ($deptCode === "" || $deptName === "") {
    redirect_to("department.php", "Department Code and Department Name are required.", "error");
}

if ($recordId > 0) {
    $stmt = $conn->prepare("UPDATE department SET dept_code = ?, dept_name = ?, office_location = ?, phone = ?, head_of_dept = ?, email = ? WHERE dept_id = ?");
    $stmt->bind_param("ssssssi", $deptCode, $deptName, $officeLocation, $phone, $headOfDept, $email, $recordId);
    $page    = "department.php?edit=" . $recordId;
    $message = "Department updated successfully.";
} else {
    $stmt = $conn->prepare("INSERT INTO department (dept_code, dept_name, office_location, phone, head_of_dept, email) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $deptCode, $deptName, $officeLocation, $phone, $headOfDept, $email);
    $page    = "department.php";
    $message = "Department registered successfully.";
}

if (!$stmt->execute()) {
    redirect_to("department.php", "Save failed: " . $stmt->error, "error");
}

redirect_to($page, $message);

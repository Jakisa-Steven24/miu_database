<?php
require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    redirect_to("payment.php", "Only POST requests are allowed here.", "error");
}

$studentId     = (int) ($_POST["student_id"] ?? 0);
$feeTypeId     = (int) ($_POST["fee_type_id"] ?? 0);
$amount        = (float) ($_POST["amount"] ?? 0);
$description   = trim($_POST["payment_description"] ?? "");
$paymentDate   = trim($_POST["payment_date"] ?? "");
$method        = trim($_POST["method"] ?? "");
$referenceNo   = trim($_POST["reference_no"] ?? "");
$recordId      = (int) ($_POST["record_id"] ?? 0);

if ($studentId <= 0 || $feeTypeId <= 0) {
    redirect_to("payment.php", "Please select both a student and a fee type.", "error");
}

if ($amount <= 0) {
    redirect_to("payment.php", "Amount must be greater than zero.", "error");
}

if ($paymentDate === "" || $method === "" || $referenceNo === "") {
    redirect_to("payment.php", "Payment Date, Method and Reference Number are required.", "error");
}

if ($recordId > 0) {
    $stmt = $conn->prepare("UPDATE payment SET student_id = ?, fee_type_id = ?, amount = ?, payment_description = ?, payment_date = ?, method = ?, reference_no = ? WHERE payment_id = ?");
    $stmt->bind_param("iidssssi", $studentId, $feeTypeId, $amount, $description, $paymentDate, $method, $referenceNo, $recordId);
    $page    = "payment.php?edit=" . $recordId;
    $message = "Payment updated successfully.";
} else {
    $stmt = $conn->prepare("INSERT INTO payment (student_id, fee_type_id, amount, payment_description, payment_date, method, reference_no) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iidssss", $studentId, $feeTypeId, $amount, $description, $paymentDate, $method, $referenceNo);
    $page    = "payment.php";
    $message = "Payment recorded successfully.";
}

if (!$stmt->execute()) {
    redirect_to("payment.php", "Save failed: " . $stmt->error, "error");
}

redirect_to($page, $message);

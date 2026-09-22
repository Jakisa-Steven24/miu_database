<?php
require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    redirect_to("fee_type.php", "Only POST requests are allowed here.", "error");
}

$feeName     = trim($_POST["fee_name"] ?? "");
$description = trim($_POST["description"] ?? "");
$recordId    = (int) ($_POST["record_id"] ?? 0);

if ($feeName === "") {
    redirect_to("fee_type.php", "Fee Name is required.", "error");
}

if ($recordId > 0) {
    $stmt = $conn->prepare("UPDATE fee_type SET fee_name = ?, description = ? WHERE fee_type_id = ?");
    $stmt->bind_param("ssi", $feeName, $description, $recordId);
    $page    = "fee_type.php?edit=" . $recordId;
    $message = "Fee type updated successfully.";
} else {
    $stmt = $conn->prepare("INSERT INTO fee_type (fee_name, description) VALUES (?, ?)");
    $stmt->bind_param("ss", $feeName, $description);
    $page    = "fee_type.php";
    $message = "Fee type registered successfully.";
}

if (!$stmt->execute()) {
    redirect_to("fee_type.php", "Save failed: " . $stmt->error, "error");
}

redirect_to($page, $message);

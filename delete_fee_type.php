<?php
require_once "db.php";

$id = isset($_GET["id"]) ? (int) $_GET["id"] : 0;

if ($id <= 0) {
    redirect_to("fee_type.php", "Invalid fee type id.", "error");
}

$stmt = $conn->prepare("DELETE FROM fee_type WHERE fee_type_id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    redirect_to("fee_type.php", "Fee type deleted successfully.");
}

if ($conn->errno === 1451 || $conn->errno === 1452) {
    redirect_to("fee_type.php", "Delete failed: payments still use this fee type.", "error");
}

redirect_to("fee_type.php", "Delete failed: " . $stmt->error, "error");

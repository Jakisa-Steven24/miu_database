<?php
require_once "db.php";

$id = isset($_GET["id"]) ? (int) $_GET["id"] : 0;

if ($id <= 0) {
    redirect_to("payment.php", "Invalid payment id.", "error");
}

$stmt = $conn->prepare("DELETE FROM payment WHERE payment_id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    redirect_to("payment.php", "Payment deleted successfully.");
}

redirect_to("payment.php", "Delete failed: " . $stmt->error, "error");

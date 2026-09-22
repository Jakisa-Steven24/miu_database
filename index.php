<?php
require_once "db.php";

$pageTitle = "Dashboard";

/**
 * Count the rows of one of the known tables.
 * The table name is checked against a whitelist before it is used.
 */
function countRows($conn, $table)
{
    $allowed = ["department", "lecturer", "course", "student", "enrollment", "fee_type", "payment"];

    if (!in_array($table, $allowed, true)) {
        return 0;
    }

    $result = $conn->query("SELECT COUNT(*) AS c FROM `$table`");

    if (!$result) {
        return 0;
    }

    return (int) $result->fetch_assoc()["c"];
}

require "header.php";
?>

<div class="page-head">
  <div>
    <div class="breadcrumb">Home / Dashboard</div>
    <h1 class="page-title">Dashboard</h1>
    <div class="page-subtitle">Welcome to the MIU Database Forms.</div>
  </div>
</div>

<?= flash_alert() ?>

<div class="stats">
  <div class="stat">
    <div class="stat-label">Departments</div>
    <div class="stat-value"><?= countRows($conn, "department") ?></div>
  </div>
  <div class="stat">
    <div class="stat-label">Lecturers</div>
    <div class="stat-value"><?= countRows($conn, "lecturer") ?></div>
  </div>
  <div class="stat">
    <div class="stat-label">Courses</div>
    <div class="stat-value"><?= countRows($conn, "course") ?></div>
  </div>
  <div class="stat">
    <div class="stat-label">Students</div>
    <div class="stat-value"><?= countRows($conn, "student") ?></div>
  </div>
</div>

<div class="content-card">
  <div class="card-head">
    <span class="bar"></span>
    <h2>Database Forms</h2>
  </div>
  <div class="card-body">
    <p class="page-subtitle">
      Use the navigation menu to register students, manage academic records, define fee types and record payments.
      Every list page now shows View, Edit and Delete buttons for each record.
    </p>
    <div class="notice">Database connected: <strong><?= h($db) ?></strong></div>
  </div>
</div>

<?php require "footer.php"; ?>

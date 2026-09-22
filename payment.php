<?php
require_once "db.php";

$pageTitle = "Payment";

$editId = isset($_GET["edit"]) ? (int) $_GET["edit"] : 0;
$viewId = isset($_GET["view"]) ? (int) $_GET["view"] : 0;

$editing = fetch_row_by_id($conn, "payment", "payment_id", $editId);
$viewing = fetch_row_by_id($conn, "payment", "payment_id", $viewId);

if ($editing) {
    $pageTitle = "Edit Payment";
}

$students = fetch_all_rows($conn, "SELECT * FROM student ORDER BY registration_number");
$feeTypes = fetch_all_rows($conn, "SELECT * FROM fee_type ORDER BY fee_name");

$studentMap = [];
foreach ($students as $student) {
    $studentMap[$student["student_id"]] = $student["registration_number"] . " - " . $student["first_name"] . " " . $student["last_name"];
}

$feeMap = [];
foreach ($feeTypes as $fee) {
    $feeMap[$fee["fee_type_id"]] = $fee["fee_name"];
}

$payments = fetch_all_rows($conn, "SELECT * FROM payment ORDER BY payment_id DESC");

$methods     = ["Cash", "Mobile Money", "Bank", "Card"];
$defaultDate = $editing ? ($editing["payment_date"] ?? "") : date("Y-m-d");

require "header.php";
?>

<div class="page-head">
  <div>
    <div class="breadcrumb">Dashboard / Payment</div>
    <h1 class="page-title"><?= h($pageTitle) ?></h1>
    <div class="page-subtitle">Record and manage payments against a student and fee type.</div>
  </div>
</div>

<?= flash_alert() ?>

<?php if ($viewing): ?>
  <?= details_card("Payment Details", [
      "Student"           => $studentMap[$viewing["student_id"]] ?? "",
      "Fee Type"          => $feeMap[$viewing["fee_type_id"]] ?? "",
      "Amount (UGX)"      => number_format((float) $viewing["amount"], 2),
      "Payment Date"      => $viewing["payment_date"],
      "Payment Method"    => $viewing["method"],
      "Reference Number"  => $viewing["reference_no"],
      "Description"       => $viewing["payment_description"],
  ]) ?>
<?php endif; ?>

<div class="content-card">
  <div class="card-head">
    <span class="bar"></span>
    <h2><?= $editing ? "Edit Payment" : "Payment Information" ?></h2>
  </div>
  <div class="card-body">
    <form method="post" action="save_payment.php">
      <?php if ($editing): ?>
        <input type="hidden" name="record_id" value="<?= (int) $editing["payment_id"] ?>">
      <?php endif; ?>
      <div class="form-grid">
        <div class="field">
          <label>Student <span class="req">*</span></label>
          <select name="student_id" required>
            <option value="">Select student</option>
            <?php foreach ($students as $student): ?>
              <option value="<?= (int) $student["student_id"] ?>" <?= (int) ($editing["student_id"] ?? 0) === (int) $student["student_id"] ? "selected" : "" ?>>
                <?= h($student["registration_number"] . " - " . $student["first_name"] . " " . $student["last_name"]) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="field">
          <label>Fee Type <span class="req">*</span></label>
          <select name="fee_type_id" required>
            <option value="">Select fee type</option>
            <?php foreach ($feeTypes as $fee): ?>
              <option value="<?= (int) $fee["fee_type_id"] ?>" <?= (int) ($editing["fee_type_id"] ?? 0) === (int) $fee["fee_type_id"] ? "selected" : "" ?>>
                <?= h($fee["fee_name"]) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="field">
          <label>Amount (UGX) <span class="req">*</span></label>
          <input type="number" step="0.01" min="0.01" name="amount" required value="<?= h($editing["amount"] ?? "") ?>">
        </div>
        <div class="field">
          <label>Payment Date <span class="req">*</span></label>
          <input type="date" name="payment_date" required value="<?= h($defaultDate) ?>">
        </div>
        <div class="field">
          <label>Payment Method <span class="req">*</span></label>
          <select name="method" required>
            <option value="">Select method</option>
            <?php foreach ($methods as $method): ?>
              <option <?= ($editing["method"] ?? "") === $method ? "selected" : "" ?>><?= h($method) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="field">
          <label>Reference Number <span class="req">*</span></label>
          <input name="reference_no" required placeholder="Receipt / transaction reference" value="<?= h($editing["reference_no"] ?? "") ?>">
        </div>
        <div class="field full">
          <label>Payment Description</label>
          <textarea name="payment_description" placeholder="Optional description"><?= h($editing["payment_description"] ?? "") ?></textarea>
        </div>
      </div>
      <div class="actions">
        <?php if ($editing): ?>
          <a class="btn btn-secondary" href="payment.php">Cancel</a>
        <?php else: ?>
          <button type="reset" class="btn btn-secondary">Reset</button>
        <?php endif; ?>
        <button class="btn btn-primary"><?= $editing ? "Update Payment" : "Record Payment" ?></button>
      </div>
    </form>
  </div>
</div>

<div class="content-card">
  <div class="card-head record">
    <span class="bar"></span>
    <h2>Payment Records</h2>
  </div>
  <div class="card-body">
    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Student</th>
            <th>Fee Type</th>
            <th>Amount (UGX)</th>
            <th>Date</th>
            <th>Method</th>
            <th>Reference</th>
            <th class="th-actions">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!$payments): ?>
            <tr>
              <td class="empty" colspan="8">No payments yet. Record one using the form above.</td>
            </tr>
          <?php endif; ?>
          <?php foreach ($payments as $row): ?>
            <tr>
              <td><?= (int) $row["payment_id"] ?></td>
              <td><?= h($studentMap[$row["student_id"]] ?? "") ?></td>
              <td><?= h($feeMap[$row["fee_type_id"]] ?? "") ?></td>
              <td><?= number_format((float) $row["amount"], 2) ?></td>
              <td><?= h($row["payment_date"]) ?></td>
              <td><?= h($row["method"]) ?></td>
              <td><?= h($row["reference_no"]) ?></td>
              <td class="row-actions"><?= row_actions("payment", $row["payment_id"]) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php require "footer.php"; ?>

<?php
require_once "db.php";

$pageTitle = "Fee Type";

$editId = isset($_GET["edit"]) ? (int) $_GET["edit"] : 0;
$viewId = isset($_GET["view"]) ? (int) $_GET["view"] : 0;

$editing = fetch_row_by_id($conn, "fee_type", "fee_type_id", $editId);
$viewing = fetch_row_by_id($conn, "fee_type", "fee_type_id", $viewId);

if ($editing) {
    $pageTitle = "Edit Fee Type";
}

$feeTypes = fetch_all_rows($conn, "SELECT * FROM fee_type ORDER BY fee_name");

require "header.php";
?>

<div class="page-head">
  <div>
    <div class="breadcrumb">Dashboard / Fee Type</div>
    <h1 class="page-title"><?= h($pageTitle) ?></h1>
    <div class="page-subtitle">Define the categories used when recording student payments.</div>
  </div>
</div>

<?= flash_alert() ?>

<?php if ($viewing): ?>
  <?= details_card("Fee Type Details", [
      "Fee Name"    => $viewing["fee_name"],
      "Description" => $viewing["description"],
  ]) ?>
<?php endif; ?>

<div class="content-card">
  <div class="card-head">
    <span class="bar"></span>
    <h2><?= $editing ? "Edit Fee Type" : "Fee Type Information" ?></h2>
  </div>
  <div class="card-body">
    <form method="post" action="save_fee_type.php">
      <?php if ($editing): ?>
        <input type="hidden" name="record_id" value="<?= (int) $editing["fee_type_id"] ?>">
      <?php endif; ?>
      <div class="form-grid">
        <div class="field">
          <label>Fee Name <span class="req">*</span></label>
          <input name="fee_name" required placeholder="e.g. Tuition" value="<?= h($editing["fee_name"] ?? "") ?>">
        </div>
        <div class="field">
          <label>Description</label>
          <input name="description" placeholder="Describe the fee type" value="<?= h($editing["description"] ?? "") ?>">
        </div>
      </div>
      <div class="actions">
        <?php if ($editing): ?>
          <a class="btn btn-secondary" href="fee_type.php">Cancel</a>
        <?php else: ?>
          <button type="reset" class="btn btn-secondary">Reset</button>
        <?php endif; ?>
        <button class="btn btn-primary"><?= $editing ? "Update Fee Type" : "Register Fee Type" ?></button>
      </div>
    </form>
  </div>
</div>

<div class="content-card">
  <div class="card-head record">
    <span class="bar"></span>
    <h2>Fee Type Records</h2>
  </div>
  <div class="card-body">
    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Fee Name</th>
            <th>Description</th>
            <th class="th-actions">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!$feeTypes): ?>
            <tr>
              <td class="empty" colspan="4">No fee types yet. Register one using the form above.</td>
            </tr>
          <?php endif; ?>
          <?php foreach ($feeTypes as $fee): ?>
            <tr>
              <td><?= (int) $fee["fee_type_id"] ?></td>
              <td><?= h($fee["fee_name"]) ?></td>
              <td><?= h($fee["description"]) ?></td>
              <td class="row-actions"><?= row_actions("fee_type", $fee["fee_type_id"]) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php require "footer.php"; ?>

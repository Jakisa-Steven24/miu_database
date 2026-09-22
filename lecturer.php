<?php
require_once "db.php";

$pageTitle = "Lecturer Registration";

$editId = isset($_GET["edit"]) ? (int) $_GET["edit"] : 0;
$viewId = isset($_GET["view"]) ? (int) $_GET["view"] : 0;

$editing = fetch_row_by_id($conn, "lecturer", "lecturer_id", $editId);
$viewing = fetch_row_by_id($conn, "lecturer", "lecturer_id", $viewId);

if ($editing) {
    $pageTitle = "Edit Lecturer";
}

$departments = fetch_all_rows($conn, "SELECT * FROM department ORDER BY dept_name");

$deptMap = [];
foreach ($departments as $dept) {
    $deptMap[$dept["dept_id"]] = $dept["dept_code"] . " - " . $dept["dept_name"];
}

$lecturers = fetch_all_rows($conn, "SELECT * FROM lecturer ORDER BY last_name, first_name");

require "header.php";
?>

<div class="page-head">
  <div>
    <div class="breadcrumb">Dashboard / Lecturer</div>
    <h1 class="page-title"><?= h($pageTitle) ?></h1>
    <div class="page-subtitle">Register teaching staff and assign them to departments.</div>
  </div>
</div>

<?= flash_alert() ?>

<?php if ($viewing): ?>
  <?= details_card("Lecturer Details", [
      "Staff Number" => $viewing["staff_no"],
      "Full Name"    => $viewing["first_name"] . " " . $viewing["last_name"],
      "Department"   => $deptMap[$viewing["dept_id"]] ?? "",
      "Email"        => $viewing["email"],
      "Phone"        => $viewing["phone"],
  ]) ?>
<?php endif; ?>

<div class="content-card">
  <div class="card-head">
    <span class="bar"></span>
    <h2><?= $editing ? "Edit Lecturer" : "Lecturer Information" ?></h2>
  </div>
  <div class="card-body">
    <form method="post" action="save_lecturer.php">
      <?php if ($editing): ?>
        <input type="hidden" name="record_id" value="<?= (int) $editing["lecturer_id"] ?>">
      <?php endif; ?>
      <div class="form-grid">
        <div class="field">
          <label>Staff Number <span class="req">*</span></label>
          <input name="staff_no" required placeholder="e.g. STAFF001" value="<?= h($editing["staff_no"] ?? "") ?>">
        </div>
        <div class="field">
          <label>Department <span class="req">*</span></label>
          <select name="dept_id" required>
            <option value="">Select department</option>
            <?php foreach ($departments as $dept): ?>
              <option value="<?= (int) $dept["dept_id"] ?>" <?= (int) ($editing["dept_id"] ?? 0) === (int) $dept["dept_id"] ? "selected" : "" ?>>
                <?= h($dept["dept_code"] . " - " . $dept["dept_name"]) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="field">
          <label>First Name <span class="req">*</span></label>
          <input name="first_name" required value="<?= h($editing["first_name"] ?? "") ?>">
        </div>
        <div class="field">
          <label>Last Name <span class="req">*</span></label>
          <input name="last_name" required value="<?= h($editing["last_name"] ?? "") ?>">
        </div>
        <div class="field">
          <label>Email</label>
          <input type="email" name="email" value="<?= h($editing["email"] ?? "") ?>">
        </div>
        <div class="field">
          <label>Phone</label>
          <input name="phone" value="<?= h($editing["phone"] ?? "") ?>">
        </div>
      </div>
      <div class="actions">
        <?php if ($editing): ?>
          <a class="btn btn-secondary" href="lecturer.php">Cancel</a>
        <?php else: ?>
          <button type="reset" class="btn btn-secondary">Reset</button>
        <?php endif; ?>
        <button class="btn btn-primary"><?= $editing ? "Update Lecturer" : "Register Lecturer" ?></button>
      </div>
    </form>
  </div>
</div>

<div class="content-card">
  <div class="card-head record">
    <span class="bar"></span>
    <h2>Lecturer Records</h2>
  </div>
  <div class="card-body">
    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Staff No</th>
            <th>Name</th>
            <th>Department</th>
            <th>Email</th>
            <th>Phone</th>
            <th class="th-actions">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!$lecturers): ?>
            <tr>
              <td class="empty" colspan="7">No lecturers yet. Register one using the form above.</td>
            </tr>
          <?php endif; ?>
          <?php foreach ($lecturers as $lect): ?>
            <tr>
              <td><?= (int) $lect["lecturer_id"] ?></td>
              <td><?= h($lect["staff_no"]) ?></td>
              <td><?= h($lect["first_name"] . " " . $lect["last_name"]) ?></td>
              <td><?= h($deptMap[$lect["dept_id"]] ?? "") ?></td>
              <td><?= h($lect["email"]) ?></td>
              <td><?= h($lect["phone"]) ?></td>
              <td class="row-actions"><?= row_actions("lecturer", $lect["lecturer_id"]) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php require "footer.php"; ?>

<?php
require_once "db.php";

$pageTitle = "Department Registration";

$editId = isset($_GET["edit"]) ? (int) $_GET["edit"] : 0;
$viewId = isset($_GET["view"]) ? (int) $_GET["view"] : 0;

$editing = fetch_row_by_id($conn, "department", "dept_id", $editId);
$viewing = fetch_row_by_id($conn, "department", "dept_id", $viewId);

if ($editing) {
    $pageTitle = "Edit Department";
}

$departments = fetch_all_rows($conn, "SELECT * FROM department ORDER BY dept_name");

require "header.php";
?>

<div class="page-head">
  <div>
    <div class="breadcrumb">Dashboard / Department</div>
    <h1 class="page-title"><?= h($pageTitle) ?></h1>
    <div class="page-subtitle">Create, edit and delete university departments.</div>
  </div>
</div>

<?= flash_alert() ?>

<?php if ($viewing): ?>
  <?= details_card("Department Details", [
      "Department Code"     => $viewing["dept_code"],
      "Department Name"     => $viewing["dept_name"],
      "Office Location"     => $viewing["office_location"],
      "Phone"               => $viewing["phone"],
      "Head of Department"  => $viewing["head_of_dept"],
      "Email"               => $viewing["email"],
  ]) ?>
<?php endif; ?>

<div class="content-card">
  <div class="card-head">
    <span class="bar"></span>
    <h2><?= $editing ? "Edit Department" : "Department Information" ?></h2>
  </div>
  <div class="card-body">
    <form method="post" action="save_department.php">
      <?php if ($editing): ?>
        <input type="hidden" name="record_id" value="<?= (int) $editing["dept_id"] ?>">
      <?php endif; ?>
      <div class="form-grid">
        <div class="field">
          <label>Department Code <span class="req">*</span></label>
          <input name="dept_code" required placeholder="e.g. DCS" value="<?= h($editing["dept_code"] ?? "") ?>">
        </div>
        <div class="field">
          <label>Department Name <span class="req">*</span></label>
          <input name="dept_name" required placeholder="Department of Computer Science" value="<?= h($editing["dept_name"] ?? "") ?>">
        </div>
        <div class="field">
          <label>Office Location</label>
          <input name="office_location" placeholder="Main Campus" value="<?= h($editing["office_location"] ?? "") ?>">
        </div>
        <div class="field">
          <label>Phone</label>
          <input name="phone" placeholder="+256..." value="<?= h($editing["phone"] ?? "") ?>">
        </div>
        <div class="field">
          <label>Head of Department</label>
          <input name="head_of_dept" placeholder="Full name" value="<?= h($editing["head_of_dept"] ?? "") ?>">
        </div>
        <div class="field">
          <label>Email</label>
          <input type="email" name="email" placeholder="department@miu.ac.ug" value="<?= h($editing["email"] ?? "") ?>">
        </div>
      </div>
      <div class="actions">
        <?php if ($editing): ?>
          <a class="btn btn-secondary" href="department.php">Cancel</a>
        <?php else: ?>
          <button type="reset" class="btn btn-secondary">Reset</button>
        <?php endif; ?>
        <button class="btn btn-primary"><?= $editing ? "Update Department" : "Register Department" ?></button>
      </div>
    </form>
  </div>
</div>

<div class="content-card">
  <div class="card-head record">
    <span class="bar"></span>
    <h2>Department Records</h2>
  </div>
  <div class="card-body">
    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Code</th>
            <th>Name</th>
            <th>Office Location</th>
            <th>Phone</th>
            <th>Head of Dept</th>
            <th>Email</th>
            <th class="th-actions">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!$departments): ?>
            <tr>
              <td class="empty" colspan="8">No departments yet. Use the form above to register one.</td>
            </tr>
          <?php endif; ?>
          <?php foreach ($departments as $dept): ?>
            <tr>
              <td><?= (int) $dept["dept_id"] ?></td>
              <td><?= h($dept["dept_code"]) ?></td>
              <td><?= h($dept["dept_name"]) ?></td>
              <td><?= h($dept["office_location"]) ?></td>
              <td><?= h($dept["phone"]) ?></td>
              <td><?= h($dept["head_of_dept"]) ?></td>
              <td><?= h($dept["email"]) ?></td>
              <td class="row-actions"><?= row_actions("department", $dept["dept_id"]) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php require "footer.php"; ?>

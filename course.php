<?php
require_once "db.php";

$pageTitle = "Course Registration";

$editId = isset($_GET["edit"]) ? (int) $_GET["edit"] : 0;
$viewId = isset($_GET["view"]) ? (int) $_GET["view"] : 0;

$editing = fetch_row_by_id($conn, "course", "course_id", $editId);
$viewing = fetch_row_by_id($conn, "course", "course_id", $viewId);

if ($editing) {
    $pageTitle = "Edit Course";
}

$departments = fetch_all_rows($conn, "SELECT * FROM department ORDER BY dept_name");
$lecturers   = fetch_all_rows($conn, "SELECT * FROM lecturer ORDER BY last_name, first_name");

$deptMap = [];
foreach ($departments as $dept) {
    $deptMap[$dept["dept_id"]] = $dept["dept_code"] . " - " . $dept["dept_name"];
}

$lecturerMap = [];
foreach ($lecturers as $lect) {
    $lecturerMap[$lect["lecturer_id"]] = $lect["staff_no"] . " - " . $lect["first_name"] . " " . $lect["last_name"];
}

$courses = fetch_all_rows($conn, "SELECT * FROM course ORDER BY course_code");

require "header.php";
?>

<div class="page-head">
  <div>
    <div class="breadcrumb">Dashboard / Course</div>
    <h1 class="page-title"><?= h($pageTitle) ?></h1>
    <div class="page-subtitle">Create courses and assign their department and lecturer.</div>
  </div>
</div>

<?= flash_alert() ?>

<?php if ($viewing): ?>
  <?= details_card("Course Details", [
      "Course Code"   => $viewing["course_code"],
      "Course Title"  => $viewing["course_title"],
      "Credits"       => $viewing["credits"],
      "Department"    => $deptMap[$viewing["dept_id"]] ?? "",
      "Lecturer"      => $lecturerMap[$viewing["lecturer_id"]] ?? "",
  ]) ?>
<?php endif; ?>

<div class="content-card">
  <div class="card-head">
    <span class="bar"></span>
    <h2><?= $editing ? "Edit Course" : "Course Information" ?></h2>
  </div>
  <div class="card-body">
    <form method="post" action="save_course.php">
      <?php if ($editing): ?>
        <input type="hidden" name="record_id" value="<?= (int) $editing["course_id"] ?>">
      <?php endif; ?>
      <div class="form-grid">
        <div class="field">
          <label>Course Code <span class="req">*</span></label>
          <input name="course_code" required placeholder="e.g. BCS101" value="<?= h($editing["course_code"] ?? "") ?>">
        </div>
        <div class="field">
          <label>Course Title <span class="req">*</span></label>
          <input name="course_title" required placeholder="Database Development" value="<?= h($editing["course_title"] ?? "") ?>">
        </div>
        <div class="field">
          <label>Credits <span class="req">*</span></label>
          <input type="number" name="credits" min="1" required value="<?= h($editing["credits"] ?? "") ?>">
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
          <label>Lecturer <span class="req">*</span></label>
          <select name="lecturer_id" required>
            <option value="">Select lecturer</option>
            <?php foreach ($lecturers as $lect): ?>
              <option value="<?= (int) $lect["lecturer_id"] ?>" <?= (int) ($editing["lecturer_id"] ?? 0) === (int) $lect["lecturer_id"] ? "selected" : "" ?>>
                <?= h($lect["staff_no"] . " - " . $lect["first_name"] . " " . $lect["last_name"]) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>
      <div class="actions">
        <?php if ($editing): ?>
          <a class="btn btn-secondary" href="course.php">Cancel</a>
        <?php else: ?>
          <button type="reset" class="btn btn-secondary">Reset</button>
        <?php endif; ?>
        <button class="btn btn-primary"><?= $editing ? "Update Course" : "Register Course" ?></button>
      </div>
    </form>
  </div>
</div>

<div class="content-card">
  <div class="card-head record">
    <span class="bar"></span>
    <h2>Course Records</h2>
  </div>
  <div class="card-body">
    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Code</th>
            <th>Title</th>
            <th>Credits</th>
            <th>Department</th>
            <th>Lecturer</th>
            <th class="th-actions">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!$courses): ?>
            <tr>
              <td class="empty" colspan="7">No courses yet. Register one using the form above.</td>
            </tr>
          <?php endif; ?>
          <?php foreach ($courses as $course): ?>
            <tr>
              <td><?= (int) $course["course_id"] ?></td>
              <td><?= h($course["course_code"]) ?></td>
              <td><?= h($course["course_title"]) ?></td>
              <td><?= (int) $course["credits"] ?></td>
              <td><?= h($deptMap[$course["dept_id"]] ?? "") ?></td>
              <td><?= h($lecturerMap[$course["lecturer_id"]] ?? "") ?></td>
              <td class="row-actions"><?= row_actions("course", $course["course_id"]) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php require "footer.php"; ?>

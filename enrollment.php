<?php
require_once "db.php";

$pageTitle = "Enrollment";

$editId = isset($_GET["edit"]) ? (int) $_GET["edit"] : 0;
$viewId = isset($_GET["view"]) ? (int) $_GET["view"] : 0;

$editing = fetch_row_by_id($conn, "enrollment", "enrollment_id", $editId);
$viewing = fetch_row_by_id($conn, "enrollment", "enrollment_id", $viewId);

if ($editing) {
    $pageTitle = "Edit Enrollment";
}

$students = fetch_all_rows($conn, "SELECT * FROM student ORDER BY registration_number");
$courses  = fetch_all_rows($conn, "SELECT * FROM course ORDER BY course_code");

$studentMap = [];
foreach ($students as $student) {
    $studentMap[$student["student_id"]] = $student["registration_number"] . " - " . $student["first_name"] . " " . $student["last_name"];
}

$courseMap = [];
foreach ($courses as $course) {
    $courseMap[$course["course_id"]] = $course["course_code"] . " - " . $course["course_title"];
}

$enrollments = fetch_all_rows($conn, "SELECT * FROM enrollment ORDER BY enrollment_id DESC");

$defaultDate = $editing ? ($editing["enrollment_date"] ?? "") : date("Y-m-d");

require "header.php";
?>

<div class="page-head">
  <div>
    <div class="breadcrumb">Dashboard / Enrollment</div>
    <h1 class="page-title"><?= h($pageTitle) ?></h1>
    <div class="page-subtitle">Record and manage student enrollments in courses.</div>
  </div>
</div>

<?= flash_alert() ?>

<?php if ($viewing): ?>
  <?= details_card("Enrollment Details", [
      "Student"         => $studentMap[$viewing["student_id"]] ?? "",
      "Course"          => $courseMap[$viewing["course_id"]] ?? "",
      "Enrollment Date" => $viewing["enrollment_date"],
      "Status"          => $viewing["status"],
  ]) ?>
<?php endif; ?>

<div class="content-card">
  <div class="card-head">
    <span class="bar"></span>
    <h2><?= $editing ? "Edit Enrollment" : "Enrollment Information" ?></h2>
  </div>
  <div class="card-body">
    <form method="post" action="save_enrollment.php">
      <?php if ($editing): ?>
        <input type="hidden" name="record_id" value="<?= (int) $editing["enrollment_id"] ?>">
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
          <label>Course <span class="req">*</span></label>
          <select name="course_id" required>
            <option value="">Select course</option>
            <?php foreach ($courses as $course): ?>
              <option value="<?= (int) $course["course_id"] ?>" <?= (int) ($editing["course_id"] ?? 0) === (int) $course["course_id"] ? "selected" : "" ?>>
                <?= h($course["course_code"] . " - " . $course["course_title"]) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="field">
          <label>Enrollment Date <span class="req">*</span></label>
          <input type="date" name="enrollment_date" required value="<?= h($defaultDate) ?>">
        </div>
        <div class="field">
          <label>Status</label>
          <select name="status">
            <option <?= ($editing["status"] ?? "Enrolled") === "Enrolled" ? "selected" : "" ?>>Enrolled</option>
            <option <?= ($editing["status"] ?? "") === "Dropped" ? "selected" : "" ?>>Dropped</option>
            <option <?= ($editing["status"] ?? "") === "Completed" ? "selected" : "" ?>>Completed</option>
          </select>
        </div>
      </div>
      <div class="actions">
        <?php if ($editing): ?>
          <a class="btn btn-secondary" href="enrollment.php">Cancel</a>
        <?php else: ?>
          <button type="reset" class="btn btn-secondary">Reset</button>
        <?php endif; ?>
        <button class="btn btn-primary"><?= $editing ? "Update Enrollment" : "Save Enrollment" ?></button>
      </div>
    </form>
  </div>
</div>

<div class="content-card">
  <div class="card-head record">
    <span class="bar"></span>
    <h2>Enrollment Records</h2>
  </div>
  <div class="card-body">
    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Student</th>
            <th>Course</th>
            <th>Enrollment Date</th>
            <th>Status</th>
            <th class="th-actions">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!$enrollments): ?>
            <tr>
              <td class="empty" colspan="6">No enrollments yet. Record one using the form above.</td>
            </tr>
          <?php endif; ?>
          <?php foreach ($enrollments as $row): ?>
            <tr>
              <td><?= (int) $row["enrollment_id"] ?></td>
              <td><?= h($studentMap[$row["student_id"]] ?? "") ?></td>
              <td><?= h($courseMap[$row["course_id"]] ?? "") ?></td>
              <td><?= h($row["enrollment_date"]) ?></td>
              <td>
                <?php
                $status = $row["status"] ?? "";
                if ($status === "Enrolled") {
                    $badge = "badge-green";
                } elseif ($status === "Dropped") {
                    $badge = "badge-red";
                } else {
                    $badge = "badge-gold";
                }
                ?>
                <span class="badge <?= $badge ?>"><?= h($status) ?></span>
              </td>
              <td class="row-actions"><?= row_actions("enrollment", $row["enrollment_id"]) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php require "footer.php"; ?>

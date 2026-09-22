<?php
require_once "db.php";

$pageTitle = "Student Registration";

$editId = isset($_GET["edit"]) ? (int) $_GET["edit"] : 0;
$viewId = isset($_GET["view"]) ? (int) $_GET["view"] : 0;

$editing = fetch_row_by_id($conn, "student", "student_id", $editId);
$viewing = fetch_row_by_id($conn, "student", "student_id", $viewId);

if ($editing) {
    $pageTitle = "Edit Student";
}

$courses = fetch_all_rows($conn, "SELECT * FROM course ORDER BY course_code");

$courseMap = [];
foreach ($courses as $course) {
    $courseMap[$course["course_id"]] = $course["course_code"] . " - " . $course["course_title"];
}

$students = fetch_all_rows($conn, "SELECT * FROM student ORDER BY registration_number");

require "header.php";
?>

<div class="page-head">
  <div>
    <div class="breadcrumb">Dashboard / Student</div>
    <h1 class="page-title"><?= h($pageTitle) ?></h1>
    <div class="page-subtitle">Register a new student into the university database.</div>
  </div>
</div>

<?= flash_alert() ?>

<?php if ($viewing): ?>
  <?= details_card("Student Details", [
      "Registration Number" => $viewing["registration_number"],
      "Full Name"           => $viewing["first_name"] . " " . $viewing["last_name"],
      "Gender"              => $viewing["gender"],
      "Date of Birth"       => $viewing["date_of_birth"],
      "Email"               => $viewing["email"],
      "Address"             => $viewing["address"],
      "Course"              => $courseMap[$viewing["course_id"]] ?? "",
  ]) ?>
<?php endif; ?>

<div class="content-card">
  <div class="card-head">
    <span class="bar"></span>
    <h2><?= $editing ? "Edit Student" : "Student Information" ?></h2>
  </div>
  <div class="card-body">
    <form method="post" action="save_student.php">
      <?php if ($editing): ?>
        <input type="hidden" name="record_id" value="<?= (int) $editing["student_id"] ?>">
      <?php endif; ?>
      <div class="form-grid">
        <div class="field">
          <label>Registration Number <span class="req">*</span></label>
          <input name="registration_number" required placeholder="e.g. 2025/BCS/001" value="<?= h($editing["registration_number"] ?? "") ?>">
        </div>
        <div class="field">
          <label>First Name <span class="req">*</span></label>
          <input name="first_name" required placeholder="Enter first name" value="<?= h($editing["first_name"] ?? "") ?>">
        </div>
        <div class="field">
          <label>Last Name <span class="req">*</span></label>
          <input name="last_name" required placeholder="Enter last name" value="<?= h($editing["last_name"] ?? "") ?>">
        </div>
        <div class="field">
          <label>Gender</label>
          <select name="gender">
            <option value="">Select gender</option>
            <option <?= ($editing["gender"] ?? "") === "Male" ? "selected" : "" ?>>Male</option>
            <option <?= ($editing["gender"] ?? "") === "Female" ? "selected" : "" ?>>Female</option>
            <option <?= ($editing["gender"] ?? "") === "Other" ? "selected" : "" ?>>Other</option>
          </select>
        </div>
        <div class="field">
          <label>Date of Birth</label>
          <input type="date" name="date_of_birth" value="<?= h($editing["date_of_birth"] ?? "") ?>">
        </div>
        <div class="field">
          <label>Email</label>
          <input type="email" name="email" placeholder="student@example.com" value="<?= h($editing["email"] ?? "") ?>">
        </div>
        <div class="field full">
          <label>Address</label>
          <textarea name="address" placeholder="Enter student's address"><?= h($editing["address"] ?? "") ?></textarea>
        </div>
        <div class="field full">
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
      </div>
      <div class="notice">
        <strong>Note:</strong> The course list is loaded directly from the <strong>course</strong> table in the MIU database.
        Create a course first if the list is empty.
      </div>
      <div class="actions">
        <?php if ($editing): ?>
          <a class="btn btn-secondary" href="student.php">Cancel</a>
        <?php else: ?>
          <button type="reset" class="btn btn-secondary">Reset</button>
        <?php endif; ?>
        <button class="btn btn-primary"><?= $editing ? "Update Student" : "Register Student" ?></button>
      </div>
    </form>
  </div>
</div>

<div class="content-card">
  <div class="card-head record">
    <span class="bar"></span>
    <h2>Student Records</h2>
  </div>
  <div class="card-body">
    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Reg No</th>
            <th>Name</th>
            <th>Gender</th>
            <th>Date of Birth</th>
            <th>Email</th>
            <th>Course</th>
            <th class="th-actions">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!$students): ?>
            <tr>
              <td class="empty" colspan="8">No students yet. Register one using the form above.</td>
            </tr>
          <?php endif; ?>
          <?php foreach ($students as $student): ?>
            <tr>
              <td><?= (int) $student["student_id"] ?></td>
              <td><?= h($student["registration_number"]) ?></td>
              <td><?= h($student["first_name"] . " " . $student["last_name"]) ?></td>
              <td><?= h($student["gender"]) ?></td>
              <td><?= h($student["date_of_birth"]) ?></td>
              <td><?= h($student["email"]) ?></td>
              <td><?= h($courseMap[$student["course_id"]] ?? "") ?></td>
              <td class="row-actions"><?= row_actions("student", $student["student_id"]) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php require "footer.php"; ?>

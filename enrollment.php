<?php
require "db.php"; $pageTitle="Enrollment"; $msg=$_GET['msg']??'';
$students=$conn->query("SELECT student_id,registration_number,first_name,last_name FROM student ORDER BY registration_number");
$courses=$conn->query("SELECT course_id,course_code,course_title FROM course ORDER BY course_code");
require "header.php";
?>
<div class="page-head"><div><div class="breadcrumb">Dashboard / Enrollment</div><h1 class="page-title">Student Enrollment</h1><div class="page-subtitle">Record a student's enrollment in a course.</div></div></div>
<?php if($msg): ?><div class="alert success"><?=htmlspecialchars($msg)?></div><?php endif; ?>
<div class="content-card"><div class="card-head"><span class="bar"></span><h2>Enrollment Information</h2></div><div class="card-body"><form method="post" action="save_enrollment.php"><div class="form-grid">
<div class="field"><label>Student <span class="req">*</span></label><select name="student_id" required><option value="">Select student</option><?php while($s=$students->fetch_assoc()): ?><option value="<?=$s['student_id']?>"><?=htmlspecialchars($s['registration_number']." - ".$s['first_name']." ".$s['last_name'])?></option><?php endwhile;?></select></div>
<div class="field"><label>Course <span class="req">*</span></label><select name="course_id" required><option value="">Select course</option><?php while($c=$courses->fetch_assoc()): ?><option value="<?=$c['course_id']?>"><?=htmlspecialchars($c['course_code']." - ".$c['course_title'])?></option><?php endwhile;?></select></div>
<div class="field"><label>Enrollment Date <span class="req">*</span></label><input type="date" name="enrollment_date" value="<?=date('Y-m-d')?>" required></div>
<div class="field"><label>Status</label><select name="status"><option>Enrolled</option><option>Dropped</option><option>Completed</option></select></div>
</div><div class="actions"><button type="reset" class="btn btn-secondary">Reset</button><button class="btn btn-primary">Save Enrollment</button></div></form></div></div>
<div class="footer">© 2025 Metropolitan International University | Student Management System</div><?php require "footer.php"; ?>
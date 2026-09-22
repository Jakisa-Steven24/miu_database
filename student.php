<?php
require "db.php"; $pageTitle="Student Registration"; $msg=$_GET['msg']??'';
$courses=$conn->query("SELECT course_id,course_code,course_title FROM course ORDER BY course_code");
require "header.php";
?>
<div class="page-head"><div><div class="breadcrumb">Dashboard / Student</div><h1 class="page-title">Student Registration</h1><div class="page-subtitle">Register a new student into the university database.</div></div></div>
<?php if($msg): ?><div class="alert success"><?=htmlspecialchars($msg)?></div><?php endif; ?>
<div class="content-card"><div class="card-head"><span class="bar"></span><h2>Student Information</h2></div><div class="card-body">
<form method="post" action="save_student.php">
<div class="form-grid">
<div class="field"><label>Registration Number <span class="req">*</span></label><input name="registration_number" required placeholder="e.g. 2025/BCS/001"></div>
<div class="field"><label>First Name <span class="req">*</span></label><input name="first_name" required placeholder="Enter first name"></div>
<div class="field"><label>Last Name <span class="req">*</span></label><input name="last_name" required placeholder="Enter last name"></div>
<div class="field"><label>Gender</label><select name="gender"><option value="">Select gender</option><option>Male</option><option>Female</option><option>Other</option></select></div>
<div class="field"><label>Date of Birth</label><input type="date" name="date_of_birth"></div>
<div class="field"><label>Email</label><input type="email" name="email" placeholder="student@example.com"></div>
<div class="field full"><label>Address</label><textarea name="address" placeholder="Enter student's address"></textarea></div>
<div class="field full"><label>Course <span class="req">*</span></label><select name="course_id" required><option value="">Select course</option><?php while($c=$courses->fetch_assoc()): ?><option value="<?=$c['course_id']?>"><?=htmlspecialchars($c['course_code']." - ".$c['course_title'])?></option><?php endwhile;?></select></div>
</div>
<div class="notice"><strong>Note:</strong> The course list is loaded directly from the <strong>course</strong> table in the MIU database. Create a course first if the list is empty.</div>
<div class="actions"><button type="reset" class="btn btn-secondary">Reset</button><button class="btn btn-primary">Register Student</button></div>
</form></div></div>
<div class="footer">© 2025 Metropolitan International University | Student Management System</div>
<?php require "footer.php"; ?>
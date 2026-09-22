<?php
require "db.php"; 
$pageTitle="Course Registration"; 
$msg=$_GET['msg']??'';
$depts=$conn->query("SELECT dept_id,dept_code,dept_name FROM department ORDER BY dept_name");
$lect=$conn->query("SELECT lecturer_id,staff_no,first_name,last_name FROM lecturer ORDER BY last_name,first_name");
require "header.php";
?>
<div class="page-head"
    <div>
        <div class="breadcrumb">Dashboard / Course</div
        <h1 class="page-title">Course Registration</h1>
        <div class="page-subtitle">Create courses and assign their department and lecturer.</div>
    </div>
</div>
<?php if($msg): ?>
    <div class="alert success"><?=htmlspecialchars($msg)?></div>
    <?php endif; ?>
<div class="content-card"><div class="card-head"><span class="bar"></span><h2>Course Information</h2></div><div class="card-body"><form method="post" action="save_course.php"><div class="form-grid">
<div class="field"><label>Course Code <span class="req">*</span></label><input name="course_code" required placeholder="e.g. BCS101"></div>
<div class="field"><label>Course Title <span class="req">*</span></label><input name="course_title" required placeholder="Database Development"></div>
<div class="field"><label>Credits <span class="req">*</span></label><input type="number" name="credits" min="1" required></div>
<div class="field"><label>Department <span class="req">*</span></label><select name="dept_id" required><option value="">Select department</option><?php while($d=$depts->fetch_assoc()): ?><option value="<?=$d['dept_id']?>"><?=htmlspecialchars($d['dept_code']." - ".$d['dept_name'])?></option><?php endwhile;?></select></div>
<div class="field"><label>Lecturer <span class="req">*</span></label><select name="lecturer_id" required><option value="">Select lecturer</option><?php while($l=$lect->fetch_assoc()): ?><option value="<?=$l['lecturer_id']?>"><?=htmlspecialchars($l['staff_no']." - ".$l['first_name']." ".$l['last_name'])?></option><?php endwhile;?></select></div>
</div><div class="actions"><button type="reset" class="btn btn-secondary">Reset</button><button class="btn btn-primary">Register Course</button></div></form></div></div>
<div class="footer">© 2025 Metropolitan International University | Student Management System</div><?php require "footer.php"; ?>
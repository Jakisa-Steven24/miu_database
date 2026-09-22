<?php
require "db.php"; $pageTitle="Lecturer Registration"; $msg=$_GET['msg']??'';
$depts=$conn->query("SELECT dept_id,dept_code,dept_name FROM department ORDER BY dept_name");
require "header.php";
?>
<div class="page-head"><div><div class="breadcrumb">Dashboard / Lecturer</div><h1 class="page-title">Lecturer Registration</h1><div class="page-subtitle">Register teaching staff and assign them to departments.</div></div></div>
<?php if($msg): ?><div class="alert success"><?=htmlspecialchars($msg)?></div><?php endif; ?>
<div class="content-card"><div class="card-head"><span class="bar"></span><h2>Lecturer Information</h2></div><div class="card-body"><form method="post" action="save_lecturer.php"><div class="form-grid">
<div class="field"><label>Staff Number <span class="req">*</span></label><input name="staff_no" required></div>
<div class="field"><label>Department <span class="req">*</span></label><select name="dept_id" required><option value="">Select department</option><?php while($d=$depts->fetch_assoc()): ?><option value="<?=$d['dept_id']?>"><?=htmlspecialchars($d['dept_code']." - ".$d['dept_name'])?></option><?php endwhile;?></select></div>
<div class="field"><label>First Name <span class="req">*</span></label><input name="first_name" required></div>
<div class="field"><label>Last Name <span class="req">*</span></label><input name="last_name" required></div>
<div class="field"><label>Email</label><input type="email" name="email"></div>
<div class="field"><label>Phone</label><input name="phone"></div>
</div><div class="actions"><button type="reset" class="btn btn-secondary">Reset</button><button class="btn btn-primary">Register Lecturer</button></div></form></div></div>
<div class="footer">© 2025 Metropolitan International University | Student Management System</div><?php require "footer.php"; ?>
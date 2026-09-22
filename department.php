<?php
require_once "db.php"; $pageTitle="Department Registration"; $msg=$_GET['msg']??'';
require "header.php";
?>
<div class="page-head"><div><div class="breadcrumb">Dashboard / Department</div><h1 class="page-title">Department Registration</h1><div class="page-subtitle">Create and manage university departments.</div></div></div>
<?php if($msg): ?><div class="alert success"><?=htmlspecialchars($msg)?></div><?php endif; ?>
<div class="content-card"><div class="card-head"><span class="bar"></span><h2>Department Information</h2></div><div class="card-body">
<form method="post" action="save_department.php">
<div class="form-grid">
<div class="field"><label>Department Code <span class="req">*</span></label><input name="dept_code" required placeholder="e.g. DCS"></div>
<div class="field"><label>Department Name <span class="req">*</span></label><input name="dept_name" required placeholder="Department of Computer Science"></div>
<div class="field"><label>Office Location</label><input name="office_location" placeholder="Main Campus"></div>
<div class="field"><label>Phone</label><input name="phone" placeholder="+256..."></div>
<div class="field"><label>Head of Department</label><input name="head_of_dept" placeholder="Full name"></div>
<div class="field"><label>Email</label><input type="email" name="email" placeholder="department@miu.ac.ug"></div>
</div>
<div class="actions"><button type="reset" class="btn btn-secondary">Reset</button><button class="btn btn-primary">Register Department</button></div>
</form></div></div>
<div class="footer">© 2025 Metropolitan International University | Student Management System</div>
<?php require "footer.php"; ?>
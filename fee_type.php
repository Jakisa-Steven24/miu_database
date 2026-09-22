<?php
require "db.php"; $pageTitle="Fee Type"; $msg=$_GET['msg']??'';
require "header.php";
?>
<div class="page-head"><div><div class="breadcrumb">Dashboard / Fee Type</div><h1 class="page-title">Fee Type Registration</h1><div class="page-subtitle">Define the categories used when recording student payments.</div></div></div>
<?php if($msg): ?><div class="alert success"><?=htmlspecialchars($msg)?></div><?php endif; ?>
<div class="content-card"><div class="card-head"><span class="bar"></span><h2>Fee Type Information</h2></div><div class="card-body"><form method="post" action="save_fee_type.php"><div class="form-grid">
<div class="field"><label>Fee Name <span class="req">*</span></label><input name="fee_name" required placeholder="e.g. Tuition"></div>
<div class="field"><label>Description</label><input name="description" placeholder="Describe the fee type"></div>
</div><div class="actions"><button type="reset" class="btn btn-secondary">Reset</button><button class="btn btn-primary">Register Fee Type</button></div></form></div></div>
<div class="footer">© 2025 Metropolitan International University | Student Management System</div><?php require "footer.php"; ?>
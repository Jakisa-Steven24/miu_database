<?php
require "db.php"; $pageTitle="Payment"; $msg=$_GET['msg']??'';
$students=$conn->query("SELECT student_id,registration_number,first_name,last_name FROM student ORDER BY registration_number");
$fees=$conn->query("SELECT fee_type_id,fee_name FROM fee_type ORDER BY fee_name");
require "header.php";
?>
<div class="page-head"><div><div class="breadcrumb">Dashboard / Payment</div><h1 class="page-title">Student Payment</h1><div class="page-subtitle">Record a payment against a student and fee type.</div></div></div>
<?php if($msg): ?><div class="alert success"><?=htmlspecialchars($msg)?></div><?php endif; ?>
<div class="content-card"><div class="card-head"><span class="bar"></span><h2>Payment Information</h2></div><div class="card-body"><form method="post" action="save_payment.php"><div class="form-grid">
<div class="field"><label>Student <span class="req">*</span></label><select name="student_id" required><option value="">Select student</option><?php while($s=$students->fetch_assoc()): ?><option value="<?=$s['student_id']?>"><?=htmlspecialchars($s['registration_number']." - ".$s['first_name']." ".$s['last_name'])?></option><?php endwhile;?></select></div>
<div class="field"><label>Fee Type <span class="req">*</span></label><select name="fee_type_id" required><option value="">Select fee type</option><?php while($f=$fees->fetch_assoc()): ?><option value="<?=$f['fee_type_id']?>"><?=htmlspecialchars($f['fee_name'])?></option><?php endwhile;?></select></div>
<div class="field"><label>Amount (UGX) <span class="req">*</span></label><input type="number" step="0.01" min="0.01" name="amount" required></div>
<div class="field"><label>Payment Date <span class="req">*</span></label><input type="date" name="payment_date" value="<?=date('Y-m-d')?>" required></div>
<div class="field"><label>Payment Method <span class="req">*</span></label><select name="method" required><option value="">Select method</option><option>Cash</option><option>Mobile Money</option><option>Bank</option><option>Card</option></select></div>
<div class="field"><label>Reference Number <span class="req">*</span></label><input name="reference_no" required placeholder="Receipt / transaction reference"></div>
<div class="field full"><label>Payment Description</label><textarea name="payment_description" placeholder="Optional description"></textarea></div>
</div><div class="actions"><button type="reset" class="btn btn-secondary">Reset</button><button class="btn btn-primary">Record Payment</button></div></form></div></div>
<div class="footer">© 2025 Metropolitan International University | Student Management System</div><?php require "footer.php"; ?>
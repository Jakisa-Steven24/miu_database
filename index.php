<?php
require_once "db.php";
$pageTitle="Dashboard";
function countRows($conn,$table){
    $allowed=['department','lecturer','course','student','enrollment','fee_type','payment'];
    if(!in_array($table,$allowed,true)) return 0;
    $r=$conn->query("SELECT COUNT(*) c FROM `$table`");
    return $r ? (int)$r->fetch_assoc()['c'] : 0;
}
require "header.php";
?>
<div class="page-head">
  <div><div class="breadcrumb">Home / Dashboard</div><h1 class="page-title">Dashboard</h1><div class="page-subtitle">Welcome to the MIU Student Management System.</div></div>
</div>
<div class="stats">
  <div class="stat"><div class="stat-label">Departments</div><div class="stat-value"><?=countRows($conn,'department')?></div></div>
  <div class="stat"><div class="stat-label">Lecturers</div><div class="stat-value"><?=countRows($conn,'lecturer')?></div></div>
  <div class="stat"><div class="stat-label">Courses</div><div class="stat-value"><?=countRows($conn,'course')?></div></div>
  <div class="stat"><div class="stat-label">Students</div><div class="stat-value"><?=countRows($conn,'student')?></div></div>
</div>
<div class="content-card">
 <div class="card-head"><span class="bar"></span><h2>Student Management System</h2></div>
 <div class="card-body">
   <p class="page-subtitle">Use the navigation menu to register students, manage academic records, define fee types and record payments.</p>
   <div class="notice">Database connected: <strong>miu_student_database</strong></div>
 </div>
</div>
<div class="footer">© 2025 Metropolitan International University | Student Management System</div>
<?php require "footer.php"; ?>
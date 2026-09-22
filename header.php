<?php
if (!isset($pageTitle)) {
    $pageTitle = "Dashboard";
}

$active = basename($_SERVER["PHP_SELF"]);

function navActive($file)
{
    global $active;
    return $active === $file ? "active" : "";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= h($pageTitle) ?> | MIU Database Forms</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="app">

  <header class="topbar">
    <div class="brand">
      <div class="logo">MIU</div>
      <div>
        <div class="brand-title">Metropolitan International University</div>
        <div class="brand-sub">MIU DATABASE FORMS</div>
      </div>
    </div>
    <div class="top-actions">
      <span class="top-icon">&#9906;</span>
      <span class="top-icon">&#9676;</span>
      <div class="user">
        <div class="avatar">AD</div>
        <span>Administrator</span>
      </div>
    </div>
  </header>

  <aside class="sidebar">
    <div class="nav-title">Main Menu</div>
    <nav class="nav">
      <a class="<?= navActive("index.php") ?>" href="index.php"><span class="ico">&#9638;</span>Dashboard</a>
      <a class="<?= navActive("department.php") ?>" href="department.php"><span class="ico">&#9636;</span>Department</a>
      <a class="<?= navActive("lecturer.php") ?>" href="lecturer.php"><span class="ico">&#9823;</span>Lecturer</a>
      <a class="<?= navActive("course.php") ?>" href="course.php"><span class="ico">&#9637;</span>Course</a>
      <a class="<?= navActive("student.php") ?>" href="student.php"><span class="ico">&#9823;</span>Student</a>
      <a class="<?= navActive("enrollment.php") ?>" href="enrollment.php"><span class="ico">&#10003;</span>Enrollment</a>
      <a class="<?= navActive("fee_type.php") ?>" href="fee_type.php"><span class="ico">&#9635;</span>Fee Type</a>
      <a class="<?= navActive("payment.php") ?>" href="payment.php"><span class="ico">&#164;</span>Payment</a>
    </nav>
  </aside>

  <main class="main">

<?php
require "db.php";
$stmt=$conn->prepare("INSERT INTO enrollment(student_id,course_id,enrollment_date,status) VALUES(?,?,?,?)");
$stmt->bind_param("iiss",$_POST['student_id'],$_POST['course_id'],$_POST['enrollment_date'],$_POST['status']);
$stmt->execute(); header("Location: enrollment.php?msg=".urlencode("Enrollment saved successfully.")); exit;
?>
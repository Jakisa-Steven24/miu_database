<?php
require "db.php";
$stmt=$conn->prepare("INSERT INTO course(course_code,course_title,credits,dept_id,lecturer_id) VALUES(?,?,?,?,?)");
$stmt->bind_param("ssiii",$_POST['course_code'],$_POST['course_title'],$_POST['credits'],$_POST['dept_id'],$_POST['lecturer_id']);
$stmt->execute(); header("Location: course.php?msg=".urlencode("Course registered successfully.")); exit;
?>
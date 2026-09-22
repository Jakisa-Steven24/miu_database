<?php
require "db.php";
$stmt=$conn->prepare("INSERT INTO lecturer(staff_no,first_name,last_name,email,phone,dept_id) VALUES(?,?,?,?,?,?)");
$stmt->bind_param("sssssi",$_POST['staff_no'],$_POST['first_name'],$_POST['last_name'],$_POST['email'],$_POST['phone'],$_POST['dept_id']);
$stmt->execute(); header("Location: lecturer.php?msg=".urlencode("Lecturer registered successfully.")); exit;
?>
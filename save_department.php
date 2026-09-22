<?php
require "db.php";
$stmt=$conn->prepare("INSERT INTO department(dept_code,dept_name,office_location,phone,head_of_dept,email) VALUES(?,?,?,?,?,?)");
$stmt->bind_param("ssssss",$_POST['dept_code'],$_POST['dept_name'],$_POST['office_location'],$_POST['phone'],$_POST['head_of_dept'],$_POST['email']);
$stmt->execute(); header("Location: department.php?msg=".urlencode("Department registered successfully.")); exit;
?>
<?php
require "db.php";
$stmt=$conn->prepare("INSERT INTO student(registration_number,first_name,last_name,gender,date_of_birth,email,address,course_id) VALUES(?,?,?,?,?,?,?,?)");
$stmt->bind_param("sssssssi",$_POST['registration_number'],$_POST['first_name'],$_POST['last_name'],$_POST['gender'],$_POST['date_of_birth'],$_POST['email'],$_POST['address'],$_POST['course_id']);
$stmt->execute(); header("Location: student.php?msg=".urlencode("Student registered successfully.")); exit;
?>
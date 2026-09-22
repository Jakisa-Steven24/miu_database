<?php
require "db.php";
$stmt=$conn->prepare("INSERT INTO payment(student_id,fee_type_id,amount,payment_description,payment_date,method,reference_no) VALUES(?,?,?,?,?,?,?)");
$stmt->bind_param("iidssss",$_POST['student_id'],$_POST['fee_type_id'],$_POST['amount'],$_POST['payment_description'],$_POST['payment_date'],$_POST['method'],$_POST['reference_no']);
$stmt->execute(); header("Location: payment.php?msg=".urlencode("Payment recorded successfully.")); exit;
?>
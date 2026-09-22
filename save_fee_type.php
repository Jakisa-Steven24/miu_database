<?php
require "db.php";
$stmt=$conn->prepare("INSERT INTO fee_type(fee_name,description) VALUES(?,?)");
$stmt->bind_param("ss",$_POST['fee_name'],$_POST['description']);
$stmt->execute(); header("Location: fee_type.php?msg=".urlencode("Fee type registered successfully.")); exit;
?>
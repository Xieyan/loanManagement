<?php
	require_once '../classes/membership.php';
	$mysql = new Mysql();

	$id = $_POST['id'];
	$status = $_POST['status'];

	$updatesql = "update sections set status='$status' where id='$id'";
	if(mysql_query($updatesql)){
		echo "<script>alert('Modify successflully. Please return to Manager Dashboard to check update.');window.location.href='manager.sectionstatus.php';</script>";
	}else{
		echo "<script>alert('Fail to modify. Please return to Manager Dashboard to check update.');window.location.href='manager.sectionstatus.php';</script>";
	}

?>
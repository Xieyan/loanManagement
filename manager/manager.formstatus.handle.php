<?php
	require_once '../classes/membership.php';
	$mysql = new Mysql();

	$formid = $_POST['formid'];
	$status = $_POST['status'];

	$updatesql = "update forms set status='$status' where id='$formid'";
	if(mysql_query($updatesql)){
		echo "<script>alert('Modify successful. Please return to manager dashboard to view update.');window.location.href='manager.formstatus.php';</script>";
	}else{
		echo "<script>alert('Fail to modify. Please return to manager dashboard to view update.');window.location.href='manager.formstatus.php';</script>";
	}

?>
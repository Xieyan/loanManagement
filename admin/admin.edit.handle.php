<?php
	require_once '../classes/membership.php';
	$mysql = new Mysql();

	$id = $_POST['id'];
	$username = $_POST['username'];
	$title = $_POST['title'];
	$company = $_POST['company'];
	$department = $_POST['department'];
	#$dateline =  time();

	$updatesql = "update users set username='$username',role='$title',company='$company',department='$department' where id='$id'";
	if(mysql_query($updatesql)){
		echo "<script>alert('Modify successflully. Please return to admin page to check your update info.');window.location.href='admin.edit.php';</script>";
	}else{
		echo "<script>alert('Fail to modify. Please return to admin page to check your update info.');window.location.href='admin.edit.php';</script>";
	}

?>
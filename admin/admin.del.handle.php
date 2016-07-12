<?php
	require_once '../classes/membership.php';
	$mysql = new Mysql();

	$id = $_GET['id'];
	$deletesql = "delete from users where id=$id";
	if(mysql_query($deletesql)){
		echo "<script>alert('Delete users successfully');window.location.href='admin.index.php';</script>";
	}else{
		echo "<script>alert('Fail to delete users');window.location.href='admin.index.php';</script>";
	}
	

?>
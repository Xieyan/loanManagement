<?php
	require_once '../classes/membership.php';
	$mysql = new Mysql();

	$comments = $_POST['comments'];
	$sectionid = $_POST['sectionid'];
	$viewerid = $_POST['viewerid'];
	echo $id;
	#update comments into viewers.
	$updatesql = "update viewers set comments='$comments' where sectionid='$sectionid' and viewerid = '$viewerid'";
	if(mysql_query($updatesql)){
		echo "<script>alert('Update viewers successfully');window.location.href='viewer.index.php';</script>";
	}else{
		echo "<script>alert('Fail to update viewers');window.location.href='viewer.index.php';</script>";
	}
?>
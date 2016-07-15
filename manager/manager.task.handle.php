<?php
	require_once '../classes/membership.php';
	$mysql = new Mysql();

	$viewername = $_POST['option'];
	$sectionid = $_POST['sectionid'];
	$company = $_POST['company'];
	$department = $_POST['department'];

	if( empty($viewername) ){
		echo "<script>alert('Please select a viewer to assign the task.');
		window.location.href='manager.viewfeedback.php?id=$sectionid&&company=$company&&department=$department';
		</script>";
	}

	if ($viewername){
	#find viewer id from users.
	$selectsql = "select id from users where username = '$viewername'";
	$query = mysql_query($selectsql);
	$row = mysql_fetch_assoc($query);
	$viewid = $row['id'];

	#insert a new viewer record into viewers database.
	$insertsql = "insert into viewers(viewerid, name, sectionid, comments, status) values('$viewid' , '$viewername' , '$sectionid', '','')";
	if(mysql_query($insertsql)){
		echo "<script>alert('Assign a new task successfully.');window.location.href='manager.viewfeedback.php?id=$sectionid&&company=$company&&department=$department';
		</script>";
	}else{
		echo "<script>alert('Fail to assign a task.');window.location.href='manager.viewfeedback.php?id=$sectionid&&company=$company&&department=$department';
		</script>";
	}
	}
?>
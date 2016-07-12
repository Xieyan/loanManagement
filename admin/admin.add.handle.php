<?php
	require_once '../classes/membership.php';
	$mysql = new Mysql();

	if(!(isset($_POST['username'])&&(!empty($_POST['username'])))){
		echo "<script>alert('Username cannot be empty. Please create an Username.');window.location.href='admin.index.php';</script>";
	}
	else if(!(isset($_POST['password'])&&(!empty($_POST['password'])))){
		echo "<script>alert('Password cannot be empty. Please create an Password.');window.location.href='admin.index.php';</script>";
	}
	else {
	$username = $_POST['username'];
	$password = $_POST['password'];
	$title = $_POST['optionTitle'];

	//$content = $_POST['content'];
	//$dateline =  time();

	//insert data into form users.
	$insertsql = "insert into users(username, password, role, company, department) values('$username', '$password', '$title','', '')";
	if(mysql_query($insertsql)){
		echo "<script>alert('Create a new member successfully.');window.location.href='admin.index.php';</script>";
	}else{
		echo "<script>alert('Fail to create a new member.');window.location.href='admin.index.php';</script>";
	}
	}

?>
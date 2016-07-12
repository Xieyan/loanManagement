<?php
	require_once '../classes/membership.php';
	$membership = new Membership();
	$membership->confirm_Member();
	echo $_SESSION['status'];
	echo "<br/>";
	echo $_SESSION['username'];
	echo "<br/>";
	echo $_SESSION['role'];
	echo "<br/>";
?>

<!DOCTYPE html>
<html>
	<body>
	<div>
		<h1> Welcome to the Viewer Page! </h1>
	</div>
	<a href="../login.php?status=loggedout"> Log Out </a>
	</body>
</html>
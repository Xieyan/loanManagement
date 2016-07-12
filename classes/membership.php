<?php

require 'Mysql.php';
class Membership{

	//validate username and password return a boolean.
	//link to different pages based on different user's role.
	function validata_user($un , $pwd){ 
		$mysql = new Mysql();
		$ensure_credentials = $mysql->verify_Username_and_Pass($un , $pwd);

		if ($ensure_credentials) {

			$sql = "select * from users where username = '$un' and password = '$pwd'";
			$query = mysql_query($sql);
			$row = mysql_fetch_row($query);
			$role = $row[3];
			//print_r($sql);

			$_SESSION['status'] = 'authorized';
			$_SESSION['username'] = $un;
			$_SESSION['role'] = $role;

			//link to different role index page.
			switch ($role){
			    case 'admin':
					header('location: admin/admin.index.php');
					break;
				case 'manager':
					header('location: manager/manager.index.php');
					break;
				default:
					header('location: viewer/viewer.index.php');
			}
			#header('location: index.php');
			#return "HELLO";
		} else 
		return "Please enter a correct username and password";
	}

	//handle when the user clicks the LogOut button. 
	function log_User_Out(){
		if (isset($_SESSION['status'])){
			unset($_SESSION['status']);
			unset($_SESSION['username']);
			unset($_SESSION['role']);

			if (isset($_COOKIE[session_name()])) setcookie(session_name(), '', time() - 1000);
			session_destroy();
		}
	}

	//refuse directly accessing with index.php without authroization.
	function confirm_Member(){
		session_start();
		if ($_SESSION['status'] != 'authorized') header("location: ../login.php");
	}

}
<?php

require_once 'constants.php';

class Mysql{
	private $conn;

	function __construct(){
		/*$this->conn = new Mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME) or 
					die('There was a problem connecting to the database.');
					*/
		
		//connect with db.
		if (!$this->conn = mysql_connect(DB_SERVER, DB_USER , DB_PASSWORD)) {
			echo mysql_error();
		}
		//select db name.
		mysql_select_db(DB_NAME);
		//set db character form.
		mysql_query('set names utf8');
	}

	//verify username and password.
	function verify_Username_and_Pass($un, $pwd){

		$query = "SELECT *
					FROM users
					WHERE username = '$un' AND password = '$pwd'
					LIMIT 1";

		$sql = mysql_query($query);
		if (mysql_fetch_row($sql)){
			return true;
		}		
	}
}
<?php 
session_start();
// error_reporting(0);

require "database.php";
require "setup.php";
require "functions/users.php";
require "functions/general.php";

if (logged_in() === true) {
	$session_user_id = $_SESSION['user_id'];
	$user_data = user_data($session_user_id,'id', 'user', 'password', 'email');
	
	// Deactivate/suspend a user's account!
	if (user_active($user_data['user']) === false) {
		session_destroy();
		header("Location: index.php?log_out=success");
		exit();
	}
}

$errors = array();
 ?>
<?php
include "config/init.php";
logged_in_redirect();
include "includes/overall/overall_header.php";

if (empty($_POST) === false) {
	$required_fields = array('user', 'password', 'password2', 'email');
	// echo "<pre>", print_r($_POST, true), "</pre>";
	foreach ($_POST as $key => $value) {
		if (empty($value) && in_array($key, $required_fields) === true) {
			$errors[] = "All fields are required!";
			break 1;
		}
	}

	if (empty($errors) === true) {
		if (user_exists($_POST['user']) === true) {
			$errors[] = "That username is taken!";
		}
		if (strlen($_POST['password']) < 6 || strlen($_POST['password']) > 30) {
			$errors[] = "Password must be between 6 and 30 characters long!";
		}
		if ($_POST['password2'] != $_POST['password']) {
			$errors[] = "The passwords don't match!";
		}
		if (preg_match("/\\s/", $_POST['user']) == true) {
			$errors[] = "Username must not contain any spaces!";
		}
		if (email_exists($_POST['email']) === true) {
			$errors[] = "sorry, that email address is already in use!";
		}
	}
}
if (isset($_GET['success'])) {
	echo "<h2>You have been successfully registered!</h2><br>
		  Please check your email to activate your account.";
} else {
	// Register the users and redirect and output errors if any
	if (empty($_POST) === false && empty($errors) === true) {
		// save user data in an array
		$register_data = array(
			'user' 			=> $_POST['user'],
			'password' 		=> $_POST['password'],
			'email' 		=> $_POST['email'],
			'email_code' 	=> md5($_POST['username'] + microtime())
		);

		// pass user data array for registration
		register_user($register_data);
		header("Location: register.php?success");
		exit();
	} elseif (empty($errors) === false) {
		// output errors in a user friendly way
	?>
		<h2>There was a registration error:</h2>
	<?php
		echo output_error($errors);
	}
}

include "includes/overall/overall_footer.php";
?>
<?php 
include "config/init.php";
protected_page();

if (empty($_POST) === false) {
	$required_fields = array('current_password', 'password', 'password_again');
	foreach ($_POST as $key => $value) {
		if (empty($value) && in_array($key, $required_fields) === true) {
			$errors[] = "All fields are required!";
			break 1;
		}
	}

	if (hash('whirlpool', $_POST['current_password']) === $user_data['password']) {
		if (trim($_POST['password']) !== trim($_POST['password_again'])) {
			$errors[] = "Your new passwords do not match!";
		} else if (strlen($_POST['password']) < 6 || strlen($_POST['password']) > 30) {
			$errors[] = "Password must be between 6 and 30 characters long!";
		}
	} else {
		$errors[] = "Your current password is incorrect!";
	}
}

include "includes/overall/overall_header.php";
?>

<h1>Change password</h1>

<?php
if (isset($_GET['success'])) {
	echo "Your password has been changed!";
} else {
	if (empty($_POST) === false && empty($errors) === true) {
		change_password($session_user_id, $_POST['password']);
		header("Location: changepassword.php?success");
	} elseif (empty($errors) === false) {
		echo output_error($errors);
	}
?>

	<form action="" method="post">
		<ul>
			<li>
				<input type="password" name="current_password" placeholder="Current password">
			</li>
			<li>
				<input type="password" name="password" placeholder="New password">
			</li>
			<li>
				<input type="password" name="password_again" placeholder="Re-enter new password">
			</li>
			<li>
				<input type="submit" value="Change password">
			</li>
		</ul>
	</form>

<?php
}
include "includes/overall/overall_footer.php"; 
?>
<?php 
include "config/init.php";
protected_page();
include "includes/overall/overall_header.php";

if (empty($_POST) === false) {
	$required_fields = array('user', 'email');
	foreach ($_POST as $key => $value) {
		if (empty($value) && in_array($key, $required_fields) === true) {
			$errors[] = "Both fields are required!";
			break 1;
		}
	}
}

if (empty($errors) === true) {
		if (user_exists($_POST['user']) === true) {
			$errors[] = "That username is taken!";
		}
		if (preg_match("/\\s/", $_POST['user']) == true) {
			$errors[] = "Username must not contain any spaces!";
		}
		if (email_exists($_POST['email']) === true && $user_data['email'] !== $_POST['email']) {
			$errors[] = "sorry, that email address is already in use!";
		}
	}

print_r($errors);

?>
<h2>Update info</h2>

<?php 

if (empty($_POST) === false && empty($errors) == true) {
	# Update the user info
} else if (empty($errors) == false) {
	echo output_error($errors);
}

 ?>

<form action="" method="post">
	<ul>
		<li>
			Username: <br>
			<input type="text" name="user" value="<?php echo $user_data['user']; ?>">
		</li>
		<li>
			Email:<br>
			<input type="email" name="email" value="<?php echo $user_data['email']; ?>">
		</li>
		<li>
			<input type="submit" name="Update">
		</li>
	</ul>
</form>

<?php
include "includes/overall/overall_footer.php"; 
?>
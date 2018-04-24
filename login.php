<?php 

include "config/init.php";
logged_in_redirect();
// if (user_exists('adil') === true) {
// 	echo "user exists";
// } else {
// 	echo "Error";
// }
// die();

if (empty($_POST) == false) {
	$username = $_POST['username'];
	$password = $_POST['password'];

	if (empty($username) || empty($password)) {
		$errors[] = "Please fill in both fields";
	} elseif (strlen($password) < 6) {
		$errors[] = "The password is too short!";
	} elseif (user_exists($username) === false) {
		$errors[] = "Username doesn't exist!";
	} elseif (user_active($username) === false) {
		$errors[] = "Please activate your account!";
	} else {
		$login = login($username, $password);
		if ($login === false) {
			$errors[] = "Username or Password is incorrect";
		} else {
			// set the user session and redirect
			$_SESSION['user_id'] = $login;
			header("Location: index.php");
			exit();
		}
	}
} else {
	$errors[] = "No data received!";
}
include "includes/overall/overall_header.php";

if (empty($errors) === false) {
?>
<h2>There was an error logging you in:</h2>
<?php
echo output_error($errors);
}

include "includes/overall/overall_footer.php";
 ?>

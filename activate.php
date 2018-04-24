<?php 
include "config/init.php";
logged_in_redirect();
include "includes/overall/overall_header.php";
if (isset($_GET['success'])) {
?>
	<h2>Your account has been successfully activated!</h2>
<?php
} elseif (isset($_GET['email'], $_GET['email_code']) === true) {
	$email = trim($_GET['email']);
	$email_code = trim($_GET['email_code']);

	if (email_exists($email) === false) {
		$errors[] = "Oops, something went wrong!";
	} elseif (activate($email, $email_code) === false) {
		$errors[] = "There was a problem activating your account!";
	}

	if (empty($errors) === false) {
	?>
		<h2>Oops... something went wrong</h2>
	<?php
		echo output_error($errors);
	} else {
		header("Location: activate.php?success");
		exit();
	}

} else {
	header("Location: index.php");
	exit();
}
 
include "includes/overall/overall_footer.php"; 
?>
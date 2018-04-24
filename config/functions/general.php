<?php 

// Sanitize to prevent any injections and validate inputs
// function sanitize ($data) {
// 	global $connect;
// 	return $connect->quote($data);
// 	return htmlspecialchars($data);
// }

// Array sanitize function for registration
// function array_sanitize (&$item) {
// 	// global $connect;
// 	// $item = $connect->quote($item);
// 	// $item = htmlspecialchars($item);
// }

// Send email(s)
function email ($to, $subject, $body) {
	mail($to, $subject, $body, 'From: noreply@camagru.com');
}

// Output the errors appended in a user friendly manner
function output_error ($errors) {
	$output = array();
	foreach ($errors as $error) {
		$output[] = '<li>' . $error . '</li>';
	}
	return '<ul>' . implode('', $output) . '</ul>';
}

// Block user access to unauthorised pages
function protected_page() {
	if (logged_in() === false) {
		header("Location: protected.php");
		exit();
	}
}

function logged_in_redirect () {
	if (logged_in() === true) {
		header("Location: index.php?access=denied");
		exit();
	}
}

?>
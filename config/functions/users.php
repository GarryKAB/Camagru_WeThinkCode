<?php

// Change user password
function change_password ($user_id, $password) {
	global $connect;
	$user_id = (int)$user_id;
	$password = hash('whirlpool', $password);

	$sql = "UPDATE `users` SET `password`=:pword WHERE `id`=:uid";
	$stmt = $connect->prepare($sql);
	$stmt->bindValue(':pword', $password);
	$stmt->bindValue(':uid', $user_id);
	$stmt->execute();
}

// user data function
function user_data ($user_id) {
	global $connect;
	$data = array();
	$user_id = (int)$user_id;

	$func_num_args = func_num_args();
	$func_get_args = func_get_args();

	if ($func_num_args > 1) {
		unset($func_get_args[0]);

		$fields = '`' . implode('`, `', $func_get_args) . '`';
		$sql = "SELECT $fields FROM users WHERE id=$user_id";
		$stmt = $connect->prepare($sql);
		$stmt->execute();
		$data = $stmt->fetch(PDO::FETCH_ASSOC);
		return $data;
	}
}

// Check if the user is logged in
function logged_in () {
	if (isset($_SESSION['user_id'])) {
		return true;
	} else {
		return false;
	}
}

// Check if the user exists
function user_exists($username){
	global $connect;
	// $username = sanitize($username);
	$sql = "SELECT * FROM users WHERE user=:username";
	$stmt = $connect->prepare($sql);
	$stmt->bindValue(':username', $username);
	$stmt->execute();
	$result = $stmt->fetch(PDO::FETCH_ASSOC);
	// print_r($result);
	if ($result == NULL) {
		return false;
	} else {
		return true;
	}
}

// Check if the email exists
function email_exists($email) {
	global $connect;
	// $email = sanitize($username);
	$sql = "SELECT * FROM users WHERE email=:email";
	$stmt = $connect->prepare($sql);
	$stmt->bindValue(':email', $email);
	$stmt->execute();
	$result = $stmt->fetch(PDO::FETCH_ASSOC);
	if ($result == NULL) {
		return false;
	} else {
		return true;
	}
}

// Check if the user's account is activated
function user_active($username){
	global $connect;
	// $username = sanitize($username);
	$sql = "SELECT * FROM users WHERE user=:username AND active = 1";
	$stmt = $connect->prepare($sql);
	$stmt->bindValue(':username', $username);
	$stmt->execute();
	$result = $stmt->fetch(PDO::FETCH_ASSOC);
	if (empty($result)) {
		return false;
	} else {
		return true;
	}

	/*
$sql = "SELECT COUNT(username) AS num FROM users WHERE username = :username";
if ($row['num'] > 0) {

	$result->rowCount() > 0
	*/
}

// fetch the user's id to log them in
// used in the following function
function user_id_from_username($username) {
	global $connect;
	// $username = sanitize($username);
	$sql = "SELECT id FROM users WHERE user=:username";
	$stmt = $connect->prepare($sql);
	$stmt->bindValue(':username', $username);
	return $stmt->execute();
	// $result = $stmt->fetch(PDO::FETCH_ASSOC);
	// if (isset($result)) {
	// 	return $result;
	// }
}

// log the user in if everything above is successful
function login($username, $password) {
	global $connect;
	$user_id = user_id_from_username($username);
	// $username = sanitize($username);
	// $password = hash('whirlpool', $password);
	// $password = md5($password);
	$password = hash('whirlpool', $password);

	$sql = "SELECT * FROM users WHERE user=:username AND password=:password";
	$stmt = $connect->prepare($sql);
	$stmt->bindValue(':username', $username);
	$stmt->bindValue(':password', $password);
	$stmt->execute();
	$result = $stmt->fetch(PDO::FETCH_ASSOC);

	if ($result != NULL) {
		return $user_id;
	} else {
		return false;
	}
}

// register the user into the database
function register_user ($register_data) {
	global $connect;
	// array_walk($register_data, 'array_sanitize');
	$register_data['password'] = hash('whirlpool', $register_data['password']);

	$fields = '`' . implode('`, `', array_keys($register_data)) . '`';
	$data = '\'' . implode('\', \'', $register_data) . '\'';
	
	$sql = "INSERT INTO `users` ($fields) VALUES($data)";
	$stmt = $connect->prepare($sql);
	$stmt->execute();

	email($register_data['email'], 'Activate your account',
		"Hello " . $register_data['user'] .
		",\n\nPlease copy the link below into your URL bar to activate your Camagru account:\n\n" .
		$_SERVER['HTTP_HOST']
		. "/PROJECTS/camagru/activate.php?email=" . $register_data['email'] . "&email_code=" . $register_data['email_code'] . "\n
		-Camagru Team
		");
}

// Account activation
function activate ($email, $email_code) {
	global $connect;
	$sql = "SELECT id FROM users WHERE email=:mail AND email_code=:mail_code AND active=0";
	$stmt = $connect->prepare($sql);
	$stmt->bindParam(':mail', $email);
	$stmt->bindParam(':mail_code', $email_code);
	$stmt->execute();
	$row = $stmt->fetch();
	$ID = $row['id'];
	if ($ID == null) {
		return false;
	} else {
		$sql = "UPDATE users SET active=1 WHERE email=:mail";
		$stmt = $connect->prepare($sql);
		$stmt->bindParam(':mail', $email);
		$stmt->execute();

		return true;
	}
}

?>



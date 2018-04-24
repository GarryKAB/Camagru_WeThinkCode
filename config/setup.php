<?php
include "database.php";

// Connect to the database
try {
	$connect = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
	echo "Connection failure: ".$e->getMessage();
}

// Create database
try {
	$sql = "CREATE DATABASE IF NOT EXISTS camagru";
	$connect->query($sql);
} catch (PDOException $e) {
	echo $sql."<br>".$e->getMessage();
}

// use camagru database
$connect->query("USE camagru;");

// create users table
try {
	$sql = "CREATE TABLE IF NOT EXISTS users(
		id INT PRIMARY KEY AUTO_INCREMENT,
		user VARCHAR(255) NOT NULL,
		password VARCHAR(128) NOT NULL,
		email VARCHAR(255) NOT NULL,
		email_code VARCHAR(32) NOT NULL,
		active INT(1) DEFAULT 0,
		created_at TIMESTAMP
	)";
	$connect->query($sql);
} catch (PDOException $e) {
	echo $sql."<br>".$e->getMessage();
}

// create pics table
try {
	$sql = "CREATE TABLE IF NOT EXISTS pics (
		id INT PRIMARY KEY AUTO_INCREMENT,
		pic MEDIUMTEXT NOT NULL,
		user VARCHAR(255) NOT NULL,
		created_at TIMESTAMP
	)";
	$connect->query($sql);
} catch (PDOException $e) {
	echo $sql."<br>".$e->getMessage();
}

// Create likes table
try {
	$sql = "CREATE TABLE IF NOT EXISTS likes (
		id INT PRIMARY KEY AUTO_INCREMENT,
		pic INT NOT NULL,
		user VARCHAR(255) NOT NULL
	)";
	$connect->query($sql);
} catch (PDOException $e) {
	echo $sql."<br>".$e->getMessage();
}

// create comments table
try {
	$sql = "CREATE TABLE IF NOT EXISTS comments (
		id INT PRIMARY KEY AUTO_INCREMENT,
		pic INT NOT NULL,
		comment TEXT NOT NULL,
		user VARCHAR(255) NOT NULL,
		created_at TIMESTAMP
	)";
	$connect->query($sql);
} catch (PDOException $e) {
	echo $sql."<br>".$e->getMessage();
}

 ?>
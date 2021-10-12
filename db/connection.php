<?php

// global exception handler
// function exceptionHandler($exception) {

// 	header("Location:/error.html");

// }

// set_exception_handler("exceptionHandler");

$dbhost = "localhost";
$dbport = 3306;
$dbname = "bookmart";
$username = "root";
$password = "";

$dsn = "mysql:host={$dbhost};port={$dbport};dbname={$dbname};";

$pdo = new PDO($dsn, $username, $password);
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

function exists(string $sql, array $args = []) {
	global $pdo;
	$stmt = $pdo->prepare($sql);
	$stmt->execute($args);
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	if (!$row) {
		return false;
	}
	return true;

}

function query(string $sql, array $args = []) {
	global $pdo;
	$stmt = $pdo->prepare($sql);
	return $stmt->execute($args);
}

function select(string $sql, array $args = []) {
	global $pdo;
	$stmt = $pdo->prepare($sql);
	$stmt->execute($args);
	return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function selectOne(string $sql, array $args = []) {
	global $pdo;
	$stmt = $pdo->prepare($sql);
	$stmt->execute($args);
	return $stmt->fetch(PDO::FETCH_ASSOC);
}

?>
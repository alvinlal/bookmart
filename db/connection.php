<?php

// global exception handler
function exceptionHandler($exception) {
	if (getenv("ENV") == "development") {
		echo $exception->getMessage() . "</br>";
		echo "on line " . $exception->getLine() . "</br>";
		echo "at file " . $exception->getFile();
		echo "</br></br> stack trace </br>";
		echo "<pre>" . $exception->getTraceAsString() . "</pre>";
		exit();
	} else {
		header("Location:/error.html");
		exit();
	}
}

set_exception_handler("exceptionHandler");

$dbhost = getenv("DB_HOST");
$dbport = getenv("DB_PORT");
$dbname = getenv("DB_NAME");
$username = getenv("DB_USERNAME");
$password = getenv("DB_PASSWORD");

$dsn = "mysql:host={$dbhost};port={$dbport};dbname={$dbname};";

$pdo = new PDO($dsn, $username, $password, array(
	PDO::MYSQL_ATTR_SSL_CA => getenv('CA_PATH'),
));

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
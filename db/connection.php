<?php

// TODO: add error checking
$dbhost = getenv("DB_HOST");
$dbport = getenv("DB_PORT");
$dbname = getenv("DB_NAME");
$username = getenv("DB_USERNAME");
$password = getenv("DB_PASSWORD");

$dsn = "mysql:host={$dbhost};port={$dbport};dbname={$dbname};";
$caPath = getenv("ENV") == "development" ? './config/amazon-rds-ca-cert.pem' : '/app/config/amazon-rds-ca-cert.pem';

$pdo = new PDO($dsn, $username, $password, array(
	PDO::MYSQL_ATTR_SSL_CA => $caPath,
));

// db functions
// TODO: add error checking

function exists(string $sql, array $args = []) {
	global $pdo;
	$stmt = $pdo->prepare($sql);
	$stmt->execute($args);
	$row = $stmt->fetch(\PDO::FETCH_ASSOC);
	if (!$row) {
		return false;
	}
	return true;
}

function insert(string $sql, array $args = []) {
	global $pdo;
	$stmt = $pdo->prepare($sql);
	return $stmt->execute($args);
}

function selectOne(string $sql, array $args = []) {
	global $pdo;
	$stmt = $pdo->prepare($sql);
	$stmt->execute($args);
	return $stmt->fetch(\PDO::FETCH_ASSOC);
}

?>
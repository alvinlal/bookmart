<?php

$dbhost = getenv("DB_HOST");
$dbport = getenv("DB_PORT");
$dbname = getenv("DB_NAME");
$username = getenv("DB_USERNAME");
$password = getenv("DB_PASSWORD");

$dsn = "mysql:host={$dbhost};port={$dbport};dbname={$dbname};";

$starttime = microtime();

$pdo = new PDO($dsn, $username, $password, array(
	PDO::MYSQL_ATTR_SSL_CA => '/config/amazon-rds-ca-cert.pem',
));

$stmt = $pdo->query('SHOW DATABASES;');

while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
	echo $row->Database . '<br>';
}

$endtime = microtime();

echo "query took " . $starttime - $endtime;

?>
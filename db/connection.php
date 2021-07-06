<?php

$dbhost = getenv("DB_HOST");
$dbport = getenv("DB_PORT");
$dbname = getenv("DB_NAME");
$username = getenv("DB_USERNAME");
$password = getenv("DB_PASSWORD");

$dsn = "mysql:host={$dbhost};port={$dbport};dbname={$dbname};";

$starttime = microtime();

$pdo = new PDO($dsn, $username, $password);

$stmt = $pdo->query('SHOW DATABASES;');

while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
	echo $row->Database . '<br>';
}

$endtime = microtime();

$finaltime = $endtime - $starttime;

echo "query took " . $finaltime;

?>
<?php

$dbInfo = getenv('DATABASE_URL');

// phpinfo();

$starttime = microtime();

$pdo = new PDO($dbInfo);

$stmt = $pdo->query('SHOW DATABASES;');

while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
	echo $row->Database . '<br>';
}

$endtime = microtime();

$finaltime = $endtime - $starttime;

echo "query took " . $finaltime;

?>
<?php
require '../vendor/autoload.php';

use Aws\S3\S3Client;

$s3 = new S3Client([
	'version' => 'latest',
	'region' => 'ap-south-1',
]);
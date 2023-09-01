<?php

use DynamicsWebApi\Helper;

require_once 'vendor/autoload.php';

$guid = $argv[1];
$filePath = $argv[2];

if (!file_exists($filePath)) {
	echo "File not found: $filePath\n";
	exit(1);
}

$base64Contents = base64_encode(file_get_contents($filePath));

$helper = new Helper();
$helper->updateEntity('webresourceset', $guid, [
	'content' => $base64Contents,
]);
$helper->publishAllChanges();
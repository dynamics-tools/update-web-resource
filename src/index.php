<?php

use DynamicsWebApi\Helper;

require_once 'vendor/autoload.php';

$webResourceData = $argv[1];

$seperatedWebResourceData = explode('|', $webResourceData);
$helper = new Helper();
foreach ($seperatedWebResourceData as $datum) {
	$seperatedDatum = explode(',', $datum);
	if (count($seperatedDatum) !== 2) {
		throw new Exception('Sorry, the web resource data is not in the correct format. It needs to be something like 0000-0000-0000-0000,path/to/file.js and we received' . $datum);
	}
	$guid = $seperatedDatum[0];
	$filePath = $seperatedDatum[1];
	if (!Helper::isValidGuid($guid)) {
		throw new Exception('Sorry, the guid is not in the correct format. It needs to be something like 0000-0000-0000-0000 and we received' . $guid);
	}
	if (!file_exists($filePath)) {
		throw new Exception('Sorry, the file does not exist. We received ' . $filePath);
	}
	$base64Contents = base64_encode(file_get_contents($filePath));
	$helper->updateEntity('webresourceset', $guid, [
		'content' => $base64Contents,
	]);
}
$helper->publishAllChanges();
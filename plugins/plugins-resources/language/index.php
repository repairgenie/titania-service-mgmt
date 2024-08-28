<?php
	// return a list of available languages as a json array
	include(__DIR__ . '/../loader.php');
	
	$plugin = new AppGiniPlugin();
	$plugin->reject_non_admin();

	$languages = [];
	$d = dir(__DIR__);
	while(false !== ($entry = $d->read())) {
		$m = [];
		if(!preg_match('/^([a-z]{2})\.js$/', $entry, $m)) continue;
		$languages[] = $m[1];
	}
	$d->close();

	@header('Content-type: application/json');
	echo json_encode($languages);
<?php
	// deletes a project file whose name is retrieved from the MD5 hash provided in Request
	require(__DIR__ . '/loader.php');
	
	$plugin = new AppGiniPlugin();
	$plugin->reject_non_admin();

	$axp_md5 = Request::val('axp');
	$project_file = '';
	$plugin->get_xml_file($axp_md5 , $project_file);
	$project_fullpath = __DIR__ . '/../projects/' . $project_file;
	@unlink($project_fullpath);

	// file not deleted? return 500 error
	if(@file_exists($project_fullpath)) {
		@header('X-Error-Message: ' . $plugin->translation['Couldn\'t delete this record'], true, 500);
		@header('X-FILENAME: ' . $project_fullpath);
		exit;
	}

	// file deleted ...
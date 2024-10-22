<?php
	
	/**
	 * Ajax-callable file to clean up all summary report tags of a given project
	 *
	 * @param   string  axp    MD5 hash of AXP file to modify
	 */

	include(__DIR__ . '/summary_reports.php');

	$summary_reports = new summary_reports([
		'title' => 'Summary Reports',
		'name' => 'summary_reports', 
		'logo' => 'summary_reports-logo-lg.png'
	]);
	
	$summary_reports->reject_non_admin('Access denied');

	$axp_md5 = Request::val('axp');

	$project_filename = '';
	$project = $summary_reports->get_xml_file($axp_md5, $project_filename);

	if(!$project_filename) die('File not found!');

	// make a backup copy of project file, up to 50 backups
	$projects_dir = __DIR__ . '/../projects';
	$copy_num = 1;
	while(@is_file("{$projects_dir}/{$copy_num}-{$project_filename}") && $copy_num < 50)
		$copy_num++;

	if(!@copy(
		"{$projects_dir}/{$project_filename}",
		"{$projects_dir}/{$copy_num}-{$project_filename}"
	)) die("Couldn't back up project file.");

	$tables = $project->table;
	$table_index = 0;
	foreach($tables as $table) {
		/* clear the node */
		$summary_reports->update_project_plugin_node([
			'projectName' => $project_filename,
			'tableIndex' => $table_index,
			'nodeName' => 'report_details',
			'pluginName' => 'summary_reports',
			'data' => ''
		]);
		$table_index++;
	}
<?php
	include(__DIR__ . '/summary_reports.php');

	$summary_reports = new summary_reports([
		'title' => 'Summary Reports',
		'name' => 'summary_reports', 
		'logo' => 'summary_reports-logo-lg.png' 
	]);

	/* grant access to the groups 'Admins' only */
	if (!$summary_reports->is_admin()) die('Access denied');

	/* Get URL parameters  */
	$table_name = Request::val('table_name');
	$axp_md5 = Request::val('axp');
	$projectFile = '';
	$xmlFile = $summary_reports->get_xml_file($axp_md5, $projectFile);
	$ancestor_tables = $summary_reports->get_ancestor_tables($table_name);
	echo json_encode($ancestor_tables);

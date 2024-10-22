<?php
	
	/**
	 * Ajax-callable file to delete a summary report
	 *
	 * @param   string  axp    MD5 hash of AXP file to modify
	 * @param   string  table_name   Name of the table containing the report to delete
	 * @param   string  node_index   Numeric index OR hash of report to delete
	 *
	 * @return  string  updated reports of the given table, JSON-encoded string
	 */

	include(__DIR__ . '/summary_reports.php');

	$summary_reports = new summary_reports([
		'title' => 'Summary Reports',
		'name' => 'summary_reports', 
		'logo' => 'summary_reports-logo-lg.png' 
	]);
	
	$summary_reports->reject_non_admin('Access denied');

	$axp_md5 = makeSafe(Request::val('axp'));
	$table_name = Request::val('table_name');
	$node_index = Request::val('node_index');
	$project_filename = '';

	$xmlFile = $summary_reports->get_xml_file($axp_md5, $project_filename);
	$tables = $xmlFile->table;
	
	$table_index = -1;
	$table_reports_string = null;
	foreach($tables as $table) {
		$table_index++;
		if($table->name != $table_name) continue;

		$table_reports_string = $table->plugins->summary_reports->report_details;
		break;
	}
	 
	$table_reports_array = json_decode($table_reports_string, true);
	
	// node_index could be numeric array index or report hash
	$array_index = $node_index;
	if(!isset($table_reports_array[$array_index])) {
		// node_index is report hash ... find index
		foreach($table_reports_array as $index => $report) {
			if($report['report_hash'] != $node_index) continue;
			
			$array_index = $index;
			break;
		}
	}
	unset($table_reports_array[$array_index]);

	$table_reports_string = json_encode(array_values($table_reports_array)); 

	/* update the node */
	$nodeData = [
		'projectName' => $project_filename,
		'tableIndex' => $table_index,
		'nodeName' => 'report_details',
		'pluginName' => 'summary_reports',
		'data' => $table_reports_string
	];
	 
	$summary_reports->update_project_plugin_node($nodeData);
	echo $table_reports_string;
	 
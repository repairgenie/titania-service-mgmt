<?php
// This script and data application were generated by AppGini 22.14
// Download AppGini for free from https://bigprof.com/appgini/download/

	include_once(__DIR__ . '/lib.php');
	@include_once(__DIR__ . '/hooks/call_logs.php');
	include_once(__DIR__ . '/call_logs_dml.php');

	// mm: can the current member access this page?
	$perm = getTablePermissions('call_logs');
	if(!$perm['access']) {
		echo error_message($Translation['tableAccessDenied']);
		exit;
	}

	$x = new DataList;
	$x->TableName = 'call_logs';

	// Fields that can be displayed in the table view
	$x->QueryFieldsTV = [
		"`call_logs`.`call_ID`" => "call_ID",
		"`call_logs`.`call_datetime`" => "call_datetime",
		"`call_logs`.`call_loggedby`" => "call_loggedby",
		"IF(    CHAR_LENGTH(`clients1`.`id`) || CHAR_LENGTH(`clients1`.`name`), CONCAT_WS('',   `clients1`.`id`, ' : ', `clients1`.`name`), '') /* Client */" => "call_client",
		"IF(    CHAR_LENGTH(`workorders1`.`wo_ID`) || CHAR_LENGTH(`workorders1`.`wo_Title`), CONCAT_WS('',   `workorders1`.`wo_ID`, ' : ', `workorders1`.`wo_Title`), '') /* Related Work Order */" => "call_workorder",
		"IF(    CHAR_LENGTH(`assets1`.`asset_ID`) || CHAR_LENGTH(`assets1`.`asset_serial`), CONCAT_WS('',   `assets1`.`asset_ID`, ' : ', `assets1`.`asset_serial`), '') /* Related Asset */" => "call_asset",
		"IF(    CHAR_LENGTH(`ca1`.`id`) || CHAR_LENGTH(if(`ca1`.`date_due`,date_format(`ca1`.`date_due`,'%d/%m/%Y'),'')), CONCAT_WS('',   `ca1`.`id`, ' : ', if(`ca1`.`date_due`,date_format(`ca1`.`date_due`,'%d/%m/%Y'),'')), '') /* Related Invoice */" => "call_invoice",
		"`call_logs`.`call_logentry`" => "call_logentry",
	];
	// mapping incoming sort by requests to actual query fields
	$x->SortFields = [
		1 => '`call_logs`.`call_ID`',
		2 => 2,
		3 => 3,
		4 => 4,
		5 => 5,
		6 => 6,
		7 => 7,
		8 => 8,
	];

	// Fields that can be displayed in the csv file
	$x->QueryFieldsCSV = [
		"`call_logs`.`call_ID`" => "call_ID",
		"`call_logs`.`call_datetime`" => "call_datetime",
		"`call_logs`.`call_loggedby`" => "call_loggedby",
		"IF(    CHAR_LENGTH(`clients1`.`id`) || CHAR_LENGTH(`clients1`.`name`), CONCAT_WS('',   `clients1`.`id`, ' : ', `clients1`.`name`), '') /* Client */" => "call_client",
		"IF(    CHAR_LENGTH(`workorders1`.`wo_ID`) || CHAR_LENGTH(`workorders1`.`wo_Title`), CONCAT_WS('',   `workorders1`.`wo_ID`, ' : ', `workorders1`.`wo_Title`), '') /* Related Work Order */" => "call_workorder",
		"IF(    CHAR_LENGTH(`assets1`.`asset_ID`) || CHAR_LENGTH(`assets1`.`asset_serial`), CONCAT_WS('',   `assets1`.`asset_ID`, ' : ', `assets1`.`asset_serial`), '') /* Related Asset */" => "call_asset",
		"IF(    CHAR_LENGTH(`ca1`.`id`) || CHAR_LENGTH(if(`ca1`.`date_due`,date_format(`ca1`.`date_due`,'%d/%m/%Y'),'')), CONCAT_WS('',   `ca1`.`id`, ' : ', if(`ca1`.`date_due`,date_format(`ca1`.`date_due`,'%d/%m/%Y'),'')), '') /* Related Invoice */" => "call_invoice",
		"`call_logs`.`call_logentry`" => "call_logentry",
	];
	// Fields that can be filtered
	$x->QueryFieldsFilters = [
		"`call_logs`.`call_ID`" => "Call ID",
		"`call_logs`.`call_datetime`" => "Date/Time Logged:",
		"`call_logs`.`call_loggedby`" => "Logged By:",
		"IF(    CHAR_LENGTH(`clients1`.`id`) || CHAR_LENGTH(`clients1`.`name`), CONCAT_WS('',   `clients1`.`id`, ' : ', `clients1`.`name`), '') /* Client */" => "Client",
		"IF(    CHAR_LENGTH(`workorders1`.`wo_ID`) || CHAR_LENGTH(`workorders1`.`wo_Title`), CONCAT_WS('',   `workorders1`.`wo_ID`, ' : ', `workorders1`.`wo_Title`), '') /* Related Work Order */" => "Related Work Order",
		"IF(    CHAR_LENGTH(`assets1`.`asset_ID`) || CHAR_LENGTH(`assets1`.`asset_serial`), CONCAT_WS('',   `assets1`.`asset_ID`, ' : ', `assets1`.`asset_serial`), '') /* Related Asset */" => "Related Asset",
		"IF(    CHAR_LENGTH(`ca1`.`id`) || CHAR_LENGTH(if(`ca1`.`date_due`,date_format(`ca1`.`date_due`,'%d/%m/%Y'),'')), CONCAT_WS('',   `ca1`.`id`, ' : ', if(`ca1`.`date_due`,date_format(`ca1`.`date_due`,'%d/%m/%Y'),'')), '') /* Related Invoice */" => "Related Invoice",
		"`call_logs`.`call_logentry`" => "Log Entry",
	];

	// Fields that can be quick searched
	$x->QueryFieldsQS = [
		"`call_logs`.`call_ID`" => "call_ID",
		"`call_logs`.`call_datetime`" => "call_datetime",
		"`call_logs`.`call_loggedby`" => "call_loggedby",
		"IF(    CHAR_LENGTH(`clients1`.`id`) || CHAR_LENGTH(`clients1`.`name`), CONCAT_WS('',   `clients1`.`id`, ' : ', `clients1`.`name`), '') /* Client */" => "call_client",
		"IF(    CHAR_LENGTH(`workorders1`.`wo_ID`) || CHAR_LENGTH(`workorders1`.`wo_Title`), CONCAT_WS('',   `workorders1`.`wo_ID`, ' : ', `workorders1`.`wo_Title`), '') /* Related Work Order */" => "call_workorder",
		"IF(    CHAR_LENGTH(`assets1`.`asset_ID`) || CHAR_LENGTH(`assets1`.`asset_serial`), CONCAT_WS('',   `assets1`.`asset_ID`, ' : ', `assets1`.`asset_serial`), '') /* Related Asset */" => "call_asset",
		"IF(    CHAR_LENGTH(`ca1`.`id`) || CHAR_LENGTH(if(`ca1`.`date_due`,date_format(`ca1`.`date_due`,'%d/%m/%Y'),'')), CONCAT_WS('',   `ca1`.`id`, ' : ', if(`ca1`.`date_due`,date_format(`ca1`.`date_due`,'%d/%m/%Y'),'')), '') /* Related Invoice */" => "call_invoice",
		"`call_logs`.`call_logentry`" => "call_logentry",
	];

	// Lookup fields that can be used as filterers
	$x->filterers = ['call_client' => 'Client', 'call_workorder' => 'Related Work Order', 'call_asset' => 'Related Asset', 'call_invoice' => 'Related Invoice', ];

	$x->QueryFrom = "`call_logs` LEFT JOIN `clients` as clients1 ON `clients1`.`id`=`call_logs`.`call_client` LEFT JOIN `workorders` as workorders1 ON `workorders1`.`wo_ID`=`call_logs`.`call_workorder` LEFT JOIN `assets` as assets1 ON `assets1`.`asset_ID`=`call_logs`.`call_asset` LEFT JOIN `ca` as ca1 ON `ca1`.`id`=`call_logs`.`call_invoice` ";
	$x->QueryWhere = '';
	$x->QueryOrder = '';

	$x->AllowSelection = 1;
	$x->HideTableView = ($perm['view'] == 0 ? 1 : 0);
	$x->AllowDelete = $perm['delete'];
	$x->AllowMassDelete = (getLoggedAdmin() !== false);
	$x->AllowInsert = $perm['insert'];
	$x->AllowUpdate = $perm['edit'];
	$x->SeparateDV = 1;
	$x->AllowDeleteOfParents = 0;
	$x->AllowFilters = 1;
	$x->AllowSavingFilters = (getLoggedAdmin() !== false);
	$x->AllowSorting = 1;
	$x->AllowNavigation = 1;
	$x->AllowPrinting = 1;
	$x->AllowPrintingDV = 1;
	$x->AllowCSV = 1;
	$x->RecordsPerPage = 100;
	$x->QuickSearch = 1;
	$x->QuickSearchText = $Translation['quick search'];
	$x->ScriptFileName = 'call_logs_view.php';
	$x->TableTitle = 'Call Logs';
	$x->TableIcon = 'table.gif';
	$x->PrimaryKey = '`call_logs`.`call_ID`';

	$x->ColWidth = [150, 150, 150, 150, 150, 150, 150, 150, ];
	$x->ColCaption = ['Call ID', 'Date/Time Logged:', 'Logged By:', 'Client', 'Related Work Order', 'Related Asset', 'Related Invoice', 'Log Entry', ];
	$x->ColFieldName = ['call_ID', 'call_datetime', 'call_loggedby', 'call_client', 'call_workorder', 'call_asset', 'call_invoice', 'call_logentry', ];
	$x->ColNumber  = [1, 2, 3, 4, 5, 6, 7, 8, ];

	// template paths below are based on the app main directory
	$x->Template = 'templates/call_logs_templateTV.html';
	$x->SelectedTemplate = 'templates/call_logs_templateTVS.html';
	$x->TemplateDV = 'templates/call_logs_templateDV.html';
	$x->TemplateDVP = 'templates/call_logs_templateDVP.html';

	$x->ShowTableHeader = 1;
	$x->TVClasses = "";
	$x->DVClasses = "";
	$x->HasCalculatedFields = false;
	$x->AllowConsoleLog = false;
	$x->AllowDVNavigation = true;

	// hook: call_logs_init
	$render = true;
	if(function_exists('call_logs_init')) {
		$args = [];
		$render = call_logs_init($x, getMemberInfo(), $args);
	}

	if($render) $x->Render();

	// hook: call_logs_header
	$headerCode = '';
	if(function_exists('call_logs_header')) {
		$args = [];
		$headerCode = call_logs_header($x->ContentType, getMemberInfo(), $args);
	}

	if(!$headerCode) {
		include_once(__DIR__ . '/header.php'); 
	} else {
		ob_start();
		include_once(__DIR__ . '/header.php');
		echo str_replace('<%%HEADER%%>', ob_get_clean(), $headerCode);
	}

	echo $x->HTML;

	// hook: call_logs_footer
	$footerCode = '';
	if(function_exists('call_logs_footer')) {
		$args = [];
		$footerCode = call_logs_footer($x->ContentType, getMemberInfo(), $args);
	}

	if(!$footerCode) {
		include_once(__DIR__ . '/footer.php'); 
	} else {
		ob_start();
		include_once(__DIR__ . '/footer.php');
		echo str_replace('<%%FOOTER%%>', ob_get_clean(), $footerCode);
	}

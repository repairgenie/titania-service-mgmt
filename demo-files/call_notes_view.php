<?php
// This script and data application were generated by AppGini 22.14
// Download AppGini for free from https://bigprof.com/appgini/download/

	include_once(__DIR__ . '/lib.php');
	@include_once(__DIR__ . '/hooks/call_notes.php');
	include_once(__DIR__ . '/call_notes_dml.php');

	// mm: can the current member access this page?
	$perm = getTablePermissions('call_notes');
	if(!$perm['access']) {
		echo error_message($Translation['tableAccessDenied']);
		exit;
	}

	$x = new DataList;
	$x->TableName = 'call_notes';

	// Fields that can be displayed in the table view
	$x->QueryFieldsTV = [
		"IF(    CHAR_LENGTH(`call_logs1`.`call_ID`) || CHAR_LENGTH(`call_logs1`.`call_datetime`), CONCAT_WS('',   `call_logs1`.`call_ID`, ' : ', `call_logs1`.`call_datetime`), '') /* Related Call:  */" => "callnote_call",
		"`call_notes`.`callnote_ID`" => "callnote_ID",
		"`call_notes`.`callnote_datetime`" => "callnote_datetime",
		"`call_notes`.`callnote_loggedby`" => "callnote_loggedby",
		"`call_notes`.`callnote_note`" => "callnote_note",
	];
	// mapping incoming sort by requests to actual query fields
	$x->SortFields = [
		1 => 1,
		2 => '`call_notes`.`callnote_ID`',
		3 => 3,
		4 => 4,
		5 => 5,
	];

	// Fields that can be displayed in the csv file
	$x->QueryFieldsCSV = [
		"IF(    CHAR_LENGTH(`call_logs1`.`call_ID`) || CHAR_LENGTH(`call_logs1`.`call_datetime`), CONCAT_WS('',   `call_logs1`.`call_ID`, ' : ', `call_logs1`.`call_datetime`), '') /* Related Call:  */" => "callnote_call",
		"`call_notes`.`callnote_ID`" => "callnote_ID",
		"`call_notes`.`callnote_datetime`" => "callnote_datetime",
		"`call_notes`.`callnote_loggedby`" => "callnote_loggedby",
		"`call_notes`.`callnote_note`" => "callnote_note",
	];
	// Fields that can be filtered
	$x->QueryFieldsFilters = [
		"IF(    CHAR_LENGTH(`call_logs1`.`call_ID`) || CHAR_LENGTH(`call_logs1`.`call_datetime`), CONCAT_WS('',   `call_logs1`.`call_ID`, ' : ', `call_logs1`.`call_datetime`), '') /* Related Call:  */" => "Related Call: ",
		"`call_notes`.`callnote_ID`" => "Note ID",
		"`call_notes`.`callnote_datetime`" => "Note Logged: ",
		"`call_notes`.`callnote_loggedby`" => "Logged By:",
		"`call_notes`.`callnote_note`" => "Call Notes",
	];

	// Fields that can be quick searched
	$x->QueryFieldsQS = [
		"IF(    CHAR_LENGTH(`call_logs1`.`call_ID`) || CHAR_LENGTH(`call_logs1`.`call_datetime`), CONCAT_WS('',   `call_logs1`.`call_ID`, ' : ', `call_logs1`.`call_datetime`), '') /* Related Call:  */" => "callnote_call",
		"`call_notes`.`callnote_ID`" => "callnote_ID",
		"`call_notes`.`callnote_datetime`" => "callnote_datetime",
		"`call_notes`.`callnote_loggedby`" => "callnote_loggedby",
		"`call_notes`.`callnote_note`" => "callnote_note",
	];

	// Lookup fields that can be used as filterers
	$x->filterers = ['callnote_call' => 'Related Call: ', ];

	$x->QueryFrom = "`call_notes` LEFT JOIN `call_logs` as call_logs1 ON `call_logs1`.`call_ID`=`call_notes`.`callnote_call` ";
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
	$x->ScriptFileName = 'call_notes_view.php';
	$x->TableTitle = 'Call Notes';
	$x->TableIcon = 'table.gif';
	$x->PrimaryKey = '`call_notes`.`callnote_ID`';

	$x->ColWidth = [150, 150, 150, 150, 150, ];
	$x->ColCaption = ['Related Call: ', 'Note ID', 'Note Logged: ', 'Logged By:', 'Call Notes', ];
	$x->ColFieldName = ['callnote_call', 'callnote_ID', 'callnote_datetime', 'callnote_loggedby', 'callnote_note', ];
	$x->ColNumber  = [1, 2, 3, 4, 5, ];

	// template paths below are based on the app main directory
	$x->Template = 'templates/call_notes_templateTV.html';
	$x->SelectedTemplate = 'templates/call_notes_templateTVS.html';
	$x->TemplateDV = 'templates/call_notes_templateDV.html';
	$x->TemplateDVP = 'templates/call_notes_templateDVP.html';

	$x->ShowTableHeader = 1;
	$x->TVClasses = "";
	$x->DVClasses = "";
	$x->HasCalculatedFields = false;
	$x->AllowConsoleLog = false;
	$x->AllowDVNavigation = true;

	// hook: call_notes_init
	$render = true;
	if(function_exists('call_notes_init')) {
		$args = [];
		$render = call_notes_init($x, getMemberInfo(), $args);
	}

	if($render) $x->Render();

	// hook: call_notes_header
	$headerCode = '';
	if(function_exists('call_notes_header')) {
		$args = [];
		$headerCode = call_notes_header($x->ContentType, getMemberInfo(), $args);
	}

	if(!$headerCode) {
		include_once(__DIR__ . '/header.php'); 
	} else {
		ob_start();
		include_once(__DIR__ . '/header.php');
		echo str_replace('<%%HEADER%%>', ob_get_clean(), $headerCode);
	}

	echo $x->HTML;

	// hook: call_notes_footer
	$footerCode = '';
	if(function_exists('call_notes_footer')) {
		$args = [];
		$footerCode = call_notes_footer($x->ContentType, getMemberInfo(), $args);
	}

	if(!$footerCode) {
		include_once(__DIR__ . '/footer.php'); 
	} else {
		ob_start();
		include_once(__DIR__ . '/footer.php');
		echo str_replace('<%%FOOTER%%>', ob_get_clean(), $footerCode);
	}

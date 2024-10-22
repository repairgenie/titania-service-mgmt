<?php
	define('PREPEND_PATH', '');
	include_once(__DIR__ . '/lib.php');

	// accept a record as an assoc array, return transformed row ready to insert to table
	$transformFunctions = [
		'invoice' => function($data, $options = []) {
			if(isset($data['date_due'])) $data['date_due'] = guessMySQLDateTime($data['date_due']);
			if(isset($data['client'])) $data['client'] = pkGivenLookupText($data['client'], 'invoice', 'client');
			if(isset($data['client_comments'])) $data['client_comments'] = preg_replace('/[^\d\.]/', '', $data['client_comments']);
			if(isset($data['tax'])) $data['tax'] = preg_replace('/[^\d\.]/', '', $data['tax']);
			if(isset($data['client_contact'])) $data['client_contact'] = thisOr($data['client'], pkGivenLookupText($data['client_contact'], 'invoice', 'client_contact'));
			if(isset($data['client_address'])) $data['client_address'] = thisOr($data['client'], pkGivenLookupText($data['client_address'], 'invoice', 'client_address'));
			if(isset($data['client_phone'])) $data['client_phone'] = thisOr($data['client'], pkGivenLookupText($data['client_phone'], 'invoice', 'client_phone'));
			if(isset($data['client_email'])) $data['client_email'] = thisOr($data['client'], pkGivenLookupText($data['client_email'], 'invoice', 'client_email'));
			if(isset($data['client_website'])) $data['client_website'] = thisOr($data['client'], pkGivenLookupText($data['client_website'], 'invoice', 'client_website'));
			if(isset($data['client_comments'])) $data['client_comments'] = thisOr($data['client'], pkGivenLookupText($data['client_comments'], 'invoice', 'client_comments'));

			return $data;
		},
		'clients' => function($data, $options = []) {
			if(isset($data['phone'])) $data['phone'] = str_replace('-', '', $data['phone']);

			return $data;
		},
		'item_prices' => function($data, $options = []) {
			if(isset($data['item'])) $data['item'] = pkGivenLookupText($data['item'], 'item_prices', 'item');
			if(isset($data['date'])) $data['date'] = guessMySQLDateTime($data['date']);

			return $data;
		},
		'invoice_items' => function($data, $options = []) {
			if(isset($data['invoice'])) $data['invoice'] = pkGivenLookupText($data['invoice'], 'invoice_items', 'invoice');
			if(isset($data['item'])) $data['item'] = pkGivenLookupText($data['item'], 'invoice_items', 'item');
			if(isset($data['unit_price'])) $data['unit_price'] = preg_replace('/[^\d\.]/', '', $data['unit_price']);
			if(isset($data['qty'])) $data['qty'] = preg_replace('/[^\d\.]/', '', $data['qty']);
			if(isset($data['current_price'])) $data['current_price'] = thisOr($data['item'], pkGivenLookupText($data['current_price'], 'invoice_items', 'current_price'));

			return $data;
		},
		'items' => function($data, $options = []) {

			return $data;
		},
		'workorders' => function($data, $options = []) {
			if(isset($data['wo_assignedto'])) $data['wo_assignedto'] = pkGivenLookupText($data['wo_assignedto'], 'workorders', 'wo_assignedto');
			if(isset($data['wo_client'])) $data['wo_client'] = pkGivenLookupText($data['wo_client'], 'workorders', 'wo_client');
			if(isset($data['wo_asset'])) $data['wo_asset'] = pkGivenLookupText($data['wo_asset'], 'workorders', 'wo_asset');

			return $data;
		},
		'techs' => function($data, $options = []) {

			return $data;
		},
		'assets' => function($data, $options = []) {
			if(isset($data['asset_client'])) $data['asset_client'] = pkGivenLookupText($data['asset_client'], 'assets', 'asset_client');

			return $data;
		},
		'workordernotes' => function($data, $options = []) {
			if(isset($data['wonote_wo'])) $data['wonote_wo'] = pkGivenLookupText($data['wonote_wo'], 'workordernotes', 'wonote_wo');

			return $data;
		},
		'technotes' => function($data, $options = []) {
			if(isset($data['technote_tech'])) $data['technote_tech'] = pkGivenLookupText($data['technote_tech'], 'technotes', 'technote_tech');

			return $data;
		},
		'tblwopubstatus' => function($data, $options = []) {
			if(isset($data['wopub_WO'])) $data['wopub_WO'] = pkGivenLookupText($data['wopub_WO'], 'tblwopubstatus', 'wopub_WO');

			return $data;
		},
		'asset_notes' => function($data, $options = []) {
			if(isset($data['assetnote_asset'])) $data['assetnote_asset'] = pkGivenLookupText($data['assetnote_asset'], 'asset_notes', 'assetnote_asset');

			return $data;
		},
		'call_logs' => function($data, $options = []) {
			if(isset($data['call_client'])) $data['call_client'] = pkGivenLookupText($data['call_client'], 'call_logs', 'call_client');
			if(isset($data['call_workorder'])) $data['call_workorder'] = pkGivenLookupText($data['call_workorder'], 'call_logs', 'call_workorder');
			if(isset($data['call_asset'])) $data['call_asset'] = pkGivenLookupText($data['call_asset'], 'call_logs', 'call_asset');
			if(isset($data['call_invoice'])) $data['call_invoice'] = pkGivenLookupText($data['call_invoice'], 'call_logs', 'call_invoice');

			return $data;
		},
		'call_notes' => function($data, $options = []) {
			if(isset($data['callnote_call'])) $data['callnote_call'] = pkGivenLookupText($data['callnote_call'], 'call_notes', 'callnote_call');

			return $data;
		},
	];

	// accept a record as an assoc array, return a boolean indicating whether to import or skip record
	$filterFunctions = [
		'invoice' => function($data, $options = []) { return true; },
		'clients' => function($data, $options = []) { return true; },
		'item_prices' => function($data, $options = []) { return true; },
		'invoice_items' => function($data, $options = []) { return true; },
		'items' => function($data, $options = []) { return true; },
		'workorders' => function($data, $options = []) { return true; },
		'techs' => function($data, $options = []) { return true; },
		'assets' => function($data, $options = []) { return true; },
		'workordernotes' => function($data, $options = []) { return true; },
		'technotes' => function($data, $options = []) { return true; },
		'tblwopubstatus' => function($data, $options = []) { return true; },
		'asset_notes' => function($data, $options = []) { return true; },
		'call_logs' => function($data, $options = []) { return true; },
		'call_notes' => function($data, $options = []) { return true; },
	];

	/*
	Hook file for overwriting/amending $transformFunctions and $filterFunctions:
	hooks/import-csv.php
	If found, it's included below

	The way this works is by either completely overwriting any of the above 2 arrays,
	or, more commonly, overwriting a single function, for example:
		$transformFunctions['tablename'] = function($data, $options = []) {
			// new definition here
			// then you must return transformed data
			return $data;
		};

	Another scenario is transforming a specific field and leaving other fields to the default
	transformation. One possible way of doing this is to store the original transformation function
	in GLOBALS array, calling it inside the custom transformation function, then modifying the
	specific field:
		$GLOBALS['originalTransformationFunction'] = $transformFunctions['tablename'];
		$transformFunctions['tablename'] = function($data, $options = []) {
			$data = call_user_func_array($GLOBALS['originalTransformationFunction'], [$data, $options]);
			$data['fieldname'] = 'transformed value';
			return $data;
		};
	*/

	@include(__DIR__ . '/hooks/import-csv.php');

	$ui = new CSVImportUI($transformFunctions, $filterFunctions);

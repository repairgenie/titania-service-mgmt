<?php
// This script and data application were generated by AppGini 22.14
// Download AppGini for free from https://bigprof.com/appgini/download/

/*
	ajax-callable script that returns code for either a combo drop-down or an auto-complete
	drop-down, based on number of items.

	REQUEST parameters:
	===============
	t: table name
	f: lookup field name
	id: selected id
	p: page number (default = 1)
	s: search term
	o: 0 (default) for text-only or 1 for full options list, applicable only for radio lookups
	text: selected text
	filterer_[filterer]: name of filterer field to be used to filter the drop-down contents
				must be one of the filteres defined for the concerned field
	ut: 0 (default) returns all results, 1 returns unique texts (useful only if we don't care about ids, only text)
	json: 0 (default) returns HTML output for radio lookups, 1 forces json results for all including radio lookups
*/

	$start_ts = microtime(true);

	// how many results to return per call, in case of json output
	$results_per_page = 50;

	include_once(__DIR__ . '/lib.php');

	handle_maintenance();

	// drop-downs config
	$lookups = [
		'invoice' => [
			'client' => [
				'parent_table' => 'clients',
				'parent_pk_field' => 'id',
				'parent_caption' => '`clients`.`name`',
				'parent_from' => '`clients` ',
				'filterers' => [],
				'custom_query' => '',
				'inherit_permissions' => true,
				'list_type' => 0,
				'not_null' => false,
			],
			'client_contact' => [
				'parent_table' => 'clients',
				'parent_pk_field' => 'id',
				'parent_caption' => '`clients`.`contact`',
				'parent_from' => '`clients` ',
				'filterers' => [],
				'custom_query' => '',
				'inherit_permissions' => false,
				'list_type' => 0,
				'not_null' => false,
			],
			'client_address' => [
				'parent_table' => 'clients',
				'parent_pk_field' => 'id',
				'parent_caption' => '`clients`.`address`',
				'parent_from' => '`clients` ',
				'filterers' => [],
				'custom_query' => '',
				'inherit_permissions' => false,
				'list_type' => 0,
				'not_null' => false,
			],
			'client_phone' => [
				'parent_table' => 'clients',
				'parent_pk_field' => 'id',
				'parent_caption' => '`clients`.`phone`',
				'parent_from' => '`clients` ',
				'filterers' => [],
				'custom_query' => '',
				'inherit_permissions' => false,
				'list_type' => 0,
				'not_null' => false,
			],
			'client_email' => [
				'parent_table' => 'clients',
				'parent_pk_field' => 'id',
				'parent_caption' => '`clients`.`email`',
				'parent_from' => '`clients` ',
				'filterers' => [],
				'custom_query' => '',
				'inherit_permissions' => false,
				'list_type' => 0,
				'not_null' => false,
			],
			'client_website' => [
				'parent_table' => 'clients',
				'parent_pk_field' => 'id',
				'parent_caption' => '`clients`.`website`',
				'parent_from' => '`clients` ',
				'filterers' => [],
				'custom_query' => '',
				'inherit_permissions' => false,
				'list_type' => 0,
				'not_null' => false,
			],
			'client_comments' => [
				'parent_table' => 'clients',
				'parent_pk_field' => 'id',
				'parent_caption' => '`clients`.`comments`',
				'parent_from' => '`clients` ',
				'filterers' => [],
				'custom_query' => '',
				'inherit_permissions' => false,
				'list_type' => 0,
				'not_null' => false,
			],
		],
		'clients' => [
		],
		'item_prices' => [
			'item' => [
				'parent_table' => 'items',
				'parent_pk_field' => 'id',
				'parent_caption' => '`items`.`item_description`',
				'parent_from' => '`items` ',
				'filterers' => [],
				'custom_query' => '',
				'inherit_permissions' => true,
				'list_type' => 0,
				'not_null' => false,
			],
		],
		'invoice_items' => [
			'invoice' => [
				'parent_table' => 'invoice',
				'parent_pk_field' => 'id',
				'parent_caption' => '`invoice`.`code`',
				'parent_from' => '`invoice` LEFT JOIN `clients` as clients1 ON `clients1`.`id`=`invoice`.`client` ',
				'filterers' => [],
				'custom_query' => '',
				'inherit_permissions' => true,
				'list_type' => 0,
				'not_null' => false,
			],
			'item' => [
				'parent_table' => 'items',
				'parent_pk_field' => 'id',
				'parent_caption' => '`items`.`item_description`',
				'parent_from' => '`items` ',
				'filterers' => [],
				'custom_query' => '',
				'inherit_permissions' => true,
				'list_type' => 0,
				'not_null' => false,
			],
			'current_price' => [
				'parent_table' => 'items',
				'parent_pk_field' => 'id',
				'parent_caption' => '`items`.`unit_price`',
				'parent_from' => '`items` ',
				'filterers' => [],
				'custom_query' => '',
				'inherit_permissions' => false,
				'list_type' => 0,
				'not_null' => false,
			],
		],
		'items' => [
		],
		'workorders' => [
			'wo_assignedto' => [
				'parent_table' => 'techs',
				'parent_pk_field' => 'techID',
				'parent_caption' => 'IF(CHAR_LENGTH(`techs`.`techID`) || CHAR_LENGTH(`techs`.`techName`), CONCAT_WS(\'\', `techs`.`techID`, \' - \', `techs`.`techName`), \'\')',
				'parent_from' => '`techs` ',
				'filterers' => [],
				'custom_query' => '',
				'inherit_permissions' => false,
				'list_type' => 0,
				'not_null' => false,
			],
			'wo_client' => [
				'parent_table' => 'clients',
				'parent_pk_field' => 'id',
				'parent_caption' => 'IF(CHAR_LENGTH(`clients`.`id`) || CHAR_LENGTH(`clients`.`name`), CONCAT_WS(\'\', `clients`.`id`, \' - \', `clients`.`name`), \'\')',
				'parent_from' => '`clients` ',
				'filterers' => [],
				'custom_query' => '',
				'inherit_permissions' => true,
				'list_type' => 0,
				'not_null' => true,
			],
			'wo_asset' => [
				'parent_table' => 'assets',
				'parent_pk_field' => 'asset_ID',
				'parent_caption' => 'IF(CHAR_LENGTH(`assets`.`asset_client`) || CHAR_LENGTH(`assets`.`asset_serial`), CONCAT_WS(\'\', IF(    CHAR_LENGTH(`clients1`.`id`) || CHAR_LENGTH(`clients1`.`name`), CONCAT_WS(\'\',   `clients1`.`id`, \' - \', `clients1`.`name`), \'\'), \' - \', `assets`.`asset_serial`), \'\')',
				'parent_from' => '`assets` LEFT JOIN `clients` as clients1 ON `clients1`.`id`=`assets`.`asset_client` ',
				'filterers' => [],
				'custom_query' => '',
				'inherit_permissions' => false,
				'list_type' => 0,
				'not_null' => false,
			],
		],
		'techs' => [
		],
		'assets' => [
			'asset_client' => [
				'parent_table' => 'clients',
				'parent_pk_field' => 'id',
				'parent_caption' => 'IF(CHAR_LENGTH(`clients`.`id`) || CHAR_LENGTH(`clients`.`name`), CONCAT_WS(\'\', `clients`.`id`, \' - \', `clients`.`name`), \'\')',
				'parent_from' => '`clients` ',
				'filterers' => [],
				'custom_query' => '',
				'inherit_permissions' => true,
				'list_type' => 0,
				'not_null' => false,
			],
		],
		'workordernotes' => [
			'wonote_wo' => [
				'parent_table' => 'workorders',
				'parent_pk_field' => 'wo_ID',
				'parent_caption' => 'IF(CHAR_LENGTH(`workorders`.`wo_ID`) || CHAR_LENGTH(`workorders`.`wo_Title`), CONCAT_WS(\'\', `workorders`.`wo_ID`, \' - \', `workorders`.`wo_Title`), \'\')',
				'parent_from' => '`workorders` LEFT JOIN `techs` as techs1 ON `techs1`.`techID`=`workorders`.`wo_assignedto` LEFT JOIN `clients` as clients1 ON `clients1`.`id`=`workorders`.`wo_client` LEFT JOIN `assets` as assets1 ON `assets1`.`asset_ID`=`workorders`.`wo_asset` LEFT JOIN `clients` as clients2 ON `clients2`.`id`=`assets1`.`asset_client` ',
				'filterers' => [],
				'custom_query' => '',
				'inherit_permissions' => true,
				'list_type' => 0,
				'not_null' => true,
			],
		],
		'technotes' => [
			'technote_tech' => [
				'parent_table' => 'techs',
				'parent_pk_field' => 'techID',
				'parent_caption' => 'IF(CHAR_LENGTH(`techs`.`techID`) || CHAR_LENGTH(`techs`.`techName`), CONCAT_WS(\'\', `techs`.`techID`, \' - \', `techs`.`techName`), \'\')',
				'parent_from' => '`techs` ',
				'filterers' => [],
				'custom_query' => '',
				'inherit_permissions' => true,
				'list_type' => 0,
				'not_null' => true,
			],
		],
		'tblwopubstatus' => [
			'wopub_WO' => [
				'parent_table' => 'workorders',
				'parent_pk_field' => 'wo_ID',
				'parent_caption' => 'IF(CHAR_LENGTH(`workorders`.`wo_ID`) || CHAR_LENGTH(`workorders`.`wo_Title`), CONCAT_WS(\'\', `workorders`.`wo_ID`, \' - \', `workorders`.`wo_Title`), \'\')',
				'parent_from' => '`workorders` LEFT JOIN `techs` as techs1 ON `techs1`.`techID`=`workorders`.`wo_assignedto` LEFT JOIN `clients` as clients1 ON `clients1`.`id`=`workorders`.`wo_client` LEFT JOIN `assets` as assets1 ON `assets1`.`asset_ID`=`workorders`.`wo_asset` LEFT JOIN `clients` as clients2 ON `clients2`.`id`=`assets1`.`asset_client` ',
				'filterers' => [],
				'custom_query' => '',
				'inherit_permissions' => true,
				'list_type' => 0,
				'not_null' => false,
			],
		],
		'asset_notes' => [
			'assetnote_asset' => [
				'parent_table' => 'assets',
				'parent_pk_field' => 'asset_ID',
				'parent_caption' => 'IF(CHAR_LENGTH(`assets`.`asset_ID`) || CHAR_LENGTH(`assets`.`asset_client`), CONCAT_WS(\'\', `assets`.`asset_ID`, \' - \', IF(    CHAR_LENGTH(`clients1`.`id`) || CHAR_LENGTH(`clients1`.`name`), CONCAT_WS(\'\',   `clients1`.`id`, \' - \', `clients1`.`name`), \'\')), \'\')',
				'parent_from' => '`assets` LEFT JOIN `clients` as clients1 ON `clients1`.`id`=`assets`.`asset_client` ',
				'filterers' => [],
				'custom_query' => '',
				'inherit_permissions' => true,
				'list_type' => 0,
				'not_null' => true,
			],
		],
		'call_logs' => [
			'call_client' => [
				'parent_table' => 'clients',
				'parent_pk_field' => 'id',
				'parent_caption' => 'IF(CHAR_LENGTH(`clients`.`id`) || CHAR_LENGTH(`clients`.`name`), CONCAT_WS(\'\', `clients`.`id`, \' : \', `clients`.`name`), \'\')',
				'parent_from' => '`clients` ',
				'filterers' => [],
				'custom_query' => '',
				'inherit_permissions' => true,
				'list_type' => 0,
				'not_null' => false,
			],
			'call_workorder' => [
				'parent_table' => 'workorders',
				'parent_pk_field' => 'wo_ID',
				'parent_caption' => 'IF(CHAR_LENGTH(`workorders`.`wo_ID`) || CHAR_LENGTH(`workorders`.`wo_Title`), CONCAT_WS(\'\', `workorders`.`wo_ID`, \' : \', `workorders`.`wo_Title`), \'\')',
				'parent_from' => '`workorders` LEFT JOIN `techs` as techs1 ON `techs1`.`techID`=`workorders`.`wo_assignedto` LEFT JOIN `clients` as clients1 ON `clients1`.`id`=`workorders`.`wo_client` LEFT JOIN `assets` as assets1 ON `assets1`.`asset_ID`=`workorders`.`wo_asset` LEFT JOIN `clients` as clients2 ON `clients2`.`id`=`assets1`.`asset_client` ',
				'filterers' => [],
				'custom_query' => '',
				'inherit_permissions' => true,
				'list_type' => 0,
				'not_null' => false,
			],
			'call_asset' => [
				'parent_table' => 'assets',
				'parent_pk_field' => 'asset_ID',
				'parent_caption' => 'IF(CHAR_LENGTH(`assets`.`asset_ID`) || CHAR_LENGTH(`assets`.`asset_serial`), CONCAT_WS(\'\', `assets`.`asset_ID`, \' : \', `assets`.`asset_serial`), \'\')',
				'parent_from' => '`assets` LEFT JOIN `clients` as clients1 ON `clients1`.`id`=`assets`.`asset_client` ',
				'filterers' => ['call_client' => 'asset_client'],
				'custom_query' => '',
				'inherit_permissions' => true,
				'list_type' => 0,
				'not_null' => false,
			],
			'call_invoice' => [
				'parent_table' => 'invoice',
				'parent_pk_field' => 'id',
				'parent_caption' => 'IF(CHAR_LENGTH(`invoice`.`id`) || CHAR_LENGTH(if(`invoice`.`date_due`,date_format(`invoice`.`date_due`,\'%d/%m/%Y\'),\'\')), CONCAT_WS(\'\', `invoice`.`id`, \' : \', if(`invoice`.`date_due`,date_format(`invoice`.`date_due`,\'%d/%m/%Y\'),\'\')), \'\')',
				'parent_from' => '`invoice` LEFT JOIN `clients` as clients1 ON `clients1`.`id`=`invoice`.`client` ',
				'filterers' => [],
				'custom_query' => '',
				'inherit_permissions' => false,
				'list_type' => 0,
				'not_null' => false,
			],
		],
		'call_notes' => [
			'callnote_call' => [
				'parent_table' => 'call_logs',
				'parent_pk_field' => 'call_ID',
				'parent_caption' => 'IF(CHAR_LENGTH(`call_logs`.`call_ID`) || CHAR_LENGTH(`call_logs`.`call_datetime`), CONCAT_WS(\'\', `call_logs`.`call_ID`, \' : \', `call_logs`.`call_datetime`), \'\')',
				'parent_from' => '`call_logs` LEFT JOIN `clients` as clients1 ON `clients1`.`id`=`call_logs`.`call_client` LEFT JOIN `workorders` as workorders1 ON `workorders1`.`wo_ID`=`call_logs`.`call_workorder` LEFT JOIN `assets` as assets1 ON `assets1`.`asset_ID`=`call_logs`.`call_asset` LEFT JOIN `invoice` as invoice1 ON `invoice1`.`id`=`call_logs`.`call_invoice` ',
				'filterers' => [],
				'custom_query' => '',
				'inherit_permissions' => true,
				'list_type' => 0,
				'not_null' => false,
			],
		],
	];

	// XSS prevention
	$xss = new CI_Input(datalist_db_encoding);

	// receive and verify user input
	$table_name = Request::val('t');
	$field_name = Request::val('f');
	$search_id = makeSafe(from_utf8(Request::val('id')));
	$selected_text = from_utf8(Request::val('text'));
	$returnOptions = (Request::val('o') == 1 ? true : false);
	$page = intval(Request::val('p'));
	if($page < 1)  $page = 1;
	$skip = $results_per_page * ($page - 1);
	$search_term = makeSafe(from_utf8(Request::val('s')));
	$uniqueText = Request::val('ut') ? true : false;
	$forceJson = Request::val('json') ? true : false;

	$res = null;

	if(!isset($lookups[$table_name][$field_name])) die('{ "error": "Invalid table or field." }');

	// can user access the requested table?
	$perm = getTablePermissions($table_name);
	if(!$perm['access'] && !$search_id) die('{ "error": "' . addslashes($Translation['tableAccessDenied']) . '" }');

	$field = $lookups[$table_name][$field_name];

	$wheres = [];

	// search term provided?
	if($search_term) {
		$wheres[] = "{$field['parent_caption']} like '%{$search_term}%'";
	}

	// any filterers specified?
	if(is_array($field['filterers'])) {
		foreach($field['filterers'] as $filterer => $filterer_parent) {
			if($get = Request::val("filterer_{$filterer}", false))
				$wheres[] = "`{$field['parent_table']}`.`$filterer_parent`='" . makeSafe($get) . "'";
		}
	}

	// inherit permissions?
	if($field['inherit_permissions']) {
		$inherit = permissions_sql($field['parent_table']);
		if($inherit === false && !$search_id) die($Translation['tableAccessDenied']);

		if($inherit['where']) $wheres[] = $inherit['where'];
		if($inherit['from']) $field['parent_from'] .= ", {$inherit['from']}";
	}

	// single value?
	if($field['list_type'] != 2 && $search_id) {
		$wheres[] = "`{$field['parent_table']}`.`{$field['parent_pk_field']}`='{$search_id}'";
	}

	$where = '';
	if(count($wheres)) {
		$where = 'WHERE ' . implode(' AND ', $wheres);
	}

	// define the combo and return the code
	$combo = new DataCombo;
	if($field['custom_query']) {
		$qm = []; $custom_where = ''; $custom_order_by = '2';
		$combo->Query = $field['custom_query'];

		if(preg_match('/ order by (.*)$/i', $combo->Query, $qm)) {
			$custom_order_by = $qm[1];
			$combo->Query = preg_replace('/ order by .*$/i', '', $combo->Query);
		}

		if(preg_match('/ where (.*)$/i', $combo->Query, $qm)) {
			$custom_where = $qm[1];
			$combo->Query = preg_replace('/ where .*$/i', '', $combo->Query);
		}

		if($where && $custom_where) {
			$combo->Query .=  " {$where} AND ({$custom_where}) ORDER BY {$custom_order_by}";
		} elseif($custom_where) {
			$combo->Query .=  " WHERE {$custom_where} ORDER BY {$custom_order_by}";
		} else {
			$combo->Query .=  " {$where} ORDER BY {$custom_order_by}";
		}

		$query_match = [];
		preg_match('/select (.*) from (.*)$/i', $combo->Query, $query_match);

		if(isset($query_match[2])) {
			$count_query = "SELECT count(1) FROM {$query_match[2]}";
		} else {
			$count_query = '';
		}
	} else {
		$combo->Query = "SELECT " . ($field['inherit_permissions'] ? 'DISTINCT ' : '') . "`{$field['parent_table']}`.`{$field['parent_pk_field']}`, {$field['parent_caption']} FROM {$field['parent_from']} {$where} ORDER BY 2";
		$count_query = "SELECT count(1) FROM {$field['parent_from']} {$where}";
	}
	$combo->table = $table_name;
	$combo->parent_table = $field['parent_table'];
	$combo->SelectName = $field_name;
	$combo->ListType = $field['list_type'];
	if($search_id) {
		$combo->SelectedData = $search_id;
	} elseif($selected_text) {
		$combo->SelectedData = getValueGivenCaption($combo->Query, $selected_text);
	}

	if($field['list_type'] == 2 && !$forceJson) {
		$combo->Render();
		$combo->HTML = str_replace('<select ', '<select onchange="' . $field_name . '_changed();" ', $combo->HTML);

		// return response
		if($returnOptions) {
			?><span id="<?php echo $field_name; ?>-combo-list"><?php echo $combo->HTML; ?></span><?php
		} else {
			?>
				<span class="match-text" id="<?php echo $field_name; ?>-match-text"><?php echo $combo->MatchText; ?></span>
				<input type="hidden" id="<?php echo $field_name; ?>" value="<?php echo html_attr($combo->SelectedData); ?>">
			<?php
		}
	} else {
		/* return json */
		header('Content-type: application/json');

		/* if unique text (ut=1), we don't care about IDs and can group by text */
		if($uniqueText && !preg_match('/\bgroup by\b/i', $combo->Query)) {
			// do we have an order by?
			if(preg_match('/\border by\b/i', $combo->Query))
				$combo->Query = preg_replace('/\b(order by)\b/i', ' GROUP BY 2 $1', $combo->Query);
			else
				$combo->Query .= ' GROUP BY 2 ';
		}

		if(!preg_match('/ limit .+/i', $combo->Query)) {
			if(!$search_id) $combo->Query .= " LIMIT {$skip}, {$results_per_page}";
			if($search_id) $combo->Query .= " LIMIT 1";
		}

		$prepared_data = [];

		// specific caption provided and list_type is not radio?
		if(!$search_id && $selected_text) {
			$search_id = getValueGivenCaption($combo->Query, $selected_text);
			if($search_id) $prepared_data[] = ['id' => to_utf8($search_id), 'text' => to_utf8($xss->xss_clean($selected_text))];
		} else {
			/*
			 * in case we have a search term, show matches starting with it first,
			 * followed by those containing it.
			 * build a UNION query for that purpose
			 */
			if($search_term) {
				$query2 = $combo->Query;
				$query1 = str_replace(" like '%{$search_term}%'", " like '{$search_term}%'", $query2);
				$combo->Query = "({$query1}) UNION ({$query2})";
			}

			$eo = ['silentErrors' => true];

			$res = sql($combo->Query, $eo);
			while($row = db_fetch_row($res)) {
				if(empty($prepared_data) && $page == 1 && !$search_id && !$field['not_null']) {
					$prepared_data[] = ['id' => empty_lookup_value, 'text' => to_utf8("<{$Translation['none']}>")];
				}

				$prepared_data[] = ['id' => to_utf8($row[0]), 'text' => to_utf8($xss->xss_clean($row[1]))];
			}
		}

		if(empty($prepared_data)) { $prepared_data[] = ['id' => '', 'text' => to_utf8($Translation['No matches found!'])]; }

		echo json_encode([
			'results' => $prepared_data,
			'more' => (@db_num_rows($res) >= $results_per_page),
			'elapsed' => round(microtime(true) - $start_ts, 3),
		]);
	}


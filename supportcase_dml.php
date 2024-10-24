<?php

// Data functions (insert, update, delete, form) for table supportcase

// This script and data application were generated by AppGini 22.14
// Download AppGini for free from https://bigprof.com/appgini/download/

function supportcase_insert(&$error_message = '') {
	global $Translation;

	// mm: can member insert record?
	$arrPerm = getTablePermissions('supportcase');
	if(!$arrPerm['insert']) return false;

	$data = [
		'case_number' => parseCode('<%%creationTimestamp%%>', true),
		'case_status' => Request::val('case_status', ''),
		'case_client' => Request::lookup('case_client', ''),
		'case_call' => Request::lookup('case_call', ''),
		'case_datetime' => parseCode('<%%creationDateTime%%>', true),
		'case_openedby' => parseCode('<%%creatorUsername%%>', true),
		'case_external' => Request::val('case_external', ''),
		'case_subject' => Request::val('case_subject', ''),
		'case_description' => Request::val('case_description', ''),
	];


	// hook: supportcase_before_insert
	if(function_exists('supportcase_before_insert')) {
		$args = [];
		if(!supportcase_before_insert($data, getMemberInfo(), $args)) {
			if(isset($args['error_message'])) $error_message = $args['error_message'];
			return false;
		}
	}

	$error = '';
	// set empty fields to NULL
	$data = array_map(function($v) { return ($v === '' ? NULL : $v); }, $data);
	insert('supportcase', backtick_keys_once($data), $error);
	if($error) {
		$error_message = $error;
		return false;
	}

	$recID = db_insert_id(db_link());

	update_calc_fields('supportcase', $recID, calculated_fields()['supportcase']);

	// hook: supportcase_after_insert
	if(function_exists('supportcase_after_insert')) {
		$res = sql("SELECT * FROM `supportcase` WHERE `case_ID`='" . makeSafe($recID, false) . "' LIMIT 1", $eo);
		if($row = db_fetch_assoc($res)) {
			$data = array_map('makeSafe', $row);
		}
		$data['selectedID'] = makeSafe($recID, false);
		$args = [];
		if(!supportcase_after_insert($data, getMemberInfo(), $args)) { return $recID; }
	}

	// mm: save ownership data
	set_record_owner('supportcase', $recID, getLoggedMemberID());

	// if this record is a copy of another record, copy children if applicable
	if(strlen(Request::val('SelectedID'))) supportcase_copy_children($recID, Request::val('SelectedID'));

	return $recID;
}

function supportcase_copy_children($destination_id, $source_id) {
	global $Translation;
	$requests = []; // array of curl handlers for launching insert requests
	$eo = ['silentErrors' => true];
	$safe_sid = makeSafe($source_id);

	// launch requests, asynchronously
	curl_batch($requests);
}

function supportcase_delete($selected_id, $AllowDeleteOfParents = false, $skipChecks = false) {
	// insure referential integrity ...
	global $Translation;
	$selected_id = makeSafe($selected_id);

	// mm: can member delete record?
	if(!check_record_permission('supportcase', $selected_id, 'delete')) {
		return $Translation['You don\'t have enough permissions to delete this record'];
	}

	// hook: supportcase_before_delete
	if(function_exists('supportcase_before_delete')) {
		$args = [];
		if(!supportcase_before_delete($selected_id, $skipChecks, getMemberInfo(), $args))
			return $Translation['Couldn\'t delete this record'] . (
				!empty($args['error_message']) ?
					'<div class="text-bold">' . strip_tags($args['error_message']) . '</div>'
					: '' 
			);
	}

	// child table: supportcase_notes
	$res = sql("SELECT `case_ID` FROM `supportcase` WHERE `case_ID`='{$selected_id}'", $eo);
	$case_ID = db_fetch_row($res);
	$rires = sql("SELECT COUNT(1) FROM `supportcase_notes` WHERE `sc_notecase`='" . makeSafe($case_ID[0]) . "'", $eo);
	$rirow = db_fetch_row($rires);
	if($rirow[0] && !$AllowDeleteOfParents && !$skipChecks) {
		$RetMsg = $Translation["couldn't delete"];
		$RetMsg = str_replace('<RelatedRecords>', $rirow[0], $RetMsg);
		$RetMsg = str_replace('<TableName>', 'supportcase_notes', $RetMsg);
		return $RetMsg;
	} elseif($rirow[0] && $AllowDeleteOfParents && !$skipChecks) {
		$RetMsg = $Translation['confirm delete'];
		$RetMsg = str_replace('<RelatedRecords>', $rirow[0], $RetMsg);
		$RetMsg = str_replace('<TableName>', 'supportcase_notes', $RetMsg);
		$RetMsg = str_replace('<Delete>', '<input type="button" class="btn btn-danger" value="' . html_attr($Translation['yes']) . '" onClick="window.location = \'supportcase_view.php?SelectedID=' . urlencode($selected_id) . '&delete_x=1&confirmed=1&csrf_token=' . urlencode(csrf_token(false, true)) . '\';">', $RetMsg);
		$RetMsg = str_replace('<Cancel>', '<input type="button" class="btn btn-success" value="' . html_attr($Translation[ 'no']) . '" onClick="window.location = \'supportcase_view.php?SelectedID=' . urlencode($selected_id) . '\';">', $RetMsg);
		return $RetMsg;
	}

	sql("DELETE FROM `supportcase` WHERE `case_ID`='{$selected_id}'", $eo);

	// hook: supportcase_after_delete
	if(function_exists('supportcase_after_delete')) {
		$args = [];
		supportcase_after_delete($selected_id, getMemberInfo(), $args);
	}

	// mm: delete ownership data
	sql("DELETE FROM `membership_userrecords` WHERE `tableName`='supportcase' AND `pkValue`='{$selected_id}'", $eo);
}

function supportcase_update(&$selected_id, &$error_message = '') {
	global $Translation;

	// mm: can member edit record?
	if(!check_record_permission('supportcase', $selected_id, 'edit')) return false;

	$data = [
		'case_status' => Request::val('case_status', ''),
		'case_client' => Request::lookup('case_client', ''),
		'case_call' => Request::lookup('case_call', ''),
		'case_external' => Request::val('case_external', ''),
		'case_subject' => Request::val('case_subject', ''),
		'case_description' => Request::val('case_description', ''),
	];

	// get existing values
	$old_data = getRecord('supportcase', $selected_id);
	if(is_array($old_data)) {
		$old_data = array_map('makeSafe', $old_data);
		$old_data['selectedID'] = makeSafe($selected_id);
	}

	$data['selectedID'] = makeSafe($selected_id);

	// hook: supportcase_before_update
	if(function_exists('supportcase_before_update')) {
		$args = ['old_data' => $old_data];
		if(!supportcase_before_update($data, getMemberInfo(), $args)) {
			if(isset($args['error_message'])) $error_message = $args['error_message'];
			return false;
		}
	}

	$set = $data; unset($set['selectedID']);
	foreach ($set as $field => $value) {
		$set[$field] = ($value !== '' && $value !== NULL) ? $value : NULL;
	}

	if(!update(
		'supportcase', 
		backtick_keys_once($set), 
		['`case_ID`' => $selected_id], 
		$error_message
	)) {
		echo $error_message;
		echo '<a href="supportcase_view.php?SelectedID=' . urlencode($selected_id) . "\">{$Translation['< back']}</a>";
		exit;
	}


	$eo = ['silentErrors' => true];

	update_calc_fields('supportcase', $data['selectedID'], calculated_fields()['supportcase']);

	// hook: supportcase_after_update
	if(function_exists('supportcase_after_update')) {
		$res = sql("SELECT * FROM `supportcase` WHERE `case_ID`='{$data['selectedID']}' LIMIT 1", $eo);
		if($row = db_fetch_assoc($res)) $data = array_map('makeSafe', $row);

		$data['selectedID'] = $data['case_ID'];
		$args = ['old_data' => $old_data];
		if(!supportcase_after_update($data, getMemberInfo(), $args)) return;
	}

	// mm: update ownership data
	sql("UPDATE `membership_userrecords` SET `dateUpdated`='" . time() . "' WHERE `tableName`='supportcase' AND `pkValue`='" . makeSafe($selected_id) . "'", $eo);
}

function supportcase_form($selected_id = '', $AllowUpdate = 1, $AllowInsert = 1, $AllowDelete = 1, $separateDV = 0, $TemplateDV = '', $TemplateDVP = '') {
	// function to return an editable form for a table records
	// and fill it with data of record whose ID is $selected_id. If $selected_id
	// is empty, an empty form is shown, with only an 'Add New'
	// button displayed.

	global $Translation;
	$eo = ['silentErrors' => true];
	$noUploads = null;
	$row = $urow = $jsReadOnly = $jsEditable = $lookups = null;

	$noSaveAsCopy = false;

	// mm: get table permissions
	$arrPerm = getTablePermissions('supportcase');
	if(!$arrPerm['insert'] && $selected_id == '')
		// no insert permission and no record selected
		// so show access denied error unless TVDV
		return $separateDV ? $Translation['tableAccessDenied'] : '';
	$AllowInsert = ($arrPerm['insert'] ? true : false);
	// print preview?
	$dvprint = false;
	if(strlen($selected_id) && Request::val('dvprint_x') != '') {
		$dvprint = true;
	}

	$filterer_case_client = Request::val('filterer_case_client');
	$filterer_case_call = Request::val('filterer_case_call');

	// populate filterers, starting from children to grand-parents
	if($filterer_case_call && !$filterer_case_client) $filterer_case_client = sqlValue("select call_client from call_logs where call_ID='" . makeSafe($filterer_case_call) . "'");

	// unique random identifier
	$rnd1 = ($dvprint ? rand(1000000, 9999999) : '');
	// combobox: case_status
	$combo_case_status = new Combo;
	$combo_case_status->ListType = 0;
	$combo_case_status->MultipleSeparator = ', ';
	$combo_case_status->ListBoxHeight = 10;
	$combo_case_status->RadiosPerLine = 1;
	if(is_file(__DIR__ . '/hooks/supportcase.case_status.csv')) {
		$case_status_data = addslashes(implode('', @file(__DIR__ . '/hooks/supportcase.case_status.csv')));
		$combo_case_status->ListItem = array_trim(explode('||', entitiesToUTF8(convertLegacyOptions($case_status_data))));
		$combo_case_status->ListData = $combo_case_status->ListItem;
	} else {
		$combo_case_status->ListItem = array_trim(explode('||', entitiesToUTF8(convertLegacyOptions("Open;;Assigned;;In Progress;;Escalated;;Awaiting Customer;;Closed"))));
		$combo_case_status->ListData = $combo_case_status->ListItem;
	}
	$combo_case_status->SelectName = 'case_status';
	// combobox: case_client
	$combo_case_client = new DataCombo;
	// combobox: case_call, filterable by: case_client
	$combo_case_call = new DataCombo;

	if($selected_id) {
		// mm: check member permissions
		if(!$arrPerm['view']) return $Translation['tableAccessDenied'];

		// mm: who is the owner?
		$ownerGroupID = sqlValue("SELECT `groupID` FROM `membership_userrecords` WHERE `tableName`='supportcase' AND `pkValue`='" . makeSafe($selected_id) . "'");
		$ownerMemberID = sqlValue("SELECT LCASE(`memberID`) FROM `membership_userrecords` WHERE `tableName`='supportcase' AND `pkValue`='" . makeSafe($selected_id) . "'");

		if($arrPerm['view'] == 1 && getLoggedMemberID() != $ownerMemberID) return $Translation['tableAccessDenied'];
		if($arrPerm['view'] == 2 && getLoggedGroupID() != $ownerGroupID) return $Translation['tableAccessDenied'];

		// can edit?
		$AllowUpdate = 0;
		if(($arrPerm['edit'] == 1 && $ownerMemberID == getLoggedMemberID()) || ($arrPerm['edit'] == 2 && $ownerGroupID == getLoggedGroupID()) || $arrPerm['edit'] == 3) {
			$AllowUpdate = 1;
		}

		$res = sql("SELECT * FROM `supportcase` WHERE `case_ID`='" . makeSafe($selected_id) . "'", $eo);
		if(!($row = db_fetch_array($res))) {
			return error_message($Translation['No records found'], 'supportcase_view.php', false);
		}
		$combo_case_status->SelectedData = $row['case_status'];
		$combo_case_client->SelectedData = $row['case_client'];
		$combo_case_call->SelectedData = $row['case_call'];
		$urow = $row; /* unsanitized data */
		$row = array_map('safe_html', $row);
	} else {
		$filterField = Request::val('FilterField');
		$filterOperator = Request::val('FilterOperator');
		$filterValue = Request::val('FilterValue');
		$combo_case_status->SelectedText = (isset($filterField[1]) && $filterField[1] == '3' && $filterOperator[1] == '<=>' ? $filterValue[1] : '');
		$combo_case_client->SelectedData = $filterer_case_client;
		$combo_case_call->SelectedData = $filterer_case_call;
	}
	$combo_case_status->Render();
	$combo_case_client->HTML = '<span id="case_client-container' . $rnd1 . '"></span><input type="hidden" name="case_client" id="case_client' . $rnd1 . '" value="' . html_attr($combo_case_client->SelectedData) . '">';
	$combo_case_client->MatchText = '<span id="case_client-container-readonly' . $rnd1 . '"></span><input type="hidden" name="case_client" id="case_client' . $rnd1 . '" value="' . html_attr($combo_case_client->SelectedData) . '">';
	$combo_case_call->HTML = '<span id="case_call-container' . $rnd1 . '"></span><input type="hidden" name="case_call" id="case_call' . $rnd1 . '" value="' . html_attr($combo_case_call->SelectedData) . '">';
	$combo_case_call->MatchText = '<span id="case_call-container-readonly' . $rnd1 . '"></span><input type="hidden" name="case_call" id="case_call' . $rnd1 . '" value="' . html_attr($combo_case_call->SelectedData) . '">';

	ob_start();
	?>

	<script>
		// initial lookup values
		AppGini.current_case_client__RAND__ = { text: "", value: "<?php echo addslashes($selected_id ? $urow['case_client'] : htmlspecialchars($filterer_case_client, ENT_QUOTES)); ?>"};
		AppGini.current_case_call__RAND__ = { text: "", value: "<?php echo addslashes($selected_id ? $urow['case_call'] : htmlspecialchars($filterer_case_call, ENT_QUOTES)); ?>"};

		jQuery(function() {
			setTimeout(function() {
				if(typeof(case_client_reload__RAND__) == 'function') case_client_reload__RAND__();
				<?php echo (!$AllowUpdate || $dvprint ? 'if(typeof(case_call_reload__RAND__) == \'function\') case_call_reload__RAND__(AppGini.current_case_client__RAND__.value);' : ''); ?>
			}, 50); /* we need to slightly delay client-side execution of the above code to allow AppGini.ajaxCache to work */
		});
		function case_client_reload__RAND__() {
		<?php if(($AllowUpdate || $AllowInsert) && !$dvprint) { ?>

			$j("#case_client-container__RAND__").select2({
				/* initial default value */
				initSelection: function(e, c) {
					$j.ajax({
						url: 'ajax_combo.php',
						dataType: 'json',
						data: { id: AppGini.current_case_client__RAND__.value, t: 'supportcase', f: 'case_client' },
						success: function(resp) {
							c({
								id: resp.results[0].id,
								text: resp.results[0].text
							});
							$j('[name="case_client"]').val(resp.results[0].id);
							$j('[id=case_client-container-readonly__RAND__]').html('<span class="match-text" id="case_client-match-text">' + resp.results[0].text + '</span>');
							if(resp.results[0].id == '<?php echo empty_lookup_value; ?>') { $j('.btn[id=clients_view_parent]').hide(); } else { $j('.btn[id=clients_view_parent]').show(); }

						if(typeof(case_call_reload__RAND__) == 'function') case_call_reload__RAND__(AppGini.current_case_client__RAND__.value);

							if(typeof(case_client_update_autofills__RAND__) == 'function') case_client_update_autofills__RAND__();
						}
					});
				},
				width: '100%',
				formatNoMatches: function(term) { return '<?php echo addslashes($Translation['No matches found!']); ?>'; },
				minimumResultsForSearch: 5,
				loadMorePadding: 200,
				ajax: {
					url: 'ajax_combo.php',
					dataType: 'json',
					cache: true,
					data: function(term, page) { return { s: term, p: page, t: 'supportcase', f: 'case_client' }; },
					results: function(resp, page) { return resp; }
				},
				escapeMarkup: function(str) { return str; }
			}).on('change', function(e) {
				AppGini.current_case_client__RAND__.value = e.added.id;
				AppGini.current_case_client__RAND__.text = e.added.text;
				$j('[name="case_client"]').val(e.added.id);
				if(e.added.id == '<?php echo empty_lookup_value; ?>') { $j('.btn[id=clients_view_parent]').hide(); } else { $j('.btn[id=clients_view_parent]').show(); }

						if(typeof(case_call_reload__RAND__) == 'function') case_call_reload__RAND__(AppGini.current_case_client__RAND__.value);

				if(typeof(case_client_update_autofills__RAND__) == 'function') case_client_update_autofills__RAND__();
			});

			if(!$j("#case_client-container__RAND__").length) {
				$j.ajax({
					url: 'ajax_combo.php',
					dataType: 'json',
					data: { id: AppGini.current_case_client__RAND__.value, t: 'supportcase', f: 'case_client' },
					success: function(resp) {
						$j('[name="case_client"]').val(resp.results[0].id);
						$j('[id=case_client-container-readonly__RAND__]').html('<span class="match-text" id="case_client-match-text">' + resp.results[0].text + '</span>');
						if(resp.results[0].id == '<?php echo empty_lookup_value; ?>') { $j('.btn[id=clients_view_parent]').hide(); } else { $j('.btn[id=clients_view_parent]').show(); }

						if(typeof(case_client_update_autofills__RAND__) == 'function') case_client_update_autofills__RAND__();
					}
				});
			}

		<?php } else { ?>

			$j.ajax({
				url: 'ajax_combo.php',
				dataType: 'json',
				data: { id: AppGini.current_case_client__RAND__.value, t: 'supportcase', f: 'case_client' },
				success: function(resp) {
					$j('[id=case_client-container__RAND__], [id=case_client-container-readonly__RAND__]').html('<span class="match-text" id="case_client-match-text">' + resp.results[0].text + '</span>');
					if(resp.results[0].id == '<?php echo empty_lookup_value; ?>') { $j('.btn[id=clients_view_parent]').hide(); } else { $j('.btn[id=clients_view_parent]').show(); }

					if(typeof(case_client_update_autofills__RAND__) == 'function') case_client_update_autofills__RAND__();
				}
			});
		<?php } ?>

		}
		function case_call_reload__RAND__(filterer_case_client) {
		<?php if(($AllowUpdate || $AllowInsert) && !$dvprint) { ?>

			$j("#case_call-container__RAND__").select2({
				/* initial default value */
				initSelection: function(e, c) {
					$j.ajax({
						url: 'ajax_combo.php',
						dataType: 'json',
						data: { filterer_case_client: filterer_case_client, id: AppGini.current_case_call__RAND__.value, t: 'supportcase', f: 'case_call' },
						success: function(resp) {
							c({
								id: resp.results[0].id,
								text: resp.results[0].text
							});
							$j('[name="case_call"]').val(resp.results[0].id);
							$j('[id=case_call-container-readonly__RAND__]').html('<span class="match-text" id="case_call-match-text">' + resp.results[0].text + '</span>');
							if(resp.results[0].id == '<?php echo empty_lookup_value; ?>') { $j('.btn[id=call_logs_view_parent]').hide(); } else { $j('.btn[id=call_logs_view_parent]').show(); }


							if(typeof(case_call_update_autofills__RAND__) == 'function') case_call_update_autofills__RAND__();
						}
					});
				},
				width: '100%',
				formatNoMatches: function(term) { return '<?php echo addslashes($Translation['No matches found!']); ?>'; },
				minimumResultsForSearch: 5,
				loadMorePadding: 200,
				ajax: {
					url: 'ajax_combo.php',
					dataType: 'json',
					cache: true,
					data: function(term, page) { return { filterer_case_client: filterer_case_client, s: term, p: page, t: 'supportcase', f: 'case_call' }; },
					results: function(resp, page) { return resp; }
				},
				escapeMarkup: function(str) { return str; }
			}).on('change', function(e) {
				AppGini.current_case_call__RAND__.value = e.added.id;
				AppGini.current_case_call__RAND__.text = e.added.text;
				$j('[name="case_call"]').val(e.added.id);
				if(e.added.id == '<?php echo empty_lookup_value; ?>') { $j('.btn[id=call_logs_view_parent]').hide(); } else { $j('.btn[id=call_logs_view_parent]').show(); }


				if(typeof(case_call_update_autofills__RAND__) == 'function') case_call_update_autofills__RAND__();
			});

			if(!$j("#case_call-container__RAND__").length) {
				$j.ajax({
					url: 'ajax_combo.php',
					dataType: 'json',
					data: { id: AppGini.current_case_call__RAND__.value, t: 'supportcase', f: 'case_call' },
					success: function(resp) {
						$j('[name="case_call"]').val(resp.results[0].id);
						$j('[id=case_call-container-readonly__RAND__]').html('<span class="match-text" id="case_call-match-text">' + resp.results[0].text + '</span>');
						if(resp.results[0].id == '<?php echo empty_lookup_value; ?>') { $j('.btn[id=call_logs_view_parent]').hide(); } else { $j('.btn[id=call_logs_view_parent]').show(); }

						if(typeof(case_call_update_autofills__RAND__) == 'function') case_call_update_autofills__RAND__();
					}
				});
			}

		<?php } else { ?>

			$j.ajax({
				url: 'ajax_combo.php',
				dataType: 'json',
				data: { id: AppGini.current_case_call__RAND__.value, t: 'supportcase', f: 'case_call' },
				success: function(resp) {
					$j('[id=case_call-container__RAND__], [id=case_call-container-readonly__RAND__]').html('<span class="match-text" id="case_call-match-text">' + resp.results[0].text + '</span>');
					if(resp.results[0].id == '<?php echo empty_lookup_value; ?>') { $j('.btn[id=call_logs_view_parent]').hide(); } else { $j('.btn[id=call_logs_view_parent]').show(); }

					if(typeof(case_call_update_autofills__RAND__) == 'function') case_call_update_autofills__RAND__();
				}
			});
		<?php } ?>

		}
	</script>
	<?php

	$lookups = str_replace('__RAND__', $rnd1, ob_get_clean());


	// code for template based detail view forms

	// open the detail view template
	if($dvprint) {
		$template_file = is_file("./{$TemplateDVP}") ? "./{$TemplateDVP}" : './templates/supportcase_templateDVP.html';
		$templateCode = @file_get_contents($template_file);
	} else {
		$template_file = is_file("./{$TemplateDV}") ? "./{$TemplateDV}" : './templates/supportcase_templateDV.html';
		$templateCode = @file_get_contents($template_file);
	}

	// process form title
	$templateCode = str_replace('<%%DETAIL_VIEW_TITLE%%>', 'Support Case details', $templateCode);
	$templateCode = str_replace('<%%RND1%%>', $rnd1, $templateCode);
	$templateCode = str_replace('<%%EMBEDDED%%>', (Request::val('Embedded') ? 'Embedded=1' : ''), $templateCode);
	// process buttons
	if($AllowInsert) {
		if(!$selected_id) $templateCode = str_replace('<%%INSERT_BUTTON%%>', '<button type="submit" class="btn btn-success" id="insert" name="insert_x" value="1" onclick="return supportcase_validateData();"><i class="glyphicon glyphicon-plus-sign"></i> ' . $Translation['Save New'] . '</button>', $templateCode);
		$templateCode = str_replace('<%%INSERT_BUTTON%%>', '<button type="submit" class="btn btn-default" id="insert" name="insert_x" value="1" onclick="return supportcase_validateData();"><i class="glyphicon glyphicon-plus-sign"></i> ' . $Translation['Save As Copy'] . '</button>', $templateCode);
	} else {
		$templateCode = str_replace('<%%INSERT_BUTTON%%>', '', $templateCode);
	}

	// 'Back' button action
	if(Request::val('Embedded')) {
		$backAction = 'AppGini.closeParentModal(); return false;';
	} else {
		$backAction = '$j(\'form\').eq(0).attr(\'novalidate\', \'novalidate\'); document.myform.reset(); return true;';
	}

	if($selected_id) {
		if(!Request::val('Embedded')) $templateCode = str_replace('<%%DVPRINT_BUTTON%%>', '<button type="submit" class="btn btn-default" id="dvprint" name="dvprint_x" value="1" onclick="$j(\'form\').eq(0).prop(\'novalidate\', true); document.myform.reset(); return true;" title="' . html_attr($Translation['Print Preview']) . '"><i class="glyphicon glyphicon-print"></i> ' . $Translation['Print Preview'] . '</button>', $templateCode);
		if($AllowUpdate) {
			$templateCode = str_replace('<%%UPDATE_BUTTON%%>', '<button type="submit" class="btn btn-success btn-lg" id="update" name="update_x" value="1" onclick="return supportcase_validateData();" title="' . html_attr($Translation['Save Changes']) . '"><i class="glyphicon glyphicon-ok"></i> ' . $Translation['Save Changes'] . '</button>', $templateCode);
		} else {
			$templateCode = str_replace('<%%UPDATE_BUTTON%%>', '', $templateCode);
		}
		if(($arrPerm['delete'] == 1 && $ownerMemberID == getLoggedMemberID()) || ($arrPerm['delete'] == 2 && $ownerGroupID == getLoggedGroupID()) || $arrPerm['delete'] == 3) { // allow delete?
			$templateCode = str_replace('<%%DELETE_BUTTON%%>', '<button type="submit" class="btn btn-danger" id="delete" name="delete_x" value="1" title="' . html_attr($Translation['Delete']) . '"><i class="glyphicon glyphicon-trash"></i> ' . $Translation['Delete'] . '</button>', $templateCode);
		} else {
			$templateCode = str_replace('<%%DELETE_BUTTON%%>', '', $templateCode);
		}
		$templateCode = str_replace('<%%DESELECT_BUTTON%%>', '<button type="submit" class="btn btn-default" id="deselect" name="deselect_x" value="1" onclick="' . $backAction . '" title="' . html_attr($Translation['Back']) . '"><i class="glyphicon glyphicon-chevron-left"></i> ' . $Translation['Back'] . '</button>', $templateCode);
	} else {
		$templateCode = str_replace('<%%UPDATE_BUTTON%%>', '', $templateCode);
		$templateCode = str_replace('<%%DELETE_BUTTON%%>', '', $templateCode);

		// if not in embedded mode and user has insert only but no view/update/delete,
		// remove 'back' button
		if(
			$arrPerm['insert']
			&& !$arrPerm['update'] && !$arrPerm['delete'] && !$arrPerm['view']
			&& !Request::val('Embedded')
		)
			$templateCode = str_replace('<%%DESELECT_BUTTON%%>', '', $templateCode);
		elseif($separateDV)
			$templateCode = str_replace(
				'<%%DESELECT_BUTTON%%>', 
				'<button
					type="submit" 
					class="btn btn-default" 
					id="deselect" 
					name="deselect_x" 
					value="1" 
					onclick="' . $backAction . '" 
					title="' . html_attr($Translation['Back']) . '">
						<i class="glyphicon glyphicon-chevron-left"></i> ' .
						$Translation['Back'] .
				'</button>',
				$templateCode
			);
		else
			$templateCode = str_replace('<%%DESELECT_BUTTON%%>', '', $templateCode);
	}

	// set records to read only if user can't insert new records and can't edit current record
	if(($selected_id && !$AllowUpdate && !$AllowInsert) || (!$selected_id && !$AllowInsert)) {
		$jsReadOnly = '';
		$jsReadOnly .= "\tjQuery('#case_status').replaceWith('<div class=\"form-control-static\" id=\"case_status\">' + (jQuery('#case_status').val() || '') + '</div>'); jQuery('#case_status-multi-selection-help').hide();\n";
		$jsReadOnly .= "\tjQuery('#case_client').prop('disabled', true).css({ color: '#555', backgroundColor: '#fff' });\n";
		$jsReadOnly .= "\tjQuery('#case_client_caption').prop('disabled', true).css({ color: '#555', backgroundColor: 'white' });\n";
		$jsReadOnly .= "\tjQuery('#case_call').prop('disabled', true).css({ color: '#555', backgroundColor: '#fff' });\n";
		$jsReadOnly .= "\tjQuery('#case_call_caption').prop('disabled', true).css({ color: '#555', backgroundColor: 'white' });\n";
		$jsReadOnly .= "\tjQuery('#case_external').replaceWith('<div class=\"form-control-static\" id=\"case_external\">' + (jQuery('#case_external').val() || '') + '</div>');\n";
		$jsReadOnly .= "\tjQuery('#case_subject').replaceWith('<div class=\"form-control-static\" id=\"case_subject\">' + (jQuery('#case_subject').val() || '') + '</div>');\n";
		$jsReadOnly .= "\tjQuery('.select2-container').hide();\n";

		$noUploads = true;
	} elseif($AllowInsert) {
		$jsEditable = "\tjQuery('form').eq(0).data('already_changed', true);"; // temporarily disable form change handler
		$jsEditable .= "\tjQuery('form').eq(0).data('already_changed', false);"; // re-enable form change handler
	}

	// process combos
	$templateCode = str_replace('<%%COMBO(case_status)%%>', $combo_case_status->HTML, $templateCode);
	$templateCode = str_replace('<%%COMBOTEXT(case_status)%%>', $combo_case_status->SelectedData, $templateCode);
	$templateCode = str_replace('<%%COMBO(case_client)%%>', $combo_case_client->HTML, $templateCode);
	$templateCode = str_replace('<%%COMBOTEXT(case_client)%%>', $combo_case_client->MatchText, $templateCode);
	$templateCode = str_replace('<%%URLCOMBOTEXT(case_client)%%>', urlencode($combo_case_client->MatchText), $templateCode);
	$templateCode = str_replace('<%%COMBO(case_call)%%>', $combo_case_call->HTML, $templateCode);
	$templateCode = str_replace('<%%COMBOTEXT(case_call)%%>', $combo_case_call->MatchText, $templateCode);
	$templateCode = str_replace('<%%URLCOMBOTEXT(case_call)%%>', urlencode($combo_case_call->MatchText), $templateCode);

	/* lookup fields array: 'lookup field name' => ['parent table name', 'lookup field caption'] */
	$lookup_fields = ['case_client' => ['clients', 'Client'], 'case_call' => ['call_logs', 'Related Call'], ];
	foreach($lookup_fields as $luf => $ptfc) {
		$pt_perm = getTablePermissions($ptfc[0]);

		// process foreign key links
		if($pt_perm['view'] || $pt_perm['edit']) {
			$templateCode = str_replace("<%%PLINK({$luf})%%>", '<button type="button" class="btn btn-default view_parent" id="' . $ptfc[0] . '_view_parent" title="' . html_attr($Translation['View'] . ' ' . $ptfc[1]) . '"><i class="glyphicon glyphicon-eye-open"></i></button>', $templateCode);
		}

		// if user has insert permission to parent table of a lookup field, put an add new button
		if($pt_perm['insert'] /* && !Request::val('Embedded')*/) {
			$templateCode = str_replace("<%%ADDNEW({$ptfc[0]})%%>", '<button type="button" class="btn btn-default add_new_parent" id="' . $ptfc[0] . '_add_new" title="' . html_attr($Translation['Add New'] . ' ' . $ptfc[1]) . '"><i class="glyphicon glyphicon-plus text-success"></i></button>', $templateCode);
		}
	}

	// process images
	$templateCode = str_replace('<%%UPLOADFILE(case_ID)%%>', '', $templateCode);
	$templateCode = str_replace('<%%UPLOADFILE(case_number)%%>', '', $templateCode);
	$templateCode = str_replace('<%%UPLOADFILE(case_status)%%>', '', $templateCode);
	$templateCode = str_replace('<%%UPLOADFILE(case_client)%%>', '', $templateCode);
	$templateCode = str_replace('<%%UPLOADFILE(case_call)%%>', '', $templateCode);
	$templateCode = str_replace('<%%UPLOADFILE(case_datetime)%%>', '', $templateCode);
	$templateCode = str_replace('<%%UPLOADFILE(case_openedby)%%>', '', $templateCode);
	$templateCode = str_replace('<%%UPLOADFILE(case_external)%%>', '', $templateCode);
	$templateCode = str_replace('<%%UPLOADFILE(case_subject)%%>', '', $templateCode);
	$templateCode = str_replace('<%%UPLOADFILE(case_description)%%>', '', $templateCode);

	// process values
	if($selected_id) {
		if( $dvprint) $templateCode = str_replace('<%%VALUE(case_ID)%%>', safe_html($urow['case_ID']), $templateCode);
		if(!$dvprint) $templateCode = str_replace('<%%VALUE(case_ID)%%>', html_attr($row['case_ID']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(case_ID)%%>', urlencode($urow['case_ID']), $templateCode);
		$templateCode = str_replace('<%%VALUE(case_number)%%>', safe_html($urow['case_number']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(case_number)%%>', urlencode($urow['case_number']), $templateCode);
		if( $dvprint) $templateCode = str_replace('<%%VALUE(case_status)%%>', safe_html($urow['case_status']), $templateCode);
		if(!$dvprint) $templateCode = str_replace('<%%VALUE(case_status)%%>', html_attr($row['case_status']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(case_status)%%>', urlencode($urow['case_status']), $templateCode);
		if( $dvprint) $templateCode = str_replace('<%%VALUE(case_client)%%>', safe_html($urow['case_client']), $templateCode);
		if(!$dvprint) $templateCode = str_replace('<%%VALUE(case_client)%%>', html_attr($row['case_client']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(case_client)%%>', urlencode($urow['case_client']), $templateCode);
		if( $dvprint) $templateCode = str_replace('<%%VALUE(case_call)%%>', safe_html($urow['case_call']), $templateCode);
		if(!$dvprint) $templateCode = str_replace('<%%VALUE(case_call)%%>', html_attr($row['case_call']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(case_call)%%>', urlencode($urow['case_call']), $templateCode);
		$templateCode = str_replace('<%%VALUE(case_datetime)%%>', safe_html($urow['case_datetime']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(case_datetime)%%>', urlencode($urow['case_datetime']), $templateCode);
		$templateCode = str_replace('<%%VALUE(case_openedby)%%>', safe_html($urow['case_openedby']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(case_openedby)%%>', urlencode($urow['case_openedby']), $templateCode);
		if( $dvprint) $templateCode = str_replace('<%%VALUE(case_external)%%>', safe_html($urow['case_external']), $templateCode);
		if(!$dvprint) $templateCode = str_replace('<%%VALUE(case_external)%%>', html_attr($row['case_external']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(case_external)%%>', urlencode($urow['case_external']), $templateCode);
		if( $dvprint) $templateCode = str_replace('<%%VALUE(case_subject)%%>', safe_html($urow['case_subject']), $templateCode);
		if(!$dvprint) $templateCode = str_replace('<%%VALUE(case_subject)%%>', html_attr($row['case_subject']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(case_subject)%%>', urlencode($urow['case_subject']), $templateCode);
		if($AllowUpdate || $AllowInsert) {
			$templateCode = str_replace('<%%HTMLAREA(case_description)%%>', '<textarea name="case_description" id="case_description" rows="5">' . safe_html(htmlspecialchars_decode($row['case_description'])) . '</textarea>', $templateCode);
		} else {
			$templateCode = str_replace('<%%HTMLAREA(case_description)%%>', '<div id="case_description" class="form-control-static">' . $row['case_description'] . '</div>', $templateCode);
		}
		$templateCode = str_replace('<%%VALUE(case_description)%%>', nl2br($row['case_description']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(case_description)%%>', urlencode($urow['case_description']), $templateCode);
	} else {
		$templateCode = str_replace('<%%VALUE(case_ID)%%>', '', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(case_ID)%%>', urlencode(''), $templateCode);
		$templateCode = str_replace('<%%VALUE(case_number)%%>', '<%%creationTimestamp%%>', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(case_number)%%>', urlencode('<%%creationTimestamp%%>'), $templateCode);
		$templateCode = str_replace('<%%VALUE(case_status)%%>', '', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(case_status)%%>', urlencode(''), $templateCode);
		$templateCode = str_replace('<%%VALUE(case_client)%%>', '', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(case_client)%%>', urlencode(''), $templateCode);
		$templateCode = str_replace('<%%VALUE(case_call)%%>', '', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(case_call)%%>', urlencode(''), $templateCode);
		$templateCode = str_replace('<%%VALUE(case_datetime)%%>', '<%%creationDateTime%%>', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(case_datetime)%%>', urlencode('<%%creationDateTime%%>'), $templateCode);
		$templateCode = str_replace('<%%VALUE(case_openedby)%%>', '<%%creatorUsername%%>', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(case_openedby)%%>', urlencode('<%%creatorUsername%%>'), $templateCode);
		$templateCode = str_replace('<%%VALUE(case_external)%%>', '', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(case_external)%%>', urlencode(''), $templateCode);
		$templateCode = str_replace('<%%VALUE(case_subject)%%>', '', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(case_subject)%%>', urlencode(''), $templateCode);
		$templateCode = str_replace('<%%HTMLAREA(case_description)%%>', '<textarea name="case_description" id="case_description" rows="5"></textarea>', $templateCode);
	}

	// process translations
	$templateCode = parseTemplate($templateCode);

	// clear scrap
	$templateCode = str_replace('<%%', '<!-- ', $templateCode);
	$templateCode = str_replace('%%>', ' -->', $templateCode);

	// hide links to inaccessible tables
	if(Request::val('dvprint_x') == '') {
		$templateCode .= "\n\n<script>\$j(function() {\n";
		$arrTables = getTableList();
		foreach($arrTables as $name => $caption) {
			$templateCode .= "\t\$j('#{$name}_link').removeClass('hidden');\n";
			$templateCode .= "\t\$j('#xs_{$name}_link').removeClass('hidden');\n";
		}

		$templateCode .= $jsReadOnly;
		$templateCode .= $jsEditable;

		if(!$selected_id) {
		}

		$templateCode.="\n});</script>\n";
	}

	// ajaxed auto-fill fields
	$templateCode .= '<script>';
	$templateCode .= '$j(function() {';


	$templateCode.="});";
	$templateCode.="</script>";
	$templateCode .= $lookups;

	// handle enforced parent values for read-only lookup fields
	$filterField = Request::val('FilterField');
	$filterOperator = Request::val('FilterOperator');
	$filterValue = Request::val('FilterValue');

	// don't include blank images in lightbox gallery
	$templateCode = preg_replace('/blank.gif" data-lightbox=".*?"/', 'blank.gif"', $templateCode);

	// don't display empty email links
	$templateCode=preg_replace('/<a .*?href="mailto:".*?<\/a>/', '', $templateCode);

	/* default field values */
	$rdata = $jdata = get_defaults('supportcase');
	if($selected_id) {
		$jdata = get_joined_record('supportcase', $selected_id);
		if($jdata === false) $jdata = get_defaults('supportcase');
		$rdata = $row;
	}
	$templateCode .= loadView('supportcase-ajax-cache', ['rdata' => $rdata, 'jdata' => $jdata]);

	// hook: supportcase_dv
	if(function_exists('supportcase_dv')) {
		$args = [];
		supportcase_dv(($selected_id ? $selected_id : FALSE), getMemberInfo(), $templateCode, $args);
	}

	return $templateCode;
}
$j(function() {
	/* TODO: (Debugging) set to false on production */
	AppGiniPlugin.enableDebugging = false;

	/* variable definitions/initialization */
	// before calling this file, AppGiniPlugin.prj must be defined as the project object
	if(AppGiniPlugin.prj == undefined) {
		console.error("AppGiniPlugin.prj not defined!");
		return;
	}
	
	var project = AppGiniPlugin.project(AppGiniPlugin.prj);
	var editor = {
		sections: AppGiniPlugin.form('#report-sections'),
		data: AppGiniPlugin.form('#report-data')
	};
	var axp_md5 = AppGiniPlugin.axp_md5;
	var summaryFunctions = {
		avg: 'Average',
		count: 'Count',
		max: 'Maximum',
		min: 'Minimum',
		sum: 'Sum'
	};
	AppGiniPlugin.getTableAncestors = {};

	AppGiniPlugin.defaultReportOptions = {
		report_hash: '',
		group_array: [],
		custom_where: '',
		override_permissions: false,
		title: '',
		date_field: '',
		parent_table: '',
		label: '',
		group_function: '',
		group_function_field: '',
		data_table_section: true,
		piechart_section: false,
		barchart_section: false,
		report_header_url: '',
		report_footer_url: ''
	};

	AppGiniPlugin.listTableReports = function(table_index) {
		AppGiniPlugin.debug('AppGiniPlugin.listTableReports', table_index);

		var table = project.getTable(table_index);
		AppGiniPlugin.table_name = table.name;
		AppGiniPlugin.table_index = table_index;
		var reports = getReports(table.name);

		// caching table ancestors, if needed, to be ready when report editor is open
		getTableAncestors(table.name);

		AppGiniPlugin.reportsList.items(reports);
		console.log(
			'Selected table: ' + table.name + 
			' (index: ' + table_index + ')' +
			' contains ' + reports.length + ' reports'
		);
	}

	var getReports = function(tableName) {
		var table = project.getTableByName(tableName);
		if(table.plugins == undefined) return [];
		if(table.plugins.summary_reports == undefined) return [];
		if(table.plugins.summary_reports.report_details == undefined) return [];

		var rd = table.plugins.summary_reports.report_details;
		if(typeof(rd) != 'string') return [];

		var reports = JSON.parse(rd);

		// if reports is not an array, make it one
		reportsArr = [];
		if(reports.length == undefined) {
			for(var i in reports) {
				if(!reports.hasOwnProperty(i)) continue;
				reportsArr.push(reports[i]);
			}
			reports = reportsArr;
		}

		return reports;
	}

	var setReports = function(tableName, reports) {
		var table = project.getTableByName(tableName);
		table.plugins = table.plugins || {};
		table.plugins.summary_reports = table.plugins.summary_reports || {};
		table.plugins.summary_reports.report_details = JSON.stringify(reports);
	}

	var resetReportForm = function() {
		AppGiniPlugin.debug('resetReportForm');

		editor.sections.reset();
		editor.data.reset();
		
		/* hide any validation errors */
		$j('.validation-error').addClass('hidden');
		
		/* focus report title */
		$j('#report-title').focus();
		
		displayGroupingControls();

		displaySummaryControls({ function: 'count' });
	}
	
	/* fill #how-to-summarize drop-down if empty, and selected given value */
	var populateHowToSummarizeField = function(selectedValue, countOnly) {
		AppGiniPlugin.debug('populateHowToSummarizeField', selectedValue, countOnly);
		
		if(countOnly == undefined) countOnly = false;

		var hts = [];
		$j.each(summaryFunctions, function(key , caption) {
			if(countOnly && key != 'count') return;
			hts.push({ id: key,	text: caption });
		});

		/* Fill How To Summrize drop-down */
		editor.data.get('how-to-summarize').setOptions(hts, selectedValue);
	}
	
	var getTableAncestors = function(table) {
		AppGiniPlugin.debug('getTableAncestors', table);

		/* table ancestors already cached? */
		if(AppGiniPlugin.getTableAncestors[table] != undefined) return;

		/* Send ajax request to get table ancestors */
		$j.ajax({
			url: 'table-ancestors-ajax.php',
			data: {
				axp: AppGiniPlugin.axp_md5,
				table_name: table
			},
			success: function(data) {
				AppGiniPlugin.getTableAncestors[table] = JSON.parse(data);
			},
			error: function() {
				// try again in 30 seconds
				(function(tn) {
					setTimeout(function() { getTableAncestors(tn); }, 30000);
				})(table);
			}
		});
	}
	
	var populateTableAncestors = function(table, ancestorTableName) {
		AppGiniPlugin.debug('populateTableAncestors', table, ancestorTableName);

		if(AppGiniPlugin.getTableAncestors[table] == undefined) return;
		var gt = editor.data.get('group-table');
		gt.reset();

		var ancestors = AppGiniPlugin.getTableAncestors[table];
		if(!ancestors.length) return;

		gt.setOptions(
			ancestors.map(function(a) { return { id: a, text: a }; }),
			ancestorTableName
		);
	}

	var populateDateFields = function(table, dateField) {
		AppGiniPlugin.debug('populateDateFields', table, dateField);

		var dates = [];
		var table_fields = [];
	
		table_fields = project.getTable(table).field;
		
		/* Loop over table fields to retrieve date and datetime fields */
		for(var j = 0; j < table_fields.length; j++) {	 
			var field_type = parseInt(table_fields[j].dataType);
			if(field_type < 9 || field_type > 10) continue;

			dates.push({
				id: table_fields[j].name,
				text: table_fields[j].caption
			});
		}

		editor.data.get('date-field').setOptions(dates, dateField);
	}

	/**
	 * @param table could be either table name or table index, default is current table name
	 */
	var populateLabels = function(table, selectedLabel) {
		AppGiniPlugin.debug('populateLabels', table, selectedLabel);

		table = table || AppGiniPlugin.table_name;
		var labels = [], t = project.getTable(table);

		if(t == undefined) {
			// invalid table value .. return, leaving #label empty
			editor.data.get('label').setOptions([]);
			return;
		}

		// Loop over table fields to populate labels dropdown
		for(var j = 0; j < t.field.length; j++)
			labels.push({ id: t.field[j].name, text: t.field[j].caption });

		editor.data.get('label').setOptions(labels, selectedLabel);
	}
	
	var displayGroupingControls = function(data) {
		AppGiniPlugin.debug('displayGroupingControls', JSON.stringify(data));

		// defaults
		data = $j.extend({}, {
			table: AppGiniPlugin.table_name,
			groupTable: '',
			labelField: '',
			userTriggered: false
		}, data);

		populateTableAncestors(data.table, data.groupTable);

		var ancestors = AppGiniPlugin.getTableAncestors[data.table] || [];
		if(ancestors.length) {
			editor.data.get('single-table').show();
			if(!data.userTriggered) $j('#single-table').prop('checked', data.groupTable != '');

			editor.data.get('group-table').display($j('#single-table').prop('checked'));
			$j('#group-table-no-ancestors').addClass('hidden');

			if(data.userTriggered) data.labelField = $j('#label').val();
			populateLabels(data.groupTable ? data.groupTable : data.table, data.labelField);

			return;
		}

		editor.data.get('single-table').hide();
		$j('#single-table').prop('checked', false);

		editor.data.get('group-table').hide();
		$j('#group-table-no-ancestors').removeClass('hidden');
		populateLabels(data.table, data.labelField);
	}

	var fieldCanBeSummmarized = function(f) {
		AppGiniPlugin.debug('fieldCanBeSummmarized', '{' + f.name + '}');

		return (parseInt(f.dataType) < 9 && f.primaryKey != 'True' && f.unique != 'True' && f.parentTable.length == undefined);
	}

	var summaryFields = function(t) {
		AppGiniPlugin.debug('summaryFields', '{' + t.name + '}');

		var fields = [];
		for(var i = 0; i < t.field.length; i++) {
			if(fieldCanBeSummmarized(t.field[i])) fields.push(t.field[i]);
		}
		return fields;
	}

	/* populate #summarized-value drop-down for given tablename, and select given field name, and return number of summary fields */
	var populateSummaryFields = function(tn, fn) {
		AppGiniPlugin.debug('populateSummaryFields', tn, fn);

		var t = project.getTableByName(tn);
		if(t == undefined) return 0;

		var sf = summaryFields(t);
		editor.data.get('summarized-value').setOptions(
			sf.map(function(f) {
				return { id: f.name, text: f.caption };
			}), 
		fn);

		return sf.length;
	}

	var displaySummaryControls = function(data) {
		AppGiniPlugin.debug('displaySummaryControls', JSON.stringify(data));

		// defaults
		data = $j.extend({}, {
			table: AppGiniPlugin.table_name,
			function: 'count',
			field: '',
			userTriggered: false
		}, data);

		var numSummaryFields = populateSummaryFields(data.table, data.field);
		if(numSummaryFields) {
			populateHowToSummarizeField(data.function);
			$j('#how-to-summarize').prop('readonly', false);
			editor.data.get('summarized-value').display(data.function != 'count');
			// data.userTriggered??
			$j('#summarized-value-validation').addClass('hidden');
			return;
		}

		editor.data.get('summarized-value').hide();
		$j('#how-to-summarize').prop('readonly', true);
		populateHowToSummarizeField('count', true);
		$j('#summarized-value-validation').removeClass('hidden');
	}

	var buildReportForm = function() {
		// do this only once
		if(AppGiniPlugin.buildReportFormCalled != undefined) return;

		var reportSections = AppGiniPlugin.form('#report-sections');
		reportSections.add({
			id: 'report-header-url',
			label: 'Report header image URL <i class="glyphicon glyphicon-question-sign"></i>',
			labelTitle: 'Enter the URL of an image to use as the report header.'
		}).add({
			id: 'report-title',
			label: 'Report Title',
			required: true,
			maxLength: 40,
			help: 'Report title required',
			helpClasses: 'text-danger hidden validation-error',
			helpId: 'title-validation'
		}).add({
			id: 'data-table-section',
			label: 'Data table<div class="minimalist"><img src="images/summary-reports-data-table-section.png" class="img-responsive"></div>',
			type: 'checkbox',
			name: 'data_table_section',
			init: true
		}).add({
			id: 'bar-chart-section',
			label: 'Bar chart<div class="minimalist"><img src="images/summary-reports-bar-chart-section.png" class="img-responsive"></div>',
			type: 'checkbox',
			name: 'barchart_section'
		}).add({
			id: 'pie-chart-section',
			label: 'Pie chart<div class="minimalist"><img src="images/summary-reports-pie-chart-section.png" class="img-responsive"></div>',
			type: 'checkbox',
			name: 'piechart_section'
		}).add({
			id: 'report-footer-url',
			label: 'Report footer image URL <i class="glyphicon glyphicon-question-sign"></i>',
			labelTitle: 'Enter the URL of an image to use as the report footer.',
			help: '<i class="minimalist">This is an experimental feature and not yet supported by browsers.</i>'
		})
		.add({ type: 'hidden', id: 'table-index' })
		.add({ type: 'hidden', id: 'report-id' })
		.add({ type: 'hidden', id: 'report-hash', init: AppGiniPlugin.randomHash })
		.add({ type: 'hidden', id: 'first-caption' })
		.add({ type: 'hidden', id: 'second-caption' })
		.add({ type: 'hidden', id: 'look-up-table' })
		.add({ type: 'hidden', id: 'look-up-value' })
		.add({ type: 'hidden', id: 'label-field-index' })
		.add({ type: 'hidden', id: 'date-field-index' })
		;

		var reportData = AppGiniPlugin.form('#report-data');
		var modalLabelClasses = ['col-xs-offset-1', 'col-xs-10', 'col-sm-3', 'col-sm-offset-1'];
		var modalInputClasses = ['col-xs-offset-1', 'col-xs-10', 'col-sm-7', 'col-sm-offset-0'];

		reportData.add({
			id: 'single-table',
			label: 'Group data by a field from another table',
			type: 'checkbox',
			labelClasses: modalLabelClasses,
			controlWrapperClasses: modalInputClasses
		}).add({
			id: 'group-table',
			label: 'Group Table',
			type: 'select',
			labelClasses: modalLabelClasses,
			controlWrapperClasses: modalInputClasses
		}).add({
			id: 'label',
			label: 'Label Field',
			type: 'select',
			help: 'Label field required',
			helpId: 'label-validation',
			helpClasses: 'hidden text-danger validation-error',
			labelClasses: modalLabelClasses,
			controlWrapperClasses: modalInputClasses
		}).addHtml(
			'<div class="minimalist"><div id="group-table-no-ancestors" style="margin: 0 10%;" class="hidden">' +
				'This table has no parent table. ' +
				'Thus, records can\'t be grouped by a field from another table.' +
			'</div></div>'
		).addSeparator().add({
			id: 'how-to-summarize',
			type: 'select',
			label: 'Summary',
			labelClasses: modalLabelClasses,
			help: 'How do you want to summarize data in this report?',
			helpClasses: 'minimalist',
			controlWrapperClasses: modalInputClasses
		}).add({
			id: 'summarized-value',
			type: 'select',
			label: 'Of <i class="glyphicon glyphicon-question-sign"></i>',
			labelTitle: 'Specify which field to summarize.',
			help: 'A field must be selected',
			helpId: 'what-to-summarize-required',
			helpClasses: 'text-danger hidden validation-error',
			labelClasses: modalLabelClasses,
			controlWrapperClasses: modalInputClasses
		}).addHtml(
			'<div class="minimalist"><div class="hidden" id="summarized-value-validation" style="margin: 0 10%">' + 
				'This table has no fields to summarize. You can only use count.' +
			'</div></div>'
		).addSeparator().add({
			id: 'date-field',
			type: 'select',
			label: 'Date <i class="glyphicon glyphicon-question-sign"></i>',
			labelTitle: 'Date field used to filter the report',
			labelClasses: modalLabelClasses,
			controlWrapperClasses: modalInputClasses,
			noSelectionText: "Don't filter the report by date"
		}).addSeparator().add({
			id: 'group-array',
			type: 'textarea',
			rows: 2,
			label: 'Groups that can access this report',
			help: 'Enter each group in a separate line or leave it blank for all groups',
			helpClasses: 'minimalist',
			labelClasses: modalLabelClasses,
			controlWrapperClasses: modalInputClasses
		}).addSeparator().add({
			id: 'custom-where',
			type: 'textarea',
			rows: 2,
			label: 'Custom WHERE<br><a href="#" class="where-builder" data-goto="5" title="View available fields to use in the WHERE clause" style="font-size: 0.75em;">fields<i class="glyphicon glyphicon-log-out"></i> </a>',
			help: 'Conditions to use in the ' +
				  '<a href="https://www.mysqltutorial.org/mysql-where/" target="_blank" tabindex="-1">' +
				  'SQL WHERE clause</a> of this report for filtering report data. ' +
				  'For example: ' +
				  '<code>`orders`.`OrderSatus`=\'Paid\' AND `orders`.`Country`=\'USA\'</code> ' +
				  'would limit report data to paid orders from USA.',
			helpClasses: 'minimalist',
			labelClasses: modalLabelClasses,
			controlWrapperClasses: modalInputClasses
		}).addSeparator().add({
			id: 'override-permissions',
			type: 'checkbox',
			label: 'Show all records (overriding user permissions)',
			help: 'If this option is enabled, users will see all records in the report ' +
				'regardless of their permissions. The default is to show only the data users' +
				'have access to.',
			helpClasses: 'minimalist',
			labelClasses: modalLabelClasses,
			controlWrapperClasses: modalInputClasses
		});

		AppGiniPlugin.buildReportFormCalled = true;
	}

	var updateReportsCount = function() {
		var tables = AppGiniPlugin.prj.table;
		var reportsCount = {}, totalReports = 0;
		for(var i = 0; i < tables.length; i++) {
			var tn = tables[i].name;
			reportsCount[tn] = getReports(tn).length;
			totalReports += reportsCount[tn];

			// create a badge on corresponding table list if not already there
			var tl = $j('#tables-list [data-table_index="' + i + '"]');
			if(!tl.find('.badge').length) {
				$j('<span class="badge"></span>').appendTo(tl);
			}

			tl.find('.badge')
				.toggleClass('hidden', reportsCount[tn] == 0)
				.html(reportsCount[tn]);
		}

		$j('#clear-summary-reports').toggleClass('hidden', totalReports == 0);
	}

	var minimalistReportEditor = function(minimize) {
		var storeKey = 'plugin-summary-reports-minimalist-report-editor';
		if(minimize === undefined) {
			// if called without an explicit action, get last applied action
			// from localStorage and apply it
			// localStorage stores boolean as a string .. the following
			// ensures it's always a boolean
			minimize = JSON.parse(localStorage.getItem(storeKey));
			if(!minimize) minimize = false;
		}

		$j('#report-editor-form').find('.minimalist, hr').toggleClass('hidden', minimize);
		$j('.minimalist-invoker').toggleClass('active', minimize);
		localStorage.setItem(storeKey, minimize);
	}

	var applyAndPreserveItemsListDetailLevel = function() {
		// this function should run only once
		if(AppGiniPlugin._applyAndPreserveItemsListDetailLevel !== undefined) return;
		AppGiniPlugin._applyAndPreserveItemsListDetailLevel = true;

		// retrieve stored detail/summary setting from localStorage
		var storeKey = 'plugin-summary-reports-items-list-status';
		var status = localStorage.getItem(storeKey);
		if(status === undefined || status !== 'summary') status = 'details';

		// if summary, trigger a click
		if(status === 'summary') {
			$j('#reports-list .btn.details-list').trigger('click');
		}

		// add an event handler on clicking the buttons to update localStorage
		$j('#reports-list .btn.details-list, #reports-list .btn.summary-list').click(function() {
			localStorage.setItem(storeKey, 'summary');
			if($j('#reports-list .btn.details-list').hasClass('active')) {
				localStorage.setItem(storeKey, 'details');
			}
		})
	}

	var fieldsOf = function(tn, aliasNum) {
		if(aliasNum === undefined) aliasNum = '';
		var fieldsList = [], parentTables = [];

		var table = project.getTable(tn);
		for(var i = 0; i < table.field.length; i++) {
			var fn = table.field[i].name;
			fieldsList.push('`' + tn + aliasNum + '`.`' + table.field[i].name + '`');
			if(!aliasNum && project.isLookupField(tn, fn)) {
				// if no aliasNum this means we're on the main table
				// so let's check for parent table of current field and append its fields
				var pt = table.field[i].parentTable;
				if(parentTables.indexOf(pt) == -1) parentTables.push(pt);
			}
		}

		for(i = 0; i < parentTables.length; i++) {
			fieldsList = fieldsList.concat(fieldsOf(parentTables[i], '1'));
		}

		return fieldsList;
	}

	var populateWhereBuilder = function() {
		// populate fields list
		$j('.available-fields-list').empty();
		var fieldsList = fieldsOf(AppGiniPlugin.table_name);
		for(var i = 0; i < fieldsList.length; i++) {
			$j('<div class="field pointer"></div>')
				.html(fieldsList[i])
				.appendTo('.available-fields-list');
		}
		
		// populate custom WHERE copy
		var cwCopy = $j('#custom-where-copy');
		cwCopy.val($j('#custom-where').val().trim());

		// if custom WHERE copy changes, sync
		if(!cwCopy.hasClass('change-handler-added')) {
			cwCopy.on('change', function() {
				$j('#custom-where').val($j(this).val().trim());
			}).addClass('change-handler-added');
		}
	}

	/* Triggring Add and Edit Modal Events */
 	$j('#report-modal')
 	.on('change', '#group-table', function() {
 		var tn = $j('#group-table').val() || AppGiniPlugin.table_name;
		populateLabels(tn);
	}).on('change', '#how-to-summarize', function() {
		/* Change How to summarize event*/
		displaySummaryControls({
			function: $j(this).val(),
			field: $j('#summarized-value').val(),
			userTriggered: true
		});
	}).on('click', '#single-table', function() {
		/* on user-initiated toggling of #single-table, update display of grouping controls */
		displayGroupingControls({ userTriggered: true });
	}).on('keyup', '#report-title', function() {
		if($j(this).val() != '') $j('#title-validation').addClass('hidden');
	}).on('change', '#label', function() {
		if($j(this).val() != '') $j('#label-validation').addClass('hidden');
	}).on('change', '#how-to-summarize, #summarized-value', function() {
		if($j('#summarized-value').val() != '' || $j('#how-to-summarize').val() == 'count')
			$j('#what-to-summarize-required').addClass('hidden');
	}).on('submit', function(e) {
		e.preventDefault();
		$j('.save-report').click();
	}).on('click', '.minimalist-invoker', function() {
		minimalistReportEditor(!$j(this).hasClass('active'));
	}).on('click', '.save-report', function() {
		AppGiniPlugin.debug('$j(".save-report").click');

		/* Validating report title required */
		if($j("#report-title").val() == '') {
			$j('#title-validation').removeClass('hidden');
			$j("#report-title").focus();
			return;
		}
		
		/* #how-to-summarize is not 'Count' and no #summarized-value */
		if($j('#summarized-value').val() == '' && $j('#how-to-summarize').val() != 'count'){
			$j('#what-to-summarize-required').removeClass('hidden');
			$j('#summarized-value').focus();
			return;
		}
		
		/* Don't allow empty label field */
		if($j('#label').val() == ''){
			$j('#label-validation').removeClass('hidden');
			$j('#label').focus();
			return;
		}
		
		if($j("#group-table").val() == '') {
			var label_field = $j("#label").val();
			if(project.isLookupField($j("#table-index").val(), label_field) == false){
				$j("#look-up-table, #look-up-value").val(''); 
			}else{
				//get lookup table
				var lookup_table = project.getLookupTableName($j("#table-index").val(), label_field);
				$j("#look-up-table").val(lookup_table);
				
				//get lookup value
				var lookup_value = project.getParentCaptionFieldName($j("#table-index").val(), label_field);
				$j("#look-up-value").val(lookup_value);
			}
		}
	 
		if($j("#group-table").val()) {
			$j("#first-caption").val(
				project.getCaption(
					$j("#group-table").val(), 
					$j("#label").val()
				)
			);
		} else {
			$j("#first-caption").val(
				project.getCaption(
					$j("#table-index").val(), 
					$j("#label").val()
				)
			);
		}
		
		var howToSummarize = $j("#how-to-summarize").val();
		$j('#second-caption').val(
			summaryFunctions[howToSummarize] + 
			" of " + (
				howToSummarize == 'count' ?
					project.getCaption(AppGiniPlugin.table_name)
				: /* else */
					project.getCaption(
						AppGiniPlugin.table_name,
						$j('#summarized-value').val()
					)
			)
		);

		$j('#label-field-index').val(
			parseInt(
				project.getFieldIndex(
					AppGiniPlugin.table_index, 
					$j('#label').val()
				)
			) + 1
		);

		$j('#date-field-index').val(
			parseInt(
				project.getFieldIndex(
					AppGiniPlugin.table_index, 
					$j('#date-field').val()
				)
			) + 1
		);

		$j('.save-report').prop('disabled', true).text('Please wait ...');

		$j.ajax({
			type: 'POST',
			url: 'update_node_ajax.php?axp=' + axp_md5 + '&table_name=' + AppGiniPlugin.table_name,
			data: $j("#report-editor-form").serialize(),
			success: function(data) {
				AppGiniPlugin.debug('update_node_ajax.php: success', JSON.stringify(data));

				// TODO: to preserve consistency, returned data should include
				//       the table name and the reports (data.tableName, data.reports)
				//       and we should use returned table name rather than selected one.
				var reports = JSON.parse(data);
				setReports(AppGiniPlugin.table_name, reports);
				AppGiniPlugin.reportsList.items(reports);
				updateReportsCount();
			},
			complete: function() {
				AppGiniPlugin.debug('update_node_ajax.php: complete');

				$j('.save-report').prop('disabled', false).text('Save');
				$j('#report-modal').modal('hide');
			}
		});

	}).on('hidden.bs.modal', function () {
		document.getElementById("report-editor-form").reset();
		$j("#report-id").val('');
		$j("#report-hash").val('');
		$j('.carousel').carousel(0);
	}).on('shown.bs.modal', function() {
		$j('#report-title').focus();
		$j('.carousel').carousel({ keyboard: false, interval: false }).carousel(0);
	}).on('click', '.help-launcher', function() {
		$j('.carousel').carousel(1);
	}).on('click', '.help-closer', function() {
		$j('.carousel').carousel(0);
	}).on('click', '.help-next, .help-prev', function() {
		$j('.carousel').carousel($j(this).data('goto'));
	}).on('click', '.where-builder', function(e) {
		e.preventDefault();
		populateWhereBuilder();
		$j('.carousel').carousel($j(this).data('goto'));
	}).on('click', '.available-fields-list .field', function() {
		// copy clicked field into cursor position inside #custom-where-copy
		var fn = $j(this).text();
		$j('#custom-where-copy').get(0).setRangeText(fn);
		$j('#custom-where-copy').trigger('change').focus();
	});

	// clear all summary reports of this project
	$j('#clear-summary-reports').click(function() {
		if(!confirm(
			'This would remove ALL summary reports defined in ' +
			'ALL TABLES of this project.\n\n' +
			'This might be useful if you\'re seeing unexpected behavior, ' +
			'or have been experimenting with reports, and would like to ' +
			'reset your project and restart defining reports from scratch.\n\n' +
			'A backup copy of the project will be made first before clearing ' +
			'reports, just in case you want to change your mind later :)'
		)) return;

		// disable all buttons and links
		$j('.btn').prop('disabled', true);
		$j('a').click(function(e) { e.preventDefault(); });

		// send clear reports request and when done, reload the page
		$j.ajax({
			url: 'ajax-cleanup-project.php',
			data: {	axp: AppGiniPlugin.axp_md5 },
			complete: function() { location.reload(); }
		});
	})

	// list of reports itemsList
	AppGiniPlugin.reportsList = AppGiniPlugin.itemsList({
		container: '#reports-list',
		noItemsText: 'This table has no reports configured yet.',
		addLabel: 'Add Report',
		add: function() {
			var table_caption = project.getCaption(AppGiniPlugin.table_index);

			$j('#report-modal').modal();
			
			resetReportForm();
			$j("#table-index").val(AppGiniPlugin.table_index);

			/* Add report window title  */
			$j("#modal-title").html('Create a new <span class="text-info">' + table_caption + '</span> report');
			
			/* Fill the rest of fields */
			populateDateFields(AppGiniPlugin.table_name);

			minimalistReportEditor();
		},

		/* function to retrieve item id from item */
		itemId: function(item) { return item.report_hash; },

		/* function to retrieve item title from item */
		itemTitle: function(item) {
			var title = item.title;

			if(typeof(item.override_permissions) != 'undefined') {
				if(item.override_permissions)
					title += ' <i class="glyphicon glyphicon-eye-open text-danger" title="Show all records (overriding user permissions)"></i>';
			}

			if(typeof(item.custom_where) != 'undefined') {
				if(item.custom_where.trim())
					title += ' <i class="glyphicon glyphicon-tasks" title="Has a custom WHERE"></i>';
			}
			
			return title; 
		},

		/* handler for [edit] button */
		edit: function(id) {
			$j('#report-modal').modal();

			resetReportForm();		
			var report = AppGiniPlugin.reportsList.itemById(id);
			
			$j("#table-index").val(AppGiniPlugin.table_index);
			$j("#report-id").val(id);
			$j('#report-hash').val(report.report_hash);
			$j("#report-title").val(report.title);
			$j("#group-array").val(report.group_array.join('\n'));
			$j("#custom-where").val(report.custom_where);
			$j('#override-permissions').prop('checked', report.override_permissions);
			
			/* Set report window title  */
			$j("#modal-title").html('Edit <span class="text-info">' + report.title + '</span> report');

			/* Populate date fields */		
			populateDateFields(AppGiniPlugin.table_index, report.date_field);
			
			displayGroupingControls({
				table: AppGiniPlugin.table_name,
				groupTable: report.parent_table,
				labelField: report.label
			});

			displaySummaryControls({
				function: report.group_function,
				field: report.group_function_field
			});

			/* report sections */
			$j('#data-table-section').prop('checked', report.data_table_section);
			$j('#pie-chart-section').prop('checked', report.piechart_section);
			$j('#bar-chart-section').prop('checked', report.barchart_section);

			/* report header and footer */
			$j('#report-header-url').val(report.report_header_url);
			$j('#report-footer-url').val(report.report_footer_url);

			minimalistReportEditor();
		},

		/* handler for [delete] button */
		delete: function(id) {
			var report = AppGiniPlugin.reportsList.itemById(id);
			var table_index = AppGiniPlugin.table_index;
			
			$j('.btn[data-id="' + id + '"]')
				.prop('disabled', true)
				.parents('.panel-success')
				.addClass('panel-danger')
				.removeClass('panel-success');
		 	$j.ajax({
				type: "POST",
				url: 'delete_node_ajax.php',
				data: { 
					axp: axp_md5, 
					table_name: AppGiniPlugin.table_name,
					node_index: id
				},
				success: function(data) {
					var reports = JSON.parse(data);
					// TODO: to preserve consistency, returned data should include
					//       the table name and the reports (data.tableName, data.reports)
					//       and we should use returned table name rather than selected one.
					setReports(AppGiniPlugin.table_name, reports);
					if(table_index == AppGiniPlugin.table_index) {
						AppGiniPlugin.reportsList.items(reports);
					}
					updateReportsCount();
				},
				error: function() {
					AppGiniPlugin.reportsList.redraw();
				}
			});
		},
		deleteConfirmation: 'Are you sure you want to delete this report?',

		itemLeft: function(report) {
			return '<div class="paper-mocker">' +
				(report.report_header_url ? '<img src="' + encodeURI(report.report_header_url) + '" class="img-responsive" alt="Loading report header image ...">' : '') +
				(report.data_table_section ? '<img src="images/summary-reports-data-table-section.png" class="img-responsive">' : '') +
				(report.barchart_section ? '<img src="images/summary-reports-bar-chart-section.png" class="img-responsive">' : '') +
				(report.piechart_section ? '<img src="images/summary-reports-pie-chart-section.png" class="img-responsive">' : '') +
				(report.report_footer_url ? '<img src="' + encodeURI(report.report_footer_url) + '" class="img-responsive" alt="Loading report footer image ...">' : '') +
			'</div>';
		},

		itemDetails: function(report) {
			AppGiniPlugin.debug('itemList.itemDetails', JSON.stringify(report));
			var project = AppGiniPlugin.project(AppGiniPlugin.prj);
			var report_config_values = {};
			var title = report.title;
			var ctIndex = AppGiniPlugin.table_index;
			/* group table caption, label field caption */
			var gtc = '', lfc = '';
			/* grouping function */
			var gf = summaryFunctions[report.group_function];
			/* selected table caption */
			var stc = project.getCaption(ctIndex);
			
			gtc = stc;
			lfc = project.getCaption(ctIndex, report.label);

			if(report.parent_table) {
				gtc = project.getCaption(report.parent_table);
				ctIndex = project.getTableIndex(report.parent_table);
				lfc = project.getCaption(ctIndex, report.label);
			}
			
			
			report_config_values["How / what to summarize?"] = (
				gf != summaryFunctions.count ?
					gf + ' of <code>' + stc + '</code> . <code>' + 
					project.getCaption(ctIndex, report.group_function_field) +
					'</code>'
				:
					'Count of records of <code>' + stc + '</code> table'
			);
			
			report_config_values["Grouped by"] = '<code>' + gtc + '</code> . <code>' + lfc + '</code>';

			report_config_values["Date field used to filter the report"] = 'No filtering by dates';
			if(report.date_field) {
				report_config_values["Date field used to filter the report"] = '' + 
					'<code>' + stc + '</code> . <code>' + project.getCaption(ctIndex, report.date_field) + '</code>';
			}

			report_config_values["Which groups can access this report?"] = '<span class="text-danger text-bold">All groups</span>';
			if(report.group_array.length)
				report_config_values["Which groups can access this report?"] = '<code>' + report.group_array.join('</code> <code>') + '</code>';
				
			return report_config_values;
		}
	});

	// build report editor form
	buildReportForm();

	// on page load, cache table ancestors for all tables, one table at a time
	var tables = project.get().table;
	for(var ti = 0; ti < tables.length; ti++) {
		(function(tableName, delay) {
			setTimeout(function() { getTableAncestors(tableName); }, delay);
		})(tables[ti].name, (ti + 1) * 1000);
	}

	// move focus to the first table
	setTimeout(function() { $j('#tables-list a:first').focus() }, 1000);

	updateReportsCount();

	applyAndPreserveItemsListDetailLevel();
})
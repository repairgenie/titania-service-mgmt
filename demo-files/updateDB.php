<?php
	// check this file's MD5 to make sure it wasn't called before
	$tenantId = Authentication::tenantIdPadded();
	$setupHash = __DIR__ . "/setup{$tenantId}.md5";

	$prevMD5 = @file_get_contents($setupHash);
	$thisMD5 = md5_file(__FILE__);

	// check if this setup file already run
	if($thisMD5 != $prevMD5) {
		// set up tables
		setupTable(
			'invoice', " 
			CREATE TABLE IF NOT EXISTS `invoice` ( 
				`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
				PRIMARY KEY (`id`),
				`code` VARCHAR(20) NULL,
				UNIQUE `code_unique` (`code`),
				`status` VARCHAR(20) NOT NULL DEFAULT 'Unpaid',
				`date_due` DATE NULL,
				`client` INT UNSIGNED NULL,
				`client_contact` INT UNSIGNED NULL,
				`client_address` INT UNSIGNED NULL,
				`client_phone` INT UNSIGNED NULL,
				`client_email` INT UNSIGNED NULL,
				`client_website` INT UNSIGNED NULL,
				`client_comments` INT UNSIGNED NULL,
				`subtotal` DECIMAL(9,2) NULL,
				`discount` DECIMAL(4,2) NULL DEFAULT '0',
				`tax` DECIMAL(9,2) NULL DEFAULT '0',
				`total` DECIMAL(9,2) NULL,
				`comments` TEXT NULL,
				`invoice_template` VARCHAR(100) NULL,
				`created` VARCHAR(200) NULL,
				`last_updated` VARCHAR(200) NULL
			) CHARSET utf8"
		);
		setupIndexes('invoice', ['client',]);

		setupTable(
			'clients', " 
			CREATE TABLE IF NOT EXISTS `clients` ( 
				`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
				PRIMARY KEY (`id`),
				`name` VARCHAR(200) NULL,
				UNIQUE `name_unique` (`name`),
				`contact` VARCHAR(255) NULL,
				`title` VARCHAR(40) NULL,
				`address` TEXT NULL,
				`city` VARCHAR(40) NULL,
				`country` VARCHAR(40) NULL,
				`phone` VARCHAR(100) NULL,
				`email` VARCHAR(80) NULL,
				`website` VARCHAR(200) NULL,
				`comments` TEXT NULL,
				`unpaid_sales` DECIMAL(10,2) NULL,
				`paid_sales` DECIMAL(10,2) NULL,
				`total_sales` DECIMAL(10,2) NULL
			) CHARSET utf8"
		);

		setupTable(
			'item_prices', " 
			CREATE TABLE IF NOT EXISTS `item_prices` ( 
				`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
				PRIMARY KEY (`id`),
				`item` INT UNSIGNED NULL,
				`price` DECIMAL(10,2) NULL DEFAULT '0.00',
				`date` DATE NULL
			) CHARSET utf8"
		);
		setupIndexes('item_prices', ['item',]);

		setupTable(
			'invoice_items', " 
			CREATE TABLE IF NOT EXISTS `invoice_items` ( 
				`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
				PRIMARY KEY (`id`),
				`invoice` INT UNSIGNED NULL,
				`item` INT UNSIGNED NULL,
				`current_price` INT UNSIGNED NULL,
				`catalog_price` DECIMAL(10,2) UNSIGNED NULL,
				`unit_price` DECIMAL(10,2) UNSIGNED NOT NULL,
				`qty` DECIMAL(9,3) NULL DEFAULT '1',
				`price` DECIMAL(9,2) NULL
			) CHARSET utf8"
		);
		setupIndexes('invoice_items', ['invoice','item',]);

		setupTable(
			'items', " 
			CREATE TABLE IF NOT EXISTS `items` ( 
				`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
				PRIMARY KEY (`id`),
				`item_description` TEXT NULL,
				`unit_price` DECIMAL(10,2) NULL
			) CHARSET utf8"
		);

		setupTable(
			'workorders', " 
			CREATE TABLE IF NOT EXISTS `workorders` ( 
				`wo_ID` INT NOT NULL AUTO_INCREMENT,
				PRIMARY KEY (`wo_ID`),
				`wo_createdby` VARCHAR(40) NULL,
				`wo_datecreated` VARCHAR(40) NULL,
				`wo_Status` VARCHAR(64) NOT NULL,
				`wo_assignedto` INT NULL,
				`wo_client` INT UNSIGNED NOT NULL,
				`wo_ticket` VARCHAR(128) NULL,
				`wo_asset` INT NULL,
				`wo_Title` VARCHAR(255) NOT NULL,
				`wo_Description` LONGTEXT NULL
			) CHARSET utf8"
		);
		setupIndexes('workorders', ['wo_assignedto','wo_client','wo_asset',]);

		setupTable(
			'techs', " 
			CREATE TABLE IF NOT EXISTS `techs` ( 
				`techID` INT NOT NULL AUTO_INCREMENT,
				PRIMARY KEY (`techID`),
				`techName` VARCHAR(40) NOT NULL,
				`techPhone` VARCHAR(40) NULL,
				`techEmail` VARCHAR(40) NULL,
				`techPosition` VARCHAR(64) NULL
			) CHARSET utf8"
		);

		setupTable(
			'assets', " 
			CREATE TABLE IF NOT EXISTS `assets` ( 
				`asset_ID` INT NOT NULL AUTO_INCREMENT,
				PRIMARY KEY (`asset_ID`),
				`asset_client` INT UNSIGNED NULL,
				`asset_type` VARCHAR(64) NOT NULL,
				`asset_mfr` VARCHAR(64) NOT NULL,
				`asset_model` VARCHAR(64) NULL,
				`asset_serial` VARCHAR(128) NULL,
				`asset_IMEI` VARCHAR(128) NULL
			) CHARSET utf8"
		);
		setupIndexes('assets', ['asset_client',]);

		setupTable(
			'workordernotes', " 
			CREATE TABLE IF NOT EXISTS `workordernotes` ( 
				`wonote_ID` INT NOT NULL AUTO_INCREMENT,
				PRIMARY KEY (`wonote_ID`),
				`wonote_wo` INT NOT NULL,
				`wonote_note` LONGTEXT NOT NULL,
				`wonote_author` VARCHAR(40) NULL,
				`wonote_timestamp` VARCHAR(40) NULL,
				`wonote_editor` VARCHAR(40) NULL,
				`wonote_editorts` VARCHAR(40) NULL
			) CHARSET utf8"
		);
		setupIndexes('workordernotes', ['wonote_wo',]);

		setupTable(
			'technotes', " 
			CREATE TABLE IF NOT EXISTS `technotes` ( 
				`technote_ID` INT NOT NULL AUTO_INCREMENT,
				PRIMARY KEY (`technote_ID`),
				`technote_tech` INT NOT NULL,
				`technote_note` LONGTEXT NOT NULL,
				`technote_author` VARCHAR(64) NULL,
				`technote_timestamp` VARCHAR(64) NULL,
				`technote_editor` VARCHAR(64) NULL,
				`technote_editorts` VARCHAR(64) NULL
			) CHARSET utf8"
		);
		setupIndexes('technotes', ['technote_tech',]);

		setupTable(
			'tblwopubstatus', " 
			CREATE TABLE IF NOT EXISTS `tblwopubstatus` ( 
				`wopub_ID` INT NOT NULL AUTO_INCREMENT,
				PRIMARY KEY (`wopub_ID`),
				`wopub_WO` INT NULL,
				`wopub_Updated` VARCHAR(40) NULL,
				`wopub_status` VARCHAR(40) NULL,
				`wopub_Comments` MEDIUMTEXT NULL
			) CHARSET utf8"
		);
		setupIndexes('tblwopubstatus', ['wopub_WO',]);

		setupTable(
			'asset_notes', " 
			CREATE TABLE IF NOT EXISTS `asset_notes` ( 
				`assetnote_ID` INT NOT NULL AUTO_INCREMENT,
				PRIMARY KEY (`assetnote_ID`),
				`assetnote_asset` INT NOT NULL,
				`assetnote_note` LONGTEXT NOT NULL,
				`assetnote_author` VARCHAR(40) NULL,
				`assetnote_timestamp` VARCHAR(40) NULL,
				`assetnote_editor` VARCHAR(40) NULL,
				`assetnote_editorts` VARCHAR(40) NULL
			) CHARSET utf8"
		);
		setupIndexes('asset_notes', ['assetnote_asset',]);

		setupTable(
			'call_logs', " 
			CREATE TABLE IF NOT EXISTS `call_logs` ( 
				`call_ID` INT NOT NULL AUTO_INCREMENT,
				PRIMARY KEY (`call_ID`),
				`call_datetime` VARCHAR(40) NULL,
				`call_loggedby` VARCHAR(40) NULL,
				`call_client` INT UNSIGNED NULL,
				`call_workorder` INT NULL,
				`call_asset` INT NULL,
				`call_invoice` INT UNSIGNED NULL,
				`call_logentry` LONGTEXT NULL
			) CHARSET utf8"
		);
		setupIndexes('call_logs', ['call_client','call_workorder','call_asset','call_invoice',]);

		setupTable(
			'call_notes', " 
			CREATE TABLE IF NOT EXISTS `call_notes` ( 
				`callnote_call` INT NULL,
				`callnote_ID` INT NOT NULL AUTO_INCREMENT,
				PRIMARY KEY (`callnote_ID`),
				`callnote_datetime` VARCHAR(40) NULL,
				`callnote_loggedby` VARCHAR(40) NULL,
				`callnote_note` LONGTEXT NULL
			) CHARSET utf8"
		);
		setupIndexes('call_notes', ['callnote_call',]);



		// save MD5
		@file_put_contents($setupHash, $thisMD5);
	}


	function setupIndexes($tableName, $arrFields) {
		if(!is_array($arrFields) || !count($arrFields)) return false;

		foreach($arrFields as $fieldName) {
			if(!$res = @db_query("SHOW COLUMNS FROM `$tableName` like '$fieldName'")) continue;
			if(!$row = @db_fetch_assoc($res)) continue;
			if($row['Key']) continue;

			@db_query("ALTER TABLE `$tableName` ADD INDEX `$fieldName` (`$fieldName`)");
		}
	}


	function setupTable($tableName, $createSQL = '', $arrAlter = '') {
		global $Translation;
		$oldTableName = '';
		ob_start();

		echo '<div style="padding: 5px; border-bottom:solid 1px silver; font-family: verdana, arial; font-size: 10px;">';

		// is there a table rename query?
		if(is_array($arrAlter)) {
			$matches = [];
			if(preg_match("/ALTER TABLE `(.*)` RENAME `$tableName`/i", $arrAlter[0], $matches)) {
				$oldTableName = $matches[1];
			}
		}

		if($res = @db_query("SELECT COUNT(1) FROM `$tableName`")) { // table already exists
			if($row = @db_fetch_array($res)) {
				echo str_replace(['<TableName>', '<NumRecords>'], [$tableName, $row[0]], $Translation['table exists']);
				if(is_array($arrAlter)) {
					echo '<br>';
					foreach($arrAlter as $alter) {
						if($alter != '') {
							echo "$alter ... ";
							if(!@db_query($alter)) {
								echo '<span class="label label-danger">' . $Translation['failed'] . '</span>';
								echo '<div class="text-danger">' . $Translation['mysql said'] . ' ' . db_error(db_link()) . '</div>';
							} else {
								echo '<span class="label label-success">' . $Translation['ok'] . '</span>';
							}
						}
					}
				} else {
					echo $Translation['table uptodate'];
				}
			} else {
				echo str_replace('<TableName>', $tableName, $Translation['couldnt count']);
			}
		} else { // given tableName doesn't exist

			if($oldTableName != '') { // if we have a table rename query
				if($ro = @db_query("SELECT COUNT(1) FROM `$oldTableName`")) { // if old table exists, rename it.
					$renameQuery = array_shift($arrAlter); // get and remove rename query

					echo "$renameQuery ... ";
					if(!@db_query($renameQuery)) {
						echo '<span class="label label-danger">' . $Translation['failed'] . '</span>';
						echo '<div class="text-danger">' . $Translation['mysql said'] . ' ' . db_error(db_link()) . '</div>';
					} else {
						echo '<span class="label label-success">' . $Translation['ok'] . '</span>';
					}

					if(is_array($arrAlter)) setupTable($tableName, $createSQL, false, $arrAlter); // execute Alter queries on renamed table ...
				} else { // if old tableName doesn't exist (nor the new one since we're here), then just create the table.
					setupTable($tableName, $createSQL, false); // no Alter queries passed ...
				}
			} else { // tableName doesn't exist and no rename, so just create the table
				echo str_replace("<TableName>", $tableName, $Translation["creating table"]);
				if(!@db_query($createSQL)) {
					echo '<span class="label label-danger">' . $Translation['failed'] . '</span>';
					echo '<div class="text-danger">' . $Translation['mysql said'] . db_error(db_link()) . '</div>';

					// create table with a dummy field
					@db_query("CREATE TABLE IF NOT EXISTS `$tableName` (`_dummy_deletable_field` TINYINT)");
				} else {
					echo '<span class="label label-success">' . $Translation['ok'] . '</span>';
				}
			}

			// set Admin group permissions for newly created table if membership_grouppermissions exists
			if($ro = @db_query("SELECT COUNT(1) FROM `membership_grouppermissions`")) {
				// get Admins group id
				$ro = @db_query("SELECT `groupID` FROM `membership_groups` WHERE `name`='Admins'");
				if($ro) {
					$adminGroupID = intval(db_fetch_row($ro)[0]);
					if($adminGroupID) @db_query("INSERT IGNORE INTO `membership_grouppermissions` SET
						`groupID`='$adminGroupID',
						`tableName`='$tableName',
						`allowInsert`=1, `allowView`=1, `allowEdit`=1, `allowDelete`=1
					");
				}
			}
		}

		echo '</div>';

		$out = ob_get_clean();
		if(defined('APPGINI_SETUP') && APPGINI_SETUP) echo $out;
	}

<?php
// This script and data application were generated by AppGini 22.14
// Download AppGini for free from https://bigprof.com/appgini/download/

	include_once(__DIR__ . '/lib.php');

	handle_maintenance();

	header('Content-type: text/javascript; charset=' . datalist_db_encoding);

	$table_perms = getTablePermissions('ca');
	if(!$table_perms['access']) die('// Access denied!');

	$mfk = Request::val('mfk');
	$id = makeSafe(Request::val('id'));
	$rnd1 = intval(Request::val('rnd1')); if(!$rnd1) $rnd1 = '';

	if(!$mfk) {
		die('// No js code available!');
	}

	switch($mfk) {

		case 'client':
			if(!$id) {
				?>
				$j('#client_contact<?php echo $rnd1; ?>').html('&nbsp;');
				$j('#client_address<?php echo $rnd1; ?>').html('&nbsp;');
				$j('#client_phone<?php echo $rnd1; ?>').html('&nbsp;');
				$j('#client_email<?php echo $rnd1; ?>').html('&nbsp;');
				$j('#client_website<?php echo $rnd1; ?>').html('&nbsp;');
				$j('#client_comments<?php echo $rnd1; ?>').html('&nbsp;');
				<?php
				break;
			}
			$res = sql("SELECT `clients`.`id` as 'id', `clients`.`name` as 'name', `clients`.`contact` as 'contact', `clients`.`title` as 'title', `clients`.`address` as 'address', `clients`.`city` as 'city', `clients`.`country` as 'country', CONCAT_WS('-', LEFT(`clients`.`phone`,3), MID(`clients`.`phone`,4,3), RIGHT(`clients`.`phone`,4)) as 'phone', `clients`.`email` as 'email', `clients`.`website` as 'website', `clients`.`comments` as 'comments', `clients`.`unpaid_sales` as 'unpaid_sales', `clients`.`paid_sales` as 'paid_sales', `clients`.`total_sales` as 'total_sales' FROM `clients`  WHERE `clients`.`id`='{$id}' limit 1", $eo);
			$row = db_fetch_assoc($res);
			?>
			$j('#client_contact<?php echo $rnd1; ?>').html('<?php echo addslashes(str_replace(["\r", "\n"], '', safe_html($row['contact']))); ?>&nbsp;');
			$j('#client_address<?php echo $rnd1; ?>').html('<?php echo addslashes(str_replace(["\r", "\n"], '', safe_html($row['address']))); ?>&nbsp;');
			$j('#client_phone<?php echo $rnd1; ?>').html('<?php echo addslashes(str_replace(["\r", "\n"], '', safe_html($row['phone']))); ?>&nbsp;');
			$j('#client_email<?php echo $rnd1; ?>').html('<?php echo addslashes(str_replace(["\r", "\n"], '', safe_html($row['email']))); ?>&nbsp;');
			$j('#client_website<?php echo $rnd1; ?>').html('<?php echo addslashes(str_replace(["\r", "\n"], '', safe_html($row['website']))); ?>&nbsp;');
			$j('#client_comments<?php echo $rnd1; ?>').html('<?php echo addslashes(str_replace(["\r", "\n"], '', safe_html($row['comments']))); ?>&nbsp;');
			<?php
			break;


	}

?>
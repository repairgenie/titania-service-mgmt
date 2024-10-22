<?php
	$rdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $rdata)));
	$jdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $jdata)));
?>
<script>
	$j(function() {
		var tn = 'workorders';

		/* data for selected record, or defaults if none is selected */
		var data = {
			wo_assignedto: <?php echo json_encode(['id' => $rdata['wo_assignedto'], 'value' => $rdata['wo_assignedto'], 'text' => $jdata['wo_assignedto']]); ?>,
			wo_client: <?php echo json_encode(['id' => $rdata['wo_client'], 'value' => $rdata['wo_client'], 'text' => $jdata['wo_client']]); ?>,
			wo_asset: <?php echo json_encode(['id' => $rdata['wo_asset'], 'value' => $rdata['wo_asset'], 'text' => $jdata['wo_asset']]); ?>
		};

		/* initialize or continue using AppGini.cache for the current table */
		AppGini.cache = AppGini.cache || {};
		AppGini.cache[tn] = AppGini.cache[tn] || AppGini.ajaxCache();
		var cache = AppGini.cache[tn];

		/* saved value for wo_assignedto */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'wo_assignedto' && d.id == data.wo_assignedto.id)
				return { results: [ data.wo_assignedto ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for wo_client */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'wo_client' && d.id == data.wo_client.id)
				return { results: [ data.wo_client ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for wo_asset */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'wo_asset' && d.id == data.wo_asset.id)
				return { results: [ data.wo_asset ], more: false, elapsed: 0.01 };
			return false;
		});

		cache.start();
	});
</script>


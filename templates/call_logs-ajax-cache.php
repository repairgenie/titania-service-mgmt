<?php
	$rdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $rdata)));
	$jdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $jdata)));
?>
<script>
	$j(function() {
		var tn = 'call_logs';

		/* data for selected record, or defaults if none is selected */
		var data = {
			call_client: <?php echo json_encode(['id' => $rdata['call_client'], 'value' => $rdata['call_client'], 'text' => $jdata['call_client']]); ?>,
			call_workorder: <?php echo json_encode(['id' => $rdata['call_workorder'], 'value' => $rdata['call_workorder'], 'text' => $jdata['call_workorder']]); ?>,
			call_asset: <?php echo json_encode(['id' => $rdata['call_asset'], 'value' => $rdata['call_asset'], 'text' => $jdata['call_asset']]); ?>,
			call_invoice: <?php echo json_encode(['id' => $rdata['call_invoice'], 'value' => $rdata['call_invoice'], 'text' => $jdata['call_invoice']]); ?>
		};

		/* initialize or continue using AppGini.cache for the current table */
		AppGini.cache = AppGini.cache || {};
		AppGini.cache[tn] = AppGini.cache[tn] || AppGini.ajaxCache();
		var cache = AppGini.cache[tn];

		/* saved value for call_client */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'call_client' && d.id == data.call_client.id)
				return { results: [ data.call_client ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for call_workorder */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'call_workorder' && d.id == data.call_workorder.id)
				return { results: [ data.call_workorder ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for call_asset */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'call_asset' && d.id == data.call_asset.id)
				return { results: [ data.call_asset ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for call_invoice */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'call_invoice' && d.id == data.call_invoice.id)
				return { results: [ data.call_invoice ], more: false, elapsed: 0.01 };
			return false;
		});

		cache.start();
	});
</script>


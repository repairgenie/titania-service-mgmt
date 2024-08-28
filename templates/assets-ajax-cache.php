<?php
	$rdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $rdata)));
	$jdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $jdata)));
?>
<script>
	$j(function() {
		var tn = 'assets';

		/* data for selected record, or defaults if none is selected */
		var data = {
			asset_client: <?php echo json_encode(['id' => $rdata['asset_client'], 'value' => $rdata['asset_client'], 'text' => $jdata['asset_client']]); ?>
		};

		/* initialize or continue using AppGini.cache for the current table */
		AppGini.cache = AppGini.cache || {};
		AppGini.cache[tn] = AppGini.cache[tn] || AppGini.ajaxCache();
		var cache = AppGini.cache[tn];

		/* saved value for asset_client */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'asset_client' && d.id == data.asset_client.id)
				return { results: [ data.asset_client ], more: false, elapsed: 0.01 };
			return false;
		});

		cache.start();
	});
</script>


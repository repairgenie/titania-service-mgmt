<?php
	$rdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $rdata)));
	$jdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $jdata)));
?>
<script>
	$j(function() {
		var tn = 'asset_notes';

		/* data for selected record, or defaults if none is selected */
		var data = {
			assetnote_asset: <?php echo json_encode(['id' => $rdata['assetnote_asset'], 'value' => $rdata['assetnote_asset'], 'text' => $jdata['assetnote_asset']]); ?>
		};

		/* initialize or continue using AppGini.cache for the current table */
		AppGini.cache = AppGini.cache || {};
		AppGini.cache[tn] = AppGini.cache[tn] || AppGini.ajaxCache();
		var cache = AppGini.cache[tn];

		/* saved value for assetnote_asset */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'assetnote_asset' && d.id == data.assetnote_asset.id)
				return { results: [ data.assetnote_asset ], more: false, elapsed: 0.01 };
			return false;
		});

		cache.start();
	});
</script>


<?php
	$rdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $rdata)));
	$jdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $jdata)));
?>
<script>
	$j(function() {
		var tn = 'tblwopubstatus';

		/* data for selected record, or defaults if none is selected */
		var data = {
			wopub_WO: <?php echo json_encode(['id' => $rdata['wopub_WO'], 'value' => $rdata['wopub_WO'], 'text' => $jdata['wopub_WO']]); ?>
		};

		/* initialize or continue using AppGini.cache for the current table */
		AppGini.cache = AppGini.cache || {};
		AppGini.cache[tn] = AppGini.cache[tn] || AppGini.ajaxCache();
		var cache = AppGini.cache[tn];

		/* saved value for wopub_WO */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'wopub_WO' && d.id == data.wopub_WO.id)
				return { results: [ data.wopub_WO ], more: false, elapsed: 0.01 };
			return false;
		});

		cache.start();
	});
</script>


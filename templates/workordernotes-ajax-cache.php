<?php
	$rdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $rdata)));
	$jdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $jdata)));
?>
<script>
	$j(function() {
		var tn = 'workordernotes';

		/* data for selected record, or defaults if none is selected */
		var data = {
			wonote_wo: <?php echo json_encode(['id' => $rdata['wonote_wo'], 'value' => $rdata['wonote_wo'], 'text' => $jdata['wonote_wo']]); ?>
		};

		/* initialize or continue using AppGini.cache for the current table */
		AppGini.cache = AppGini.cache || {};
		AppGini.cache[tn] = AppGini.cache[tn] || AppGini.ajaxCache();
		var cache = AppGini.cache[tn];

		/* saved value for wonote_wo */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'wonote_wo' && d.id == data.wonote_wo.id)
				return { results: [ data.wonote_wo ], more: false, elapsed: 0.01 };
			return false;
		});

		cache.start();
	});
</script>


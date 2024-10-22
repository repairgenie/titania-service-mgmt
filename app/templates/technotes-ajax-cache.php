<?php
	$rdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $rdata)));
	$jdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $jdata)));
?>
<script>
	$j(function() {
		var tn = 'technotes';

		/* data for selected record, or defaults if none is selected */
		var data = {
			technote_tech: <?php echo json_encode(['id' => $rdata['technote_tech'], 'value' => $rdata['technote_tech'], 'text' => $jdata['technote_tech']]); ?>
		};

		/* initialize or continue using AppGini.cache for the current table */
		AppGini.cache = AppGini.cache || {};
		AppGini.cache[tn] = AppGini.cache[tn] || AppGini.ajaxCache();
		var cache = AppGini.cache[tn];

		/* saved value for technote_tech */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'technote_tech' && d.id == data.technote_tech.id)
				return { results: [ data.technote_tech ], more: false, elapsed: 0.01 };
			return false;
		});

		cache.start();
	});
</script>


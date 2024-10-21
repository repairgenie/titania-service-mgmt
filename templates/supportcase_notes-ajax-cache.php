<?php
	$rdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $rdata)));
	$jdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $jdata)));
?>
<script>
	$j(function() {
		var tn = 'supportcase_notes';

		/* data for selected record, or defaults if none is selected */
		var data = {
			sc_notecase: <?php echo json_encode(['id' => $rdata['sc_notecase'], 'value' => $rdata['sc_notecase'], 'text' => $jdata['sc_notecase']]); ?>
		};

		/* initialize or continue using AppGini.cache for the current table */
		AppGini.cache = AppGini.cache || {};
		AppGini.cache[tn] = AppGini.cache[tn] || AppGini.ajaxCache();
		var cache = AppGini.cache[tn];

		/* saved value for sc_notecase */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'sc_notecase' && d.id == data.sc_notecase.id)
				return { results: [ data.sc_notecase ], more: false, elapsed: 0.01 };
			return false;
		});

		cache.start();
	});
</script>


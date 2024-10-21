<?php
	$rdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $rdata)));
	$jdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $jdata)));
?>
<script>
	$j(function() {
		var tn = 'call_notes';

		/* data for selected record, or defaults if none is selected */
		var data = {
			callnote_call: <?php echo json_encode(['id' => $rdata['callnote_call'], 'value' => $rdata['callnote_call'], 'text' => $jdata['callnote_call']]); ?>
		};

		/* initialize or continue using AppGini.cache for the current table */
		AppGini.cache = AppGini.cache || {};
		AppGini.cache[tn] = AppGini.cache[tn] || AppGini.ajaxCache();
		var cache = AppGini.cache[tn];

		/* saved value for callnote_call */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'callnote_call' && d.id == data.callnote_call.id)
				return { results: [ data.callnote_call ], more: false, elapsed: 0.01 };
			return false;
		});

		cache.start();
	});
</script>


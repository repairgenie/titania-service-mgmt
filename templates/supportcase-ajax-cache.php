<?php
	$rdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $rdata)));
	$jdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $jdata)));
?>
<script>
	$j(function() {
		var tn = 'supportcase';

		/* data for selected record, or defaults if none is selected */
		var data = {
			case_client: <?php echo json_encode(['id' => $rdata['case_client'], 'value' => $rdata['case_client'], 'text' => $jdata['case_client']]); ?>,
			case_call: <?php echo json_encode(['id' => $rdata['case_call'], 'value' => $rdata['case_call'], 'text' => $jdata['case_call']]); ?>
		};

		/* initialize or continue using AppGini.cache for the current table */
		AppGini.cache = AppGini.cache || {};
		AppGini.cache[tn] = AppGini.cache[tn] || AppGini.ajaxCache();
		var cache = AppGini.cache[tn];

		/* saved value for case_client */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'case_client' && d.id == data.case_client.id)
				return { results: [ data.case_client ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for case_call */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'case_call' && d.id == data.case_call.id)
				return { results: [ data.case_call ], more: false, elapsed: 0.01 };
			return false;
		});

		cache.start();
	});
</script>


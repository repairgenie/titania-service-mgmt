<?php
	include(__DIR__ . '/header.php');
	
	echo $summary_reports->get_project([
		'header_nav' => true,
		'pre_upload' => file_get_contents(__DIR__ . '/video-link.html'),
		'redirect_to' => 'project.php'
	]);

	include(__DIR__ . "/footer.php");
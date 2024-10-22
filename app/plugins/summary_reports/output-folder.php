<?php
	include(__DIR__ . '/header.php');

	$axp_md5 = Request::val('axp');
	$projectFile = '';
	$xmlFile = $summary_reports->get_xml_file($axp_md5 , $projectFile);

	echo $summary_reports->header_nav();

	echo $summary_reports->breadcrumb([
		'index.php' => 'Projects',
		'project.php?axp=' . urlencode($axp_md5) => substr($projectFile, 0, -4),
		'' => 'Output folder'
	]);

	echo $summary_reports->show_select_output_folder([
		'next_page' => 'generate.php?axp=' . urlencode($axp_md5),
		'extra_options' => []
	]);

	include(__DIR__ . '/footer.php');
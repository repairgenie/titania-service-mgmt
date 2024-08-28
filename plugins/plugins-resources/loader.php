<?php
	@include(get_app_path() . '/lib.php');

	// autoloading plugin classes
	spl_autoload_register(function($class) {
		@include_once(__DIR__ . "/{$class}.php");
	});

	load_plugins_resources();


	function get_app_path() {
		return realpath(__DIR__ . '/../..');
	}

	function load_plugins_resources() {
		$base_dir = get_app_path();
		$plugins_dir = realpath(__DIR__ . '/..');
		$error_msgs = [];
		
		if(
			!is_readable("{$base_dir}/lib.php")
			|| !is_readable(__DIR__ . '/ProgressLog.php')
			|| !is_readable(__DIR__ . '/AppGiniPlugin.php')
		) $error_msgs[] = "The plugin was not installed correctly, you must put it inside the plugins folder under you main AppGini application folder.";
		
		$res = AppGiniPlugin::prepare_projects_folder();
		if($res !== true) $error_msgs[] = $res;
		
		if(!count($error_msgs)) return true;

		// show error page
		?><!DOCTYPE html>
		<html class="no-js">
			<head>
				<meta charset="<?php echo datalist_db_encoding; ?>">
				<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
				<meta name="description" content="">
				<meta name="viewport" content="width=device-width, initial-scale=1.0">

				<title>Plugin installed incorrectly!</title>
				
				<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">				
			</head>
			<body>
				<div class="container" style="margin-top: 5em;">
					<div class="panel panel-danger">
						<div class="panel-heading"><h3 class="panel-title">Error:</h3></div>
						<div class="panel-body">
							<p class="text-danger"><?php echo implode('<br>&bull; ', $error_msgs); ?></p>
						</div>
					</div>
				</div>
			</body>
		</html>

		<?php exit;
	}

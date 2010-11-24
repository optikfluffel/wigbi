<?php include "wigbi/wigbi.php"; ?><!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" >
	<head>
		<?php
			$cleanUp = array_key_exists("clean", $_GET);
			
			Wigbi::configFile($root . "tests/resources/config.ini");
			Wigbi::start();
			
			if ($cleanUp) {
		 		Wigbi::dbHandler()->query("DROP DATABASE " . Wigbi::dbHandler()->dbName());
			 
				foreach (glob("wigbi/plugins/data/*.php") as $file)
					unlink($file);
				foreach (glob("wigbi/plugins/ui/*.php") as $file)
					unlink($file);
				foreach (glob("wigbi/plugins/ui/*.js") as $file)
					unlink($file);
					
				unlink("wigbi/js/wigbi_dataPlugins.js");
				unlink("wigbi/js/wigbi_uiPlugins.js");
			}

			else {
				foreach (glob("plugins/data/*.*") as $file)
					copy($file, "wigbi/plugins/data/" . basename($file));
				foreach (glob("plugins/ui/*.*") as $file)
					copy($file, "wigbi/plugins/ui/" . basename($file));
				
				ob_start();
				Wigbi::start();
				ob_get_clean();
			}

			function initTests($cleanUp) {
				if ($cleanUp)
					return;
					//TODO: REPlace with iterating over real classes to ensure that they all are tested
				foreach (glob("tests/plugins/ui/*php") as $file)
					include($file);	
			}
		?>
		
		<script type="text/javascript">
			function addDone(elementId) { }
		</script>
		<script type="text/javascript" src="wigbi/bundle/js:tests/resources/jquery.corner.js,tests/resources/test.js"></script>
		<link rel="stylesheet" type="text/css" href="wigbi/bundle/css:tests/resources/test.css"></link>
	</head>
	<body>
		<div id="main">
			<div class="box toolbar">
				<a href="testUiPlugins.php">Retry</a> • <a href="testUiPlugins.php?clean=1">Finish</a>
			</div>
			<?php initTests($cleanUp); ?>
			<div class="box toolbar">
				<a href="testUiPlugins.php">Retry</a> • <a href="testUiPlugins.php?clean=1">Finish</a>
			</div>
		</div>
	</body>
</html>

<?php Wigbi::stop(); ?>
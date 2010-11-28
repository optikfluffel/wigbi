<?php include "wigbi/wigbi.php"; ?><!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" >
	<head>
		<?php
			$cleanUp = array_key_exists("clean", $_GET);
			
			include "test_shared.php";
							
			Wigbi::configFile($root . "tests/resources/config.ini");
			Wigbi::start();
			cleanUp();
			if (!$cleanUp)
				Wigbi::start();
			else
				addPlugins();
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
				<a href="test_ui.php">Retry</a> • <a href="test_ui.php?clean=1">Finish</a>
			</div>
			<?php
				if (!$cleanUp)
					foreach (glob("tests/plugins/ui/*php") as $file)
						include($file);
			?>
			<div class="box toolbar">
				<a href="test_ui.php">Retry</a> • <a href="test_ui.php?clean=1">Finish</a>
			</div>
		</div>
	</body>
</html>

<?php Wigbi::stop(); ?>
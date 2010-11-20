<?php include "wigbi/wigbi.php"; ?><!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" >
	<head>
		<?php
			Wigbi::configFile($root . "tests/resources/config.ini");
			
			$cleanUp = array_key_exists("clean", $_GET);
			
			function addPlugins() {
				foreach (glob("plugins/data/*.*") as $file)
					copy($file, "wigbi/plugins/data/" . basename($file));
				foreach (glob("plugins/ui/*.*") as $file)
					copy($file, "wigbi/plugins/ui/" . basename($file));
			}
			
			function deletePlugins() {
				foreach (glob("wigbi/plugins/data/*.*") as $file)
					unlink($file);
				foreach (glob("wigbi/plugins/ui/*.*") as $file)
					unlink($file);
			}
			
			function runTests($cleanUp) {
				if ($cleanUp)
					return;
					//TODO: REPlace with iterating over real classes to ensure that they all are tested
				foreach (glob("tests/plugins/ui/*php") as $file)
					include($file);	
			}
			
			deletePlugins();
			
			if (!$cleanUp)
			{
				addPlugins();
				Wigbi::start();
			}
		?>
	</head>
	<body>
		<?php runTests($cleanUp); ?>
		<h1 style="text-align:center">
			<a href="testUiPlugins.php">Try again</a>  <a href="testUiPlugins.php?clean=1">Finish</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		</h1>
		<div class="footer">&nbsp;</div>
	</body>
</html>

<?php Wigbi::stop(); ?>
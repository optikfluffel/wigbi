<?php include "wigbi/wigbi.php"; ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd" >

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" >
	<head>
		<?php
			$cleanUp = array_key_exists("clean", $_GET);
			$test_phpcore = true && !$cleanUp;
			$test_php = true && !$cleanUp;
			$test_dataPlugins = true && !$cleanUp;
			$test_js = false && !$cleanUp;
					
			include "test_shared.php";
			if ($test_phpcore || $test_php || $test_dataPlugins)
				require_once("resources/tools/SimpleTest/autorun.php");
			
			Wigbi::configFile("tests/resources/config.ini");
			Wigbi::start();
			cleanUp();
			if (!$cleanUp)
				Wigbi::start();
		?>
		
		<script type="text/javascript" src="wigbi/bundle/js:tests/resources/jquery.corner.js,tests/resources/test.js"></script>
		<link rel="stylesheet" type="text/css" href="wigbi/bundle/css:tests/resources/test.css"></link>
	</head>
	<body>
		<div id="main">
		
			<div class="box toolbar">
				<a href="test_php.php">Retry</a> • <a href="test_php.php?clean=1">Finish</a>
			</div
			
			<?php
		
				//Wigbi.PHP.Core ***********************
				if ($test_phpcore)
				{
					$test = new GroupTest("Wigbi.PHP.Core");
					foreach(glob("tests/php/core/*.php") as $file)
						require_once($file);
					foreach (glob("wigbi/php/wigbi/core/*.php") as $file)
						eval('$test->addTestCase(new ' . str_replace(".php", "", basename($file)) . 'Behavior());');
						
					print "<div class='box'>";
					$test->run(new HtmlReporter());
					print "</div>";
				}
				
				//Wigbi.PHP ****************************
				if ($test_php)
				{
					$test = new GroupTest("Wigbi.PHP");
					foreach(glob("tests/php/*.php") as $file)
						require_once($file);
					foreach (glob("wigbi/php/wigbi/*.php") as $file)
						eval('$test->addTestCase(new ' . str_replace(".php", "", basename($file)) . 'Behavior());');
					
					print "<div class='box'>";
					$test->run(new HtmlReporter());
					print "</div>";
				}
				
				//Wigbi.Plugins.Data *******************
				if ($test_dataPlugins)
				{
					addPlugins();
					
					$test = new GroupTest("Wigbi.Plugins.Data");
					foreach(glob("tests/plugins/data/*.php") as $file)
						require_once($file);
					foreach (glob("plugins/data/*.php") as $file)
						eval('$test->addTestCase(new ' . str_replace(".php", "", basename($file)) . 'Behavior());');
					
					print "<div class='box'>";
					$test->run(new HtmlReporter());
					print "</div>";
				}
			?>
			
			<div class="box toolbar">
				<a href="test_php.php">Retry</a> • <a href="test_php.php?clean=1">Finish</a>
			</div
	
			<?php Wigbi::stop(); ?>		
		
		</div>
	</body>
</html>
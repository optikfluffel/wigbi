<?php include "wigbi/wigbi.php"; ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd" >

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" >
	<head>
		<?php
			$cleanUp = array_key_exists("clean", $_GET);
			$test_phpcore = false && !$cleanUp;
			$test_php = false && !$cleanUp;
			$test_dataPlugins = false && !$cleanUp;
			$test_js = true && !$cleanUp;
			
			$files = array("wigbi/plugins/data/Rating.php", "wigbi/plugins/ui/LoginForm.php", "wigbi/plugins/ui/LoginForm.js", "wigbi/js/wigbi_dataPlugins.js", "wigbi/js/wigbi_uiPlugins.js");
			foreach ($files as $file)
				if (file_exists($file))
					unlink ($file);
					
			Wigbi::configFile("tests/resources/config.ini");
			Wigbi::start();
			Wigbi::dbHandler()->query("DROP DATABASE " . Wigbi::dbHandler()->dbName());
			Wigbi::start();
			
			if ($test_phpcore || $test_php || $test_dataPlugins)
				require_once("resources/tools/SimpleTest/autorun.php");
			
			function addPlugins() {
				ob_start();
				Wigbi::stop();
				foreach(glob("plugins/data/*.php") as $file)
					require_once($file);
				Wigbi::start();
				ob_end_clean();
			}
		?>
		
		<script type="text/javascript" src="wigbi/bundle/js:tests/resources/jquery.corner.js,tests/resources/test.js"></script>
		<link rel="stylesheet" type="text/css" href="wigbi/bundle/css:tests/resources/test.css"></link>
	</head>
	<body>
		<div id="main">
			
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
				
				
				//Add plugins for plugin and JS tests **
				addPlugins();
				
				
				//Wigbi.Plugins.Data *******************
				if ($test_dataPlugins)
				{
					$test = new GroupTest("Wigbi.Plugins.Data");
					foreach(glob("tests/plugins/data/*.php") as $file)
						require_once($file);
					foreach (glob("plugins/data/*.php") as $file)
						eval('$test->addTestCase(new ' . str_replace(".php", "", basename($file)) . 'Behavior());');
					
					print "<div class='box'>";
					$test->run(new HtmlReporter());
					print "</div>";
				}
	
				//Wigbi.JavaScript *********************
				if ($test_js) { ?>
					<link rel="stylesheet" href="http://github.com/jquery/qunit/raw/master/qunit/qunit.css" type="text/css" media="screen" />
					<script type="text/javascript" src="http://github.com/jquery/qunit/raw/master/qunit/qunit.js"></script>
					<script type="text/javascript">Wigbi._ajaxConfigFile = "tests/resources/config.ini";</script>
					<script type="text/javascript" src="wigbi/bundle/js:tests/js/core/,tests/js/"></script>
					
					<h1 id="qunit-header">Wigbi JavaScript classes</h1>
					<h2 id="qunit-banner"></h2>
					<h2 id="qunit-userAgent"></h2>
					<ol id="qunit-tests"></ol>
			
					<div id="test" style="display:none">
						<div id="test-element1"></div>
						<div id="test-element2"></div>
						<textarea title="foo bar" id="test-name">{"name":"foo bar"}</textarea>
					</div>
			<?php } ?>
			
			<div class="box toolbar">
				<a href="test.php">Retry</a> • <a href="test.php?clean=1">Finish</a>
			</div
	
			<?php Wigbi::stop(); ?>		
		
		</div>
	</body>
</html>
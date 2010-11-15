<?php include "wigbi/wigbi.php"; ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd" >

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" >
	<head>
		<?php
		
			//Start dummy Wigbi instance to initialize the framework
			Wigbi::configFile($root . "tests/resources/config.ini");
			Wigbi::start();
			
			$cleanUp = array_key_exists("clean", $_GET);
			$test_phpcore = true && !$cleanUp;
			$test_php = true && !$cleanUp;
			$test_dataPlugins = false && !$cleanUp;
			$test_js = false && !$cleanUp;
			
			function addPlugins() {
				ob_start();
				Wigbi::stop();
				copy("plugins/data/Rating.php", "wigbi/plugins/data/Rating.php");
				copy("plugins/ui/LoginForm.php", "wigbi/plugins/ui/LoginForm.php");
				copy("plugins/ui/LoginForm.js", "wigbi/plugins/ui/LoginForm.js");
				Wigbi::start();
				ob_end_clean();
			}
			
			function deletePlugins() {
				Wigbi::dbHandler()->query("DROP TABLE Ratings");
				$files = array("wigbi/plugins/data/Rating.php", "wigbi/plugins/ui/LoginForm.php", "wigbi/plugins/ui/LoginForm.js", "wigbi/js/wigbi_dataPlugins.js", "wigbi/js/wigbi_uiPlugins.js");
				foreach ($files as $file)
					if (file_exists($file))
						unlink ($file);
			} 
			
			deletePlugins();
	?>
	</head>
	<body>
		<?php
			
			//Require SimpleTest
			if ($test_phpcore || $test_php || $test_dataPlugins)
				require_once($root . "resources/tools/SimpleTest/autorun.php");
	
	
			//Wigbi.PHP.Core ***********************
			if ($test_phpcore)
			{
				$test = new GroupTest("Wigbi.PHP.Core");
				foreach(glob($root . "tests/php/core/*.php") as $file)
					require_once($file);
				foreach (glob($root . "wigbi/php/wigbi/core/*.php") as $file)
					eval('$test->addTestCase(new ' . str_replace(".php", "", basename($file)) . 'Behavior());');
				$test->run(new HtmlReporter());
				print "<br/>";
			}
			
			//Wigbi.PHP ****************************
			if ($test_php)
			{
				$test = new GroupTest("Wigbi.PHP");
				foreach(glob($root . "tests/php/*.php") as $file)
					require_once($file);
				foreach (glob($root . "wigbi/php/wigbi/*.php") as $file)
					eval('$test->addTestCase(new ' . str_replace(".php", "", basename($file)) . 'Behavior());');
				$test->run(new HtmlReporter());
				print "<br/>";	
			}
			
			//Wigbi.Plugins.Data *******************
			if ($test_dataPlugins)
			{
				$test = new GroupTest("Wigbi.Plugins.Data");
				foreach(glob($root . "plugins/data/*.php") as $file)
					require_once($file);
				foreach(glob($root . "tests/plugins/data/*.php") as $file)
					require_once($file);
				foreach (glob($root . "plugins/data/*.php") as $file)
					eval('$test->addTestCase(new ' . str_replace(".php", "", basename($file)) . 'Behavior());');
				$test->run(new HtmlReporter());
				print "<br/>";	
			}

			//Wigbi.JavaScript *********************
			if ($test_js)
			{
				addPlugins(); ?>
				<link rel="stylesheet" type="text/css" href="wigbi/bundle/css:tests/qunit/" />
				<script type="text/javascript">Wigbi._ajaxConfigFile = "tests/resources/config.ini";</script>
				<script type="text/javascript" src="wigbi/bundle/js:tests/qunit/,tests/js/core/,tests/js/"></script>
				
				<h1 id="qunit-header">Wigbi JavaScript classes</h1>
				<h2 id="qunit-banner"></h2>
				<h2 id="qunit-userAgent"></h2>
				<ol id="qunit-tests"></ol>
		
				<div id="test" style="display:none">
					<div id="test-element1"></div>
					<div id="test-element2"></div>
					<textarea title="foo bar" id="test-name">{"name":"foo bar"}</textarea>
				</div>
				
				<br/>
				
				<h1 style="text-align:center">
					<a href="">Try again</a>  <a href="">Finish</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				</h1>
				<div class="footer">&nbsp;</div>
				
		<?php } ?>
		
	</body>
</html>

<?php Wigbi::stop(); ?>
<?php
	include("includes/top.php");
	Wigbi::configFile("resources/config.ini");
	include("includes/middle.php");

	$test = new GroupTest("Wigbi.PHP.Core");
	foreach(glob("php/core/*.php") as $file)
		require_once($file);
	foreach (glob("../wigbi/php/wigbi/core/*.php") as $file)
		eval('$test->addTestCase(new ' . str_replace(".php", "", basename($file)) . 'Behavior());');
		
	print "<div class='box'>";
	$test->run(new HtmlReporter());
	print "</div>";
	
	include("includes/bottom.php");
?>
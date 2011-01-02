<?php
	require("includes/top.php");
	Wigbi::configFile("resources/config.ini");
	require("includes/middle.php");

	$test = new GroupTest("Wigbi.PHP.Core");
	foreach(glob("php/core/*.php") as $file)
		require_once($file);
	foreach (glob("../wigbi/php/wigbi/core/*.php") as $file)
		eval('$test->addTestCase(new ' . str_replace(".php", "", basename($file)) . 'Behavior());');
		
	print "<div class='box'>";
	$test->run(new HtmlReporter());
	print "</div>";
	
	require("includes/bottom.php");
?>
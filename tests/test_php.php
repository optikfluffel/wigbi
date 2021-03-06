<?php
	require("includes/top.php");
	require("../resources/tools/SimpleTest/autorun.php");
	
	
	//PHP.Core *****************************
	$test = new GroupTest("Wigbi.PHP.Core");
	foreach(glob("php/core/*.php") as $file)
		require_once($file);
	foreach (glob("../wigbi/php/core/*.php") as $file)
		eval('$test->addTestCase(new ' . str_replace(".php", "", basename($file)) . 'Behavior());');
	print "<div class='box'>";
	$test->run(new HtmlReporter());
	print "</div>";
	
	//PHP *****************************
	$test = new GroupTest("Wigbi.PHP");
	foreach(glob("php/*.php") as $file)
		require_once($file);
	foreach (glob("../wigbi/php/*.php") as $file)
		eval('$test->addTestCase(new ' . str_replace(".php", "", basename($file)) . 'Behavior());');
	print "<div class='box'>";
	$test->run(new HtmlReporter());
	print "</div>";
	
	
	require("includes/cleanup.php");
	require("includes/bottom.php");
?>
<?php
	require("includes/copy.php");
	require("includes/top.php");
	require("../resources/tools/SimpleTest/autorun.php");
	
	
	$test = new GroupTest("Wigbi.Plugins.Data");
	foreach(glob("plugins/data/*.php") as $file)
		require_once($file);
	foreach (glob("../plugins/data/*.php") as $file)
		eval('$test->addTestCase(new ' . str_replace(".php", "", basename($file)) . 'Behavior());');
	print "<div class='box'>";
	$test->run(new HtmlReporter());
	print "</div>";
			
	
	require("includes/cleanup.php");
	require("includes/bottom.php");
?>
<?php
	require("includes/top.php");
	require("../resources/tools/SimpleTest/autorun.php");
	

	//Copy plugins and reset Wigbi ***************
	foreach (glob("../plugins/data/*.*") as $file)
		copy($file, "../wigbi/plugins/data/" . basename($file));
	foreach (glob("../plugins/ui/*.*") as $file)
		copy($file, "../wigbi/plugins/ui/" . basename($file));
	ob_start(); Wigbi::start(); ob_get_clean(); 
	
	//Perform tests
	$test = new GroupTest("Wigbi.Plugins.Data");
	foreach(glob("plugins/data/*.php") as $file)
		require_once($file);
	foreach (glob("../plugins/data/*.php") as $file)
		eval('$test->addTestCase(new ' . str_replace(".php", "", basename($file)) . 'Behavior());');
	print "<div class='box'>";
	$test->run(new HtmlReporter());
	print "</div>"; 
	
	//Delete plugins
	Wigbi::dbHandler()->query("DROP DATABASE " . Wigbi::dbHandler()->dbName());
	$paths = array("wigbi/plugins/data/*.php", "wigbi/plugins/data/*.js", "wigbi/plugins/ui/*.php", "wigbi/plugins/ui/*.js");
	foreach ($paths as $path)
		foreach (glob($path) as $file)
			unlink($file);
			
	
	require("includes/bottom.php");
?>
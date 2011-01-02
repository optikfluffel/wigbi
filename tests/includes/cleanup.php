<?php 
	if (Wigbi::isStarted())
		Wigbi::dbHandler()->query("DROP DATABASE " . Wigbi::dbHandler()->dbName());
	
	$paths = array("../wigbi/plugins/data/*.php", "../wigbi/plugins/data/*.js", "../wigbi/plugins/ui/*.php", "../wigbi/plugins/ui/*.js");
	foreach ($paths as $path)
		foreach (glob($path) as $file)
			unlink($file);

	Wigbi::stop();
?>
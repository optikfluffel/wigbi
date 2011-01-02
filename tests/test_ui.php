<?php
	require("includes/copy.php");
	require("includes/top.php");
	
	
	?><script type="text/javascript">
		Wigbi._ajaxConfigFile = "tests/resources/config.ini";	//TODO: This has to be manually handled
		function addDone(elementId) { }
	</script><?php
	
	foreach (glob("plugins/ui/*php") as $file)
		include($file); 
	
	require("includes/bottom.php");
?>
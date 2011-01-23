<?php
	require("includes/copy.php");
	require("includes/top.php");
	
	?>
	
	<link rel="stylesheet" type="text/css" href="resources/jquery-ui-1.8.7.custom/css/south-street/jquery-ui-1.8.7.custom.css"></link>
	<script type="text/javascript" src="resources/jquery-ui-1.8.7.custom/js/jquery-ui-1.8.7.custom.min.js"></script>
	<script type="text/javascript">
		Wigbi._ajaxConfigFile = "tests/resources/config.ini";	//TODO: This has to be manually handled
		function addDone(elementId) { }
	</script><?php
	
	foreach (glob("plugins/ui/*php") as $file)
		include($file); 
	
	require("includes/bottom.php");
?>
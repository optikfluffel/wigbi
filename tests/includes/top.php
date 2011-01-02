<?php include "../wigbi/wigbi.php"; ?><!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" >
	<head>
		<script type="text/javascript" src="../wigbi/bundle/js:wigbi/js,tests/resources"></script>
		<link rel="stylesheet" type="text/css" href="../wigbi/bundle/css:tests/resources/test.css"></link>
		
			<?php
				function addPlugins()
				{
					foreach (glob("plugins/data/*.*") as $file)
						copy($file, "wigbi/plugins/data/" . basename($file));
					foreach (glob("plugins/ui/*.*") as $file)
						copy($file, "wigbi/plugins/ui/" . basename($file));
					
					ob_start();
					Wigbi::start();
					ob_get_clean();
				}
				
				function cleanUp()
				{
					Wigbi::dbHandler()->query("DROP DATABASE " . Wigbi::dbHandler()->dbName());
							 
					foreach (glob("wigbi/plugins/data/*.php") as $file)
						unlink($file);
					foreach (glob("wigbi/plugins/ui/*.php") as $file)
						unlink($file);
					foreach (glob("wigbi/plugins/ui/*.js") as $file)
						unlink($file);
						
					unlink("wigbi/js/wigbi_dataPlugins.js");
					unlink("wigbi/js/wigbi_uiPlugins.js");
				}
			?>
		<?php
			Wigbi::start();
			
			if (array_key_exists("clean", $_GET))
			{
				Wigbi::dbHandler()->query("DROP DATABASE " . Wigbi::dbHandler()->dbName());
							 
				foreach (glob("wigbi/plugins/data/*.php") as $file)
					unlink($file);
				foreach (glob("wigbi/plugins/ui/*.php") as $file)
					unlink($file);
				foreach (glob("wigbi/plugins/ui/*.js") as $file)
					unlink($file);
				
				if (is_file("wigbi/js/wigbi_dataPlugins.js"))
					unlink("wigbi/js/wigbi_dataPlugins.js");
				if (is_file("wigbi/js/wigbi_uiPlugins.js"))
					unlink("wigbi/js/wigbi_uiPlugins.js");
			}
			else
			{
				include("../resources/tools/SimpleTest/autorun.php");
			}
			
		?>
	</head>
	<body>
		<div id="main">
		
			<div class="box toolbar">
				<a href="test_php_core.php">PHP Core</a> •
				<a href="test_php.php">PHP</a>
			</div
			
			<?php include("includes/toolbar.php"); ?>
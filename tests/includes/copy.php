<?php 
	foreach (glob("../plugins/data/*.*") as $file)
		copy($file, "../wigbi/plugins/data/" . basename($file));
	foreach (glob("../plugins/ui/*.*") as $file)
		copy($file, "../wigbi/plugins/ui/" . basename($file));
?>
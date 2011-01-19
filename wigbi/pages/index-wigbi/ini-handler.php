<?php

	$iniHandler = new IniHandler(surl("~/wigbi/config.ini"));

?>

<p class="ingress large no-margin-bottom">IniHandler</p>
<div>The <em>application.name</em> key in the config file has the value <strong><?php print $iniHandler->get("name", "application"); ?></strong>.</div>
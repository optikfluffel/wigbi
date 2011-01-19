<?php

	if (Context::get("cache-data"))
		Wigbi::cacheHandler()->set("cache-data", Context::get("cache-data"));

?>

<p class="ingress large no-margin-bottom">CacheHandler</p>
<div>Try caching a string, either with PHP (reloads the page) or with AJAX:</div>
<p>
	<input type="text" id="cache-data" value="<?php print Wigbi::cacheHandler()->get("cache-data") ?>" />
	<button onclick="location.href = '<?php pwurl("~/index-wigbi.php?cache-data="); ?>' + $('#cache-data').val()">Cache with PHP</button>
	<button onclick="Wigbi.cacheHandler().set('cache-data', 'fewafewawa', 10, function(){ alert('Data has been cached. Press OK to reload the page.'); location.href = '<?php pwurl("~/index-wigbi.php"); ?>'; });">Cache with AJAX</button>
</p>
<div>You can cache any serializable data, as well as any output content.</div>

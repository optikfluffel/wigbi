<p class="ingress large no-margin-bottom">Added data plugins</p>
<ul class="clean">
<?php if (sizeof(Wigbi::dataPluginClasses()) == 0) { ?><li>No data plugins added</li> <?php }?>
<?php 
$plugins = Wigbi::dataPluginClasses();
foreach ($plugins as $plugin) { ?>
	<li><?php print $plugin ?></li>
<?php } ?>
</ul>
<p class="ingress large no-margin-bottom">Added UI plugins</p>
<ul class="clean">
<?php if (sizeof(Wigbi::uiPluginClasses()) == 0) { ?><li>No UI plugins added</li> <?php }?>
<?php 
$plugins = Wigbi::uiPluginClasses();
foreach ($plugins as $plugin) { ?>
	<li><?php print $plugin ?></li>
<?php } ?>
</ul>
<?php if (View::model()) { ?>
	<p class="ingress large">Wigbi is <span class="invalid">not</span> properly configured! <?php print View::model()->getMessage(); ?></p>
<?php } else { ?>
	<p class="ingress large">Wigbi is properly configured! This page shows you how to use some of its functionality. A good place to start could be to add some data and UI plugins and see what happens :)</p>
<?php } ?>

<?php
	$obj1 = new News();
	$obj1->title("foo");
	$obj1->content("Foo");
	$obj2 = new News();
	$obj2->title("bar");
	$obj2->content("Bar");	
	$obj1->loadBy("title", "foo");
	if (!$obj1->id())
	{
		$obj1->save();
		$obj2->save();	
	}
?>

<div class="box">
	<div class="box title">NewsControl</div>
	<div id="nc_target">
		<?php NewsControl::add("nc", $obj1, "", false); ?>
	</div>
	<div class="fc">
		<div class="box add">
			Id: <?php View::addTextInput("nc_id") ?>
			Title: <?php View::addTextInput("nc_title", "") ?>
			EmbedForm: <input id="nc_embed" type="checkbox" />
			<?php View::addButton("nc_addButton", "Add", "NewsControl.add('nc', $('#nc_id').val(), $('#nc_title').val(), $('#nc_embed').attr('checked'), 'nc_target', addDone)"); ?>
		</div>
	</div>
</div>
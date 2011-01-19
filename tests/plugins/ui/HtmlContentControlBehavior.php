<?php
	$obj1 = new HtmlContent();
	$obj1->name("foo");
	$obj1->content("Foo");
	$obj2 = new HtmlContent();
	$obj2->name("bar");
	$obj2->content("Bar");	
	$obj1->loadBy("name", "foo");
	if (!$obj1->id())
	{
		$obj1->save();
		$obj2->save();	
	}
?>

<div class="box">
	<div class="box title">HtmlContentControl</div>
	<div id="hcc_target">
		<?php HtmlContentControl::add("hcc", $obj1, "", false); ?>
	</div>
	<div class="fc">
		<div class="box add">
			Id: <?php View::addTextInput("hcc_id") ?>
			Name: <?php View::addTextInput("hcc_name", "") ?>
			EmbedForm: <input id="hcc_embed" type="checkbox" />
			<?php View::addButton("hcc_addButton", "Add", "HtmlContentControl.add('hcc', $('#hcc_id').val(), $('#hcc_name').val(), $('#hcc_embed').attr('checked'), 'hcc_target', addDone)"); ?>
		</div>
	</div>
</div>
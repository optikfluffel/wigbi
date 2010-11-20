<?php

	$obj1 = new HtmlContent();
	$obj1->name("foo");
	$obj1->content("Foo");
	$obj1->save();
	
	$obj2 = new HtmlContent();
	$obj2->name("bar");
	$obj2->content("Bar");
	$obj2->save();

?>

<fieldset>
	<legend>HtmlContentControl</legend>
	<div id="hcc_target">
		<?php HtmlContentControl::add("hcc", $obj1, "", false); ?>
	</div>
	<div class="pluginControls">
		Id: <?php View::addTextInput("hcc_id") ?>
		Name: <?php View::addTextInput("hcc_name", "") ?>
		EmbedForm: <input id="hcc_embed" type="checkbox" /> 
		<?php View::addButton("hcc_addButton", "Add", "HtmlContentControl.add($('hcc_id').val(), $('hcc_name').val(), $('hcc_embed').val(), 'hcc_target')"); ?>
	</div>
</fieldset>


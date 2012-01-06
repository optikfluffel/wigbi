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
			Id: <input type="text" id="hcc_id" />
			Name: <input type="text" id="hcc_name" />
			EmbedForm: <input type="checkbox" id="hcc_embed" />
			<button id="hcc_addButton" onclick="HtmlContentControl.add('hcc', $('#hcc_id').val(), $('#hcc_name').val(), $('#hcc_embed').attr('checked'), 'hcc_target', addDone);">Add</button>
		</div>
	</div>
</div>
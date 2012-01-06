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
			Id: <input type="text" id="nc_id" />
			Name: <input type="text" id="nc_name" />
			EmbedForm: <input type="checkbox" id="nc_embed" />
			<button id="nc_addButton" onclick="NewsControl.add('nc', $('#nc_id').val(), $('#nc_name').val(), $('#nc_embed').attr('checked'), 'nc_target', addDone);">Add</button>
		</div>
	</div>
</div>
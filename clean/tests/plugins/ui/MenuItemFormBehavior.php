<?php
	$obj1 = new MenuItem();
	$obj1->name("foo");
	$obj1->url("~/foo");
	$obj1->text("Foo");
	$obj1->tooltip("Read about foo");
	$obj2 = new MenuItem();
	$obj2->name("bar");
	$obj2->url("~/bar");
	$obj2->text("Bar");
	$obj2->tooltip("Read about bar");
	$obj1->loadBy("name", "foo");
	if (!$obj1->id())
	{
		$obj1->save();
		$obj2->save();	
	}
?>

<div class="box">
	<div class="box title">MenuItemForm</div>
	<div id="mif_target">
		<?php MenuItemForm::add("mif", $obj1, ""); ?>
	</div>
	<div class="fc">
		<div class="box add">
			Id: <input type="text" id="mif_id" />
			Name: <input type="text" id="mif_name" />
			<button id="mif_addButton" onclick="MenuItemForm.add('mif', $('#mif_id').val(), $('#mif_name').val(), 'mif_target', addDone);">Add</button>
		</div>
	</div>
</div>
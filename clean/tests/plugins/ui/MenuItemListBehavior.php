<?php
	$obj1 = new MenuItem();
	$obj1->loadBy("name", "root");
	if (!$obj1->id())
	{
		$obj1->name("root");
		$obj1->save();
		
		$children = array("one", "two", "three");
		foreach ($children as $child)
		{
			$obj2 = new MenuItem();
			$obj2->name("#" . $child);
			$obj2->url("~/" . $child);
			$obj2->text($child);
			$obj2->tooltip("Read about " . $child);
			
			$obj2->save();
			$obj1->addListItem("children", $obj2->id());	
		}
	}
?>

<div class="box">
	<div class="box title">MenuItemList</div>
	<div id="mil_target">
		<?php MenuItemList::add("mil", $obj1, "", "horizontal", false, false, false, false); ?>
	</div>
	<div class="fc">
		<div class="box add">
			Parent ID: <input type="text" id="mil_id" />
			Parent Name: <input type="text" id="mil_name" />
			CSS class: <input type="text" id="mil_css" /><br/>
			Can add: <input type="checkbox" id="hcc_canAdd" />
			Can delete: <input type="checkbox" id="hcc_canDelete" />
			Can edit: <input type="checkbox" id="hcc_canEdit" />
			Can sort: <input type="checkbox" id="hcc_canSort" />
			<button id="mil_addButton" onclick="MenuItemList.add('mil', $('#mil_id').val(), $('#mil_name').val(), $('#mil_css').val(), $('#hcc_canAdd').attr('checked'), $('#hcc_canDelete').attr('checked'), $('#hcc_canEdit').attr('checked'), $('#hcc_canSort').attr('checked'), 'mil_target', addDone);">Add</button>
		</div>
	</div>
</div>
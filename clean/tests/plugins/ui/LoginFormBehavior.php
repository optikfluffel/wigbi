<?php
	$obj1 = new User();
	$obj1->userName("daniel.saidi");
	$obj1->password("dadada");
	$obj1->isAdmin(true);
	$obj2 = new User();
	$obj2->userName("cornelia");
	$obj2->password("dadada");
	$obj2->isAdmin(false);
	if (!$obj1->id())
	{
		$obj1->save();
		$obj2->save();	
	}
?>

<? if (!User::getCurrentUser()->id()) { ?>
	<div class="box">
	<div class="box title">LoginForm</div>
		<div id="lif_target">
			<?php LoginForm::add("lif", "", false); ?>
		</div>
		<div class="fc">
			<div class="box add">
				Redirect URL: <input type="text" id="lif_redirectUrl" />
				<button id="lif_addButton" onclick="LoginForm.add('lif', $('#lif_redirectUrl').val(), 'lif_target', addDone)">Add</button>
			</div>
		</div>
	</div>
<?php } ?>
<? if (User::getCurrentUser()->id()) { ?>
	<div class="box">
		<div class="box title">LogoutLink</div>
		<div id="lol_target">
			<?php LogoutLink::add("lol", "", false); ?>
		</div>
		<div class="fc">
			<div class="box add">
				Redirect URL: <input type="text" id="lol_redirectUrl" />
				<button id="lif_addButton" onclick="LogoutLink.add('lif', $('#lol_redirectUrl').val(), 'lol_target', addDone)">Add</button>
			</div>
		</div>
	</div>
<?php } ?>
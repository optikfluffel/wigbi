<? if (User::getCurrentUser()->id()) { ?>
	<div class="box">
		<h1>LogoutLink</h1>
		<div id="lol_target">
			<?php LogoutLink::add("lol", "", false); ?>
		</div>
		<div class="fc">
			<div class="box add">
				Redirect URL: <?php View::addTextInput("lol_redirectUrl", "") ?>
				<?php View::addButton("lol_addButton", "Add", "LogoutLink.add('lol', $('#lol_redirectUrl').val(), 'lol_target', addDone)"); ?>
			</div>
		</div>
	</div>
<?php } ?>
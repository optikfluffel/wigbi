<div class="box">
	<h1>LoginForm</h1>
	<div id="lif_target">
		<?php LoginForm::add("lif", "http://www.saidi.se", false); ?>
	</div>
	<div class="fc">
		<div class="box add">
			Redirect URL: <?php View::addTextInput("lif_redirectUrl", "") ?>
			Auto-redirect: <?php View::addCheckBox("lif_autoRedirect", false) ?>
			<?php View::addButton("lif_addButton", "Add", "LoginForm.add('lif', $('#lif_redirectUrl').val(), $('#hcf_autoRedirect').attr('checked'), 'lif_target', addDone)"); ?>
		</div>
	</div>
</div>
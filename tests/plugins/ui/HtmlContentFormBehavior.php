<div class="box">
	<h1>HtmlContentForm</h1>
	<div id="hcf_target">
		<?php HtmlContentForm::add("hcf", $obj1, ""); ?>
	</div>
	<div class="fc">
		<div class="box add">
			Id: <?php View::addTextInput("hcf_id") ?>
			Name: <?php View::addTextInput("hcf_name", "") ?>
			<?php View::addButton("hcf_addButton", "Add", "HtmlContentForm.add('hcf', $('#hcf_id').val(), $('#hcf_name').val(), 'hcf_target', addDone)"); ?>
		</div>
		<div class="box prop">
			<select onchange="hcf.obj(JSON.parse(this.value))">
				<option value='<?php print json_encode($obj1) ?>'><?php print $obj1->name(); ?></option>
				<option value='<?php print json_encode($obj2) ?>'><?php print $obj2->name(); ?></option>
			</select>
		</div>
	</div>
</div>
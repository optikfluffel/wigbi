<div class="box">
	<div class="box title">NewsForm</div>
	<div id="nf_target">
		<?php NewsForm::add("nf", $obj1, ""); ?>
	</div>
	<div class="fc">
		<div class="box add">
			Id: <?php View::addTextInput("nf_id") ?>
			Title: <?php View::addTextInput("nf_title", "") ?>
			<?php View::addButton("nf_addButton", "Add", "NewsForm.add('nf', $('#nf_id').val(), $('#nf_title').val(), 'nf_target', addDone)"); ?>
		</div>
		<div class="box prop">
			<select onchange="nf.obj(JSON.parse(this.value))">
				<option value='<?php print json_encode($obj1) ?>'><?php print $obj1->title(); ?></option>
				<option value='<?php print json_encode($obj2) ?>'><?php print $obj2->title(); ?></option>
			</select>
		</div>
	</div>
</div>
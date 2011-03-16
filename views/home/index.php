<?php MasterPage::filePath("~/views/shared/master.php"); ?>

<?php MasterPage::openContentArea("body"); ?>
	<?php View::addView("~/wigbi/pages/index-wigbi/config-status.php", View::viewData("wigbi-error")); ?>
	<hr />
	<div class="columns wide-left fc">
		<div class="left">
			<?php if (Wigbi::isStarted()) { ?>
				<?php View::addView("~/wigbi/pages/index-wigbi/cache-handler.php"); ?>
				<?php View::addView("~/wigbi/pages/index-wigbi/ini-handler.php"); ?>
				<p class="ingress large">More will follow... :)</p>
			<?php } else { ?>
				Start Wigbi to display some demos.
			<?php } ?>
		</div>
		<div class="right">
			<?php View::addView("~/wigbi/pages/index-wigbi/data-plugins.php"); ?>
			<br />
			<?php View::addView("~/wigbi/pages/index-wigbi/ui-plugins.php"); ?>
		</div>
	</div>
<?php MasterPage::closeContentArea(); ?>

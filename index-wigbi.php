<?php include "wigbi/wigbi.php"; ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd" >

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" >
	<head>
		<?php
			try { Wigbi::start(); }
			catch(Exception $e) { View::viewData("error", $e); }
		?>
		<link rel="stylesheet" type="text/css" href="wigbi/bundle/css:wigbi/css" />
		<link rel="stylesheet" type="text/css" href="wigbi/bundle/css:wigbi/css/index-wigbi" />
	</head>
	
	<body>
		<div id="main">
			<div id="main-header">
				<div id="main-logo">
					<img src="wigbi/img/logo.png" alt="Wigbi logo" />
				</div>
			</div>
			
			<div class="box-top one"></div>
			<div id="main-body">
				<?php View::addView("~/wigbi/pages/index-wigbi/config-status.php", View::viewData("error")); ?>
				<hr />
				<div class="columns wide-left fc">
					<div class="left">
						<?php View::addView("~/wigbi/pages/index-wigbi/cache-handler.php"); ?>
						<hr/>
						<?php View::addView("~/wigbi/pages/index-wigbi/ini-handler.php"); ?>
					</div>
					<div class="right">
						<?php View::addView("~/wigbi/pages/index-wigbi/data-plugins.php"); ?>
						<br />
						<?php View::addView("~/wigbi/pages/index-wigbi/ui-plugins.php"); ?>
					</div>
				</div>
				<div style="clear:both"></div>
			</div>
			<div class="box-bottom"></div>
			
			<div class="box-top"></div>
			<div class="box">
				© 2009-2011 <a href="http://www.saidi.se" class="em">Daniel Saidi</a> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
				Site developed with <a href="http://www.wigbi.com" class="em">Wigbi 1.0.1</a> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
		
				Site looks great thanks to <a href="http://parsley.se/" class="em">Kristoffer Gustafsson</a> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
				More site features coming soon
			</div>
			<div class="box-bottom"></div>
		
			<div class="boxGroup three fc">
				<div>
					<div class="box-top one"></div>
					<div class="box"></div>
					<div class="box-bottom one"></div>
				</div>
				<div>
					<div class="box-top one"></div>
					<div class="box"></div>
					<div class="box-bottom one"></div>
				</div>
				<div>
					<div class="box-top one"></div>
					<div class="box"></div>
					<div class="box-bottom one"></div>
				</div>
			</div>
		</div>
	</body>
</html>

<?php Wigbi::stop(); ?>
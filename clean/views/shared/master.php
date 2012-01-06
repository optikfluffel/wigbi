<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd" >

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" >
	<head>
		<?php print MasterPage::getContent("wigbi-start"); ?>
		<link rel="stylesheet" type="text/css" href="<?php pwurl("~/wigbi/bundle/css:wigbi/css") ?>" />
		<link rel="stylesheet" type="text/css" href="<?php pwurl("~/wigbi/bundle/css:wigbi/css/index-wigbi") ?>" />
	</head>
	
	<body>
		<div id="main">
			<div id="main-header">
				<div id="main-logo">
					<img src="<?php pwurl("~/wigbi/img/logo.png") ?>" alt="Wigbi logo" />
				</div>
			</div>
			
			<div class="box-top one"></div>
			<div id="main-body">
				<?php print MasterPage::getContent("body"); ?>
				<div style="clear:both"></div>
			</div>
			<div class="box-bottom"></div>
			
			<div class="box-top"></div>
			<div class="box">
				© 2009-2011 <a href="http://www.saidi.se" class="em">Daniel Saidi</a> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
				v. <a href="http://www.wigbi.com" class="em">Wigbi <?php print Wigbi::version(); ?></a>
			</div>
			<div class="box-bottom"></div>
		</div>
	</body>
</html>

<?php Wigbi::stop(); ?>
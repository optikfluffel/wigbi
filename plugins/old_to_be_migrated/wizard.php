<?php include("../../../wigbi.php"); ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd" >

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" >
	<head>
		
		<!-- Page title -->
		<title>Wigbi test</title>
	
		<!-- Application initialization -->
		<?php
			ThemeHandler::setTheme();
			Wigbi::start();
		?>
	
		<!-- Meta data -->
		<meta http-equiv="expires" content="-1" />
		<meta name="copyright" content="Copyright 2009, Daniel Saidi" />
		<meta name="description" content="Wigbi Templates contains demos and templates" />
		<meta name="keywords" content="wigbi templates demos seeds controls" />
		
	</head>
	
	<body>
		<fieldset>
			<legend>Wigbi Wizard validation result</legend>
			<?php WigbiWizard::add("wizard"); ?>
		</fieldset>
	</body>
</html>

<!-- End application (mandatory) -->
<?php Wigbi::stop();?>
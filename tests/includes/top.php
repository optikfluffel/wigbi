<?php include "../wigbi/wigbi.php"; ?><!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" >
	<head>
		<script type="text/javascript" src="../wigbi/bundle/js:wigbi/js,tests/resources"></script>
		<link rel="stylesheet" type="text/css" href="../wigbi/bundle/css:tests/resources/test.css"></link>
		<?php Wigbi::configFile("resources/config.ini"); ?>
		<?php Wigbi::start(); ?>
	</head>
<body>
	<div id="main">
		<div class="box toolbar">
			<a href="test_php.php">PHP</a> •
			<a href="test_data.php">Data plugins</a> •
			<a href="test_finish.php">FINISH</a>
		</div>
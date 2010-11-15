<?php
//Add session handling
session_start();

//Find wigbi root folder
$root = "";
while(!is_dir($root . "wigbi/"))
	$root = "../" . $root;

//Include Wigbi
ob_start();
foreach(glob($root . "wigbi/php/wigbi/tools/*.php") as $file)
	require_once($file);
foreach(glob($root . "wigbi/php/wigbi/core/*.php") as $file)
	require_once($file);
foreach(glob($root . "wigbi/php/wigbi/*.php") as $file)
	require_once($file);
ob_get_clean();
?>
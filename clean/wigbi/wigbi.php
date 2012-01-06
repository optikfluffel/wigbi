<?php
//Add session handling
session_start();

//Find wigbi root folder
$root = "";
while(!is_dir($root . "wigbi/"))
	$root = "../" . $root;

//Include everything that is required to make Wigbi start
ob_start();
foreach(glob($root . "wigbi/php/tools/*.php") as $file)
	require_once($file);
foreach(glob($root . "wigbi/php/core/*.php") as $file)
	require_once($file);
foreach(glob($root . "wigbi/php/*.php") as $file)
	require_once($file);
ob_get_clean();
?>
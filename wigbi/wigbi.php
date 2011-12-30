<?php

//Add session handling, which is needed
//session_start();

//Define global wigbi variables
$wigbi_php_folders = array("tools", "cache", "core", "configuration", "data", "io", "ui", "");

//Find wigbi root folder
$wigbi_root = "";
while(!is_dir($wigbi_root . "wigbi/"))
	$wigbi_root = "../" . $wigbi_root;

//Include everything that is required to start Wigbi
ob_start();

foreach ($wigbi_php_folders as $folder)
{
	foreach(glob($wigbi_root . "wigbi/php/$folder/_*.php") as $file)
	{
		require_once($file);
		print $file;
		
	}
	
	foreach(glob($wigbi_root . "wigbi/php/$folder/*.php") as $file)
	{
		require_once($file);
		print $file;
		
	}
}
	
ob_get_clean();

?>
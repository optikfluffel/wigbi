<?php

//Add session handling, which is needed
session_start();

//Define global wigbi variables
$wigbi_php_folders = array("tools", "cache", "core", "configuration", "data", "i18n", "io", "mvc", "ui", "validation", "web", "");

//Find wigbi root folder
$wigbi_root = "";
while(!is_dir($wigbi_root . "wigbi/"))
	$wigbi_root = "../" . $wigbi_root;

//Include everything that is required to start Wigbi
ob_start();

foreach ($wigbi_php_folders as $folder)
{
	//Include interfaces and root classes first
	foreach(glob($wigbi_root . "wigbi/php/$folder/_*.php") as $file)
	{
		require_once($file);
	}
	
	//Include all other files afterwards
	foreach(glob($wigbi_root . "wigbi/php/$folder/*.php") as $file)
	{
		require_once($file);
	}
}
	
ob_get_clean();

?>
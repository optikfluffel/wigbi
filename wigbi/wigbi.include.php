<?php 

//Start session handling
session_start();

//Include everything that is required to start Wigbi
ob_start();
foreach ($wigbi_globals["php_folders"] as $folder)
{
	//Include interfaces and root classes first
	foreach(glob($wigbi_globals["root"] . "wigbi/php/$folder/_*.php") as $file)
	{
		require_once($file);
	}
	
	//Include all other files afterwards
	foreach(glob($wigbi_globals["root"] . "wigbi/php/$folder/*.php") as $file)
	{
		require_once($file);
	}
}
ob_get_clean();

?>
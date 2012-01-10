<?php

//Load classes outside of test context (so that they are executed in this path)
function __autoload($className)
{
	global $wigbi_globals;
	foreach ($wigbi_globals["php_folders"] as $folder)
	{
		$classFile = "php/$folder/$className.php";
		if (file_exists($classFile))
            require_once($classFile);
	}
}

//Create and run all unit test classes 
foreach ($wigbi_globals["php_folders"] as $folder)
{
	foreach (glob("php/$folder/*.php") as $file)
	{
		eval("new " . basename(str_replace(".php", "", basename($file))) . "();");
	}
}

?>
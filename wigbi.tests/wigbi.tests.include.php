<?php

//Include test framework
require("tools/SimpleTest_1_1/autorun.php");

//Define autoload search paths
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
		$fileName = basename(str_replace(".php", "", basename($file)));
		eval("new " . $fileName . "();");
	}
}

?>
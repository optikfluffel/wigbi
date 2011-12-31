<?php

require("../wigbi/wigbi.php");
require("tools/SimpleTest_1_1/autorun.php");


//Load classes outside of test context (so that they are executed in this path)
function __autoload($className)
{
	global $wigbi_php_folders;

	foreach ($wigbi_php_folders as $folder)
	{
		$classFile = "php/$folder/$className.php";
		
		if (file_exists($classFile))
        {
            require_once ($classFile);
            return;
        } 
	}
}

//Create and run all unit test classes 
foreach ($wigbi_php_folders as $folder)
{
	foreach (glob("php/$folder/*.php") as $file)
	{
		$className = basename(str_replace(".php", "", basename($file)));
		eval("new " . $className . "();");
	}
		 
}




/*interface Int { function test(); }
class MyInt1 implements Int { public function test() { return 1; } }
class MyInt2 implements Int { public function test() { return 2; } }

class Container {
	public static function getInstance($type)
	{
		switch ($type)
		{
			case "Int":
				return new MyInt1();
		}
	}
}

$b = new Int();
$a = Container::getInstance($b);
print $a->test();*/


/*
public function testPushAndPop()
		{
			Mock::generate('Int');
			$a = new MockInt();
			$a->test();	
			
			$a->expectCallCount("test", 1);
	  }*/


?>

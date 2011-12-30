<?php

require("../wigbi/wigbi.php");
require("tools/SimpleTest_1_1/autorun.php");


function __autoload($className)
{
	global $wigbi_php_folders;

	foreach ($wigbi_php_folders as $folder)
	{
		$testFolder = "php/$folder/";
		
		if (file_exists($testFolder . $className . '.php'))
        {
            require_once ($testFolder . $className . '.php');
            return;
        } 
	}
}


/*
foreach ($wigbi_php_folders as $folder)
{
	$test_folder = "php/$folder";
	
	if (!is_dir($test_folder))
		continue;
	
	foreach (glob($test_folder . "/*.php") as $file)
	{
		print $file . "<br/>";
		require_once($file);
	}
}*/


$a = new WigbiBehavior();

$a = new CacheBaseBehavior();
$a = new FileCacheBehavior();
$a = new MemoryCacheBehavior();

$a = new FileConfigurationBehavior();
$a = new IniFileReaderBehavior();

$a = new MasterPageBehavior();


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

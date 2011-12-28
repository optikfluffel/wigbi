<?php

require("../wigbi/wigbi.php");
require("tools/SimpleTest_1_1/autorun.php");
		
function __autoload($class_name) {
	$classesDir = array (
		'php/',
		'php/cache/',
		'php/configuration/',
		'php/core/',
		'php/data/',
		'php/ui/'
	);
	
    foreach ($classesDir as $directory) {
        if (file_exists($directory . $class_name . '.php')) {
                require_once ($directory . $class_name . '.php');
                return;
        }
    }
}

$a = new WigbiBehavior();

$a = new CacheBaseBehavior();
$a = new FileCacheBehavior();
$a = new MemoryCacheBehavior();

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

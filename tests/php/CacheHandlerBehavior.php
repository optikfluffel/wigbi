<?php

class CacheHandlerBehavior extends UnitTestCase
{
	private $obj;
	
	
	
	function CacheHandlerBehavior()
	{
		$this->UnitTestCase("CacheHandler");
	}
	
	function setUp()
	{
		$this->obj = new CacheHandler();
	}
	
	function tearDown()
	{
		$this->removeFolder($this->obj->cacheFolder());
	}


	
	function getFileName()
	{
		return $this->obj->cacheFolder() . "/cache_mydata";
	}
	
	function removeFolder($path)
	{
		if(!$handle = @opendir($path))
			return;
			
		while (($obj = readdir($handle)) != false)
		{
			if ($obj == '.' || $obj == '..')
				continue;
			if (!@unlink($path . '/' . $obj))
				$this->removeFolder($path . '/' . $obj, true);
		}
	
		closedir($handle);
		rmdir($path);
	}
	
	
	
	function test_constructor_shouldInitializeDefaultObject()
	{
		$this->assertEqual($this->obj->cacheFolder(), "cache");
	}
	
	function test_constructor_shouldInitializeCustomObject()
	{
		$this->obj = new CacheHandler("caching");
		$this->assertEqual($this->obj->cacheFolder(), "caching");
	}
			
	
	
	function test_cacheFolder_shouldGetSetValue()
	{
		$this->assertEqual($this->obj->cacheFolder(), "cache");
		$this->assertEqual($this->obj->cacheFolder("caching"), "caching");
		$this->assertEqual($this->obj->cacheFolder(), "caching");
	}
	
	
	
	function test_beginCaching_shouldStartOutputBuffering()
	{
		$this->obj->beginCaching("myData", 10);
		print "foo";
		$data = ob_get_clean();
		
		$this->assertEqual($data, "foo");
	}
	
	function test_clear_shouldNotFailForNonExistingData()
	{
		$value = $this->obj->clear("myData");
		
		$this->assertTrue($value);
	}
	
	function test_clear_shouldClearExistingData()
	{
		$this->obj->set("myData", "foo");
		$this->obj->clear("myData");
		
		$this->assertEqual($this->obj->get("myData"), null);
	}
	
	function test_endCaching_shouldEndOutputBuffering()
	{
		$this->obj->beginCaching("myData", 10);
		print "foo";
		$this->obj->endCaching();
		$data = ob_get_clean();
		
		$this->assertEqual($data, "");
	}
	
	function test_endCaching_shouldCreateMissingFolder()
	{
		$this->removeFolder($this->obj->cacheFolder());
		$this->obj->beginCaching("myData", 10);
		$this->obj->endCaching();
		
		$this->assertEqual(is_dir($this->obj->cacheFolder()), true);
	}
	
	function test_endCaching_shouldCreateTargetFile()
	{
		$this->obj->beginCaching("myData", 10);
		print "foo";
		$this->obj->endCaching();
		
		$this->assertEqual(file_exists($this->getFileName()), true);
	}
	
	function test_endCaching_shouldCreateCorrectFileContent()
	{
		$timeString = date("YmdHis", mktime(date("H"), date("i") + 10, date("s"), date("m"), date("d"), date("Y")));
		
		$this->obj->beginCaching("myData", 10);
		print "foo";
		$this->obj->endCaching();
		
		$fileData = json_decode(file_get_contents($this->getFileName()));
		$fileTimeString = $fileData[0];
		$cacheData = unserialize($fileData[1]);
		
		$this->assertEqual($timeString, $fileTimeString);
		$this->assertEqual("foo", $cacheData);
	}
	
	function test_get_shouldReturnNullForNonExistingData()
	{
		$this->assertEqual($this->obj->get("myData"), null);
	}
	
	function test_set_get_shouldSetAndReturnString()
	{
		$result = $this->obj->set("myData", "foo");
		
		$this->assertTrue($result);
		$this->assertEqual($this->obj->get("myData"), "foo");
	}
	
	function test_set_get_shouldSetAndReturnObject()
	{
		$obj = new CacheHandler("some_cache_folder");
		$result = $this->obj->set("myData", $obj);
		
		$this->assertTrue($result);
		$this->assertEqual($this->obj->get("myData"), $obj);
	}
}

?>
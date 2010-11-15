<?php

class IniHandlerBehavior extends UnitTestCase
{
	private $iniHandler;
	
	
	
	function IniHandlerBehavior()
	{
    	$this->UnitTestCase('IniHandler');
	}
	
	function setUp()
	{
		$this->iniHandler = new IniHandler(Wigbi::serverRoot() . "tests/resources/config.ini");
	}
	
	function tearDown() { }
	
	
	
	function test_constructor_shouldNotFailForNonExistingFile()
	{
		$this->iniHandler = new IniHandler();
	}
	
	function test_constructor_shouldInitializeCustomObject()
	{
		$this->assertEqual(gettype($this->iniHandler->data()), "array");
		$this->assertEqual($this->iniHandler->filePath(), Wigbi::serverRoot() . "tests/resources/config.ini");
	}
			
	
	
	function test_data_shouldReturnAllSectionsAndParameters()
	{
		$data = $this->iniHandler->data();
		
		$this->assertEqual(sizeof($data), 7);
		$this->assertEqual(sizeof($data["application"]), 3);
		$this->assertEqual(sizeof($data["logHandler"]), 15);
	}
	
	function test_filePath_shouldReturnCorrectValue()
	{
		$this->assertEqual($this->iniHandler->filePath(), Wigbi::serverRoot() . "tests/resources/config.ini");
	}
	
	
	
	function test_get_shouldReturnNullForNonExistingParameterInSection()
	{
		$this->assertEqual($this->iniHandler->get("foo2", "application"), null);
	}
	
	function test_get_shouldReturnExistingParameterInSection()
	{
		$this->assertEqual($this->iniHandler->get("name", "application"), "Wigbi Unit Tests");
	}
	
	function test_get_shouldReturnNullForNonExistingParameterWithoutSection()
	{
		$this->iniHandler->parseFile(Wigbi::serverRoot() . "tests/resources/config_nosections.ini");
		
		$this->assertEqual($this->iniHandler->get("foo3"), null);
	}
	
	function test_get_shouldReturnExistingParameterWithoutSection()
	{
		$this->iniHandler->parseFile(Wigbi::serverRoot() . "tests/resources/config_nosections.ini");
		
		$this->assertEqual($this->iniHandler->get("foo"), "bar");
	}
	
	function test_parseFile_shouldUpdateFilePath()
	{
		$this->iniHandler->parseFile("nonExistingFile");
		
		$this->assertEqual($this->iniHandler->filePath(), "nonExistingFile");
	}
	
	function test_parseFile_shouldReturnFalseForNonExistingFile()
	{
		$result = $this->iniHandler->parseFile("nonExistingFile");
		
		$this->assertEqual($result, false);
	}
	
	function test_parseFile_shouldReturnFalseForInvalidFile()
	{
		$result = $this->iniHandler->parseFile(Wigbi::serverRoot() . "tests/resources/config_invalid.ini");
		
		$this->assertEqual($result, false);
	}
	
	function test_parseFile_shouldReturnArrayForValidFile()
	{
		$result = $this->iniHandler->parseFile(Wigbi::wigbiFolder() . "config.ini");
		
		$this->assertEqual(gettype($result), "array");
	}
}

?>
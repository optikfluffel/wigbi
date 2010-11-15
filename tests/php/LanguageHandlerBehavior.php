<?php

class LanguageHandlerBehavior extends UnitTestCase
{
	private $languageHandler;
	


	function LanguageHandlerBehavior()
	{
		$this->UnitTestCase("LanguageHandler");
	}
	
	function setUp()
	{
		$this->languageHandler = new LanguageHandler(Wigbi::serverRoot() . "tests/resources/english.ini");
	}
	
	function tearDown() { }
	
	
	
	function test_constructor_shouldNotFailForNonExistingFile()
	{
		$this->languageHandler = new LanguageHandler();
	}
	
	function test_constructor_shouldInitializeCustomObject()
	{
		$this->assertEqual(gettype($this->languageHandler->data()), "array");
	}
			
		
	
	function test_translate_shouldReturnParameterForNonExistingParameterWithoutSection()
	{
		$this->assertEqual($this->languageHandler->translate("foo2"), "foo2");
	}
	
	function test_translate_shouldTranslateExistingParameterWithoutSection()
	{
		$this->assertEqual($this->languageHandler->translate("bar"), "bar");
	}
	
	function test_translate_shouldTranslateExistingHierarchicalParameterWithoutSection()
	{
		$this->assertEqual($this->languageHandler->translate("foo bar"), "foobar");
	}	
	
	function test_translate_shouldReturnParameterForNonExistingParameterInSection()
	{
		$this->assertEqual($this->languageHandler->translate("foo3", "section"), "foo3");
	}
	
	function test_translate_shouldTranslateExistingParameterInSection()
	{
		$this->assertEqual($this->languageHandler->translate("bar2", "section"), "bar2");
	}
	
	function test_translate_shouldTranslateExistingHierarchicalParameterInSection()
	{
		$this->assertEqual($this->languageHandler->translate("foo bar2", "section"), "foobar2");
	}
}

?>
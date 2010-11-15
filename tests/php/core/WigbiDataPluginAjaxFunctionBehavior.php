<?php

class WigbiDataPluginAjaxFunctionBehavior extends UnitTestCase
{
	private $obj;
	


	function WigbiDataPluginAjaxFunctionBehavior()
	{
		$this->UnitTestCase("WigbiDataPluginAjaxFunction");
	}
	
	function setUp()
	{
		$this->obj = new WigbiDataPluginAjaxFunction("myFunction", array("foo", "bar"), true);
	}
	
	function tearDown() { }
	
	
	
	function test_constructor_shouldInitializeDefaultObject()
	{
		$this->obj = new WigbiDataPluginAjaxFunction("myFunction");
		
		$this->assertEqual($this->obj->name(), "myFunction");
		$this->assertEqual($this->obj->parameters(), array());
		$this->assertEqual($this->obj->isStatic(), false);
	}
	
	function test_constructor_shouldInitializeCustomObject()
	{
		$this->assertEqual($this->obj->name(), "myFunction");
		$this->assertEqual($this->obj->parameters(), array("foo", "bar"));
		$this->assertEqual($this->obj->isStatic(), true);
	}
			
	
	
	function test_isStatic_shouldReturnCorrectValue()
	{
		$this->assertEqual($this->obj->isStatic(), true);
	}
	
	function test_name_shouldReturnCorrectValue()
	{
		$this->assertEqual($this->obj->name(), "myFunction");
	}
	
	function test_parameters_shouldReturnCorrectValue()
	{
		$this->assertEqual($this->obj->parameters(), array("foo", "bar"));
	}
}

?>
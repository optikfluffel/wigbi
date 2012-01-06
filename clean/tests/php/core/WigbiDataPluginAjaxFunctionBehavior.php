<?php

class WigbiDataPluginAjaxFunctionBehavior extends UnitTestCase
{
	private $obj;
	


	function WigbiDataPluginAjaxFunctionBehavior()
	{
		$this->UnitTestCase("WigbiDataPluginAjaxFunction");
	}
	
	function setUp() { }
	
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
		$this->obj = new WigbiDataPluginAjaxFunction("myFunction", array("foo", "bar"), true);
		
		$this->assertEqual($this->obj->name(), "myFunction");
		$this->assertEqual($this->obj->parameters(), array("foo", "bar"));
		$this->assertEqual($this->obj->isStatic(), true);
	}
}

?>
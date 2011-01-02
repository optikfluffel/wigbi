<?php

class ControllerBehavior extends UnitTestCase
{
	function ControllerBehavior()
	{
		$this->UnitTestCase("Controller");
	}


	
	function test_action_shouldReturnIndexForNoQueryVariableAndNoCustomValue()
	{
		Controller::action("");
		
		$this->assertEqual(Controller::action(), "index");
	}
	
	function test_action_shouldReturnQueryVariableIfNoCustomValue()
	{
		$_GET["action"] = "bar";
		$value = Controller::action();
		$_GET["action"] = null;
		
		$this->assertEqual($value, "bar");
	}
	
	function test_action_shouldReturnCustomValueIfAny()
	{
		$_GET["action"] = "bar";
		
		$this->assertEqual(Controller::action("foo"), "foo");
		
		$value = Controller::action();
		Controller::action("");
		$_GET["action"] = null;
		
		$this->assertEqual($value, "foo");
	}
	
	function test_name_shouldReturnEmptyStringForNoQueryVariableAndNoCustomValue()
	{
		$this->assertEqual(Controller::name(), "");
	}
	
	function test_name_shouldReturnQueryVariableIfNoCustomValue()
	{
		$_GET["controller"] = "bar";
		$value = Controller::name();
		$_GET["controller"] = null;
		
		$this->assertEqual($value, "bar");
	}
	
	function test_name_customValueShouldOverrideQueryVariable()
	{
		$_GET["controller"] = "bar";
		
		$this->assertEqual(Controller::name("foo"), "foo");
		
		$value = Controller::name();
		Controller::name("");
		$_GET["controller"] = null;
		
		$this->assertEqual($value, "foo");
	}
}

?>
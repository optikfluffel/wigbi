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
	
	function test_action_shouldReturnQueryVariableIfAnyAndNoCustomValue()
	{
		$_GET["action"] = "bar";
		$value = Controller::action();
		$_GET["action"] = null;
		
		$this->assertEqual($value, "bar");
	}
	
	function test_action_shouldSetAndReturnCustomValue()
	{
		$defaultValue = Controller::action();
		Controller::action("foo");
		$setValue = Controller::action();
		Controller::action("");
		$resetValue = Controller::action();
		
		$this->assertEqual($defaultValue, "");
		$this->assertEqual($setValue, "foo");
		$this->assertEqual($resetValue, "");
	}
	
	function test_action_customValueShouldOverrideQueryVariable()
	{
		$_GET["action"] = "bar";
		Controller::action("foo");
		$value = Controller::action();
		Controller::action("");
		$_GET["action"] = null;
		
		$this->assertEqual($value, "foo");
	}
	
	function test_name_shouldReturnEmptyStringForNoQueryVariableAndNoCustomValue()
	{
		$this->assertEqual(Controller::name(), "");
	}
	
	function test_name_shouldReturnQueryVariableIfAnyAndNoCustomValue()
	{
		$_GET["controller"] = "bar";
		$value = Controller::name();
		$_GET["controller"] = null;
		
		$this->assertEqual($value, "bar");
	}
	
	function test_name_shouldSetAndReturnCustomValue()
	{
		$defaultValue = Controller::name();
		$setValue = Controller::name("foo");
		$resultValue = Controller::name();
		$resetValue = Controller::name("");
		
		$this->assertEqual($defaultValue, "");
		$this->assertEqual($setValue, "foo");
		$this->assertEqual($resultValue, "foo");
		$this->assertEqual($resetValue, "");
	}
	
	function test_name_customValueShouldOverrideQueryVariable()
	{
		$_GET["controller"] = "bar";
		Controller::name("foo");
		$value = Controller::name();
		Controller::name("");
		$_GET["controller"] = null;
		
		$this->assertEqual($value, "foo");
	}
}

?>
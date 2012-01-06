<?php

class SessionHandlerBehavior extends UnitTestCase
{
	private $sessionHandler;
	

	function SessionHandlerBehavior()
	{
		$this->UnitTestCase("SessionHandler");
	}
	
	function setUp()
	{
		$this->sessionHandler = new SessionHandler();
	}
	
	function tearDown() { }
	
	
	
	function test_constructor_shouldInitializeDefaultObject()
	{
		$this->assertEqual($this->sessionHandler->applicationName(), "");
	}
	
	function test_constructor_shouldInitializeCustomObject()
	{
		$this->sessionHandler = new SessionHandler("myApp");
		$this->assertEqual($this->sessionHandler->applicationName(), "myApp");
	}
			
	
	
	function test_applicationName_shouldReturnCorrectValue()
	{
		$this->assertEqual($this->sessionHandler->applicationName(), "");
	}
	
	function test_sessionFolder_shouldSetValue()
	{
		$this->assertEqual($this->sessionHandler->applicationName("myApp"), "myApp");
		$this->assertEqual($this->sessionHandler->applicationName(), "myApp");
	}
	
	
	
	function test_clear_shouldNotFailForNonExistingData()
	{
		$this->sessionHandler->clear("myData");
	}
	
	function test_clear_shouldClearExistingData()
	{
		$this->sessionHandler->set("myData", "foo");
		$this->sessionHandler->clear("myData");
		
		$this->assertEqual($this->sessionHandler->get("myData"), null);
	}
	
	function test_get_shouldReturnNullForNonExistingVariable()
	{
		$this->assertEqual($this->sessionHandler->get("myVariable"), null);
	}
	
	function test_set_get_shouldReturnNullForDifferentApplicationName()
	{
		$this->sessionHandler->applicationName("myApp");
		$this->sessionHandler->set("myData", "foo");
		$this->sessionHandler->applicationName("yourApp");
		
		$this->assertEqual($this->sessionHandler->get("myData"), null);
	}
	
	function test_set_get_shouldSetAndReturnString()
	{
		$this->sessionHandler->applicationName("myApp");
		$this->sessionHandler->set("myData", "foo");
		
		$this->assertEqual($this->sessionHandler->get("myData"), "foo");
	}
	
	function test_set_get_shouldSetAndReturnObject()
	{
		$obj = new SessionHandler("some_session_folder");
		$this->sessionHandler->applicationName("myApp");
		$this->sessionHandler->set("myData", $obj);
		
		$this->assertEqual($this->sessionHandler->get("myData"), $obj);
	}
}

?>
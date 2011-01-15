<?php

class ContextBehavior extends UnitTestCase
{
	function ContextBehavior()
	{
		$this->UnitTestCase("Context");
	}
	
	function setUp() { }
	
	function tearDown() { }
			
	
	
	function test_get_shouldReturnNullForNonExistingKey()
	{
		$this->assertEqual(Context::get("foo"), null);
	}

	function test_get_shouldReturnExistingKey()
	{
		$_GET["foo"] = "bar";
		
		$this->assertEqual(Context::get("foo"), "bar");
		
		$_GET["foo"] = null;
	}
	
	function test_post_shouldReturnNullForNonExistingKey()
	{
		$this->assertEqual(Context::post("foo"), null);
	}

	function test_post_shouldReturnExistingKey()
	{
		$_POST["foo"] = "bar";
		
		$this->assertEqual(Context::post("foo"), "bar");
		
		$_POST["foo"] = null;
	}
}

?>
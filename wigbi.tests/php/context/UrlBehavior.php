<?php

	class ContextBehavior extends UnitTestCase
	{
		private $_context;
		
		
		function setUp() { }
		
		function tearDown() { } 
		
		
		public function test_current_shouldReturnConcatenatedString()
		{
			$url = 
			$this->assertNull($this->_context->server("foo"));
			
			$_SERVER["foo"] = "bar";
			$this->assertEqual($this->_context->server("foo"), "bar");
			unset($_SERVER["foo"]);
			
			$this->assertNull($this->_context->server("foo"));
		}
	}

?>
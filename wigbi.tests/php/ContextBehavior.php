<?php

	class ContextBehavior extends UnitTestCase
	{
		private $_context;
		
		
		function setUp()
		{
			$this->_context = Context::instance();
		}
		
		function tearDown() { }
		
		
		public function test_get_shouldReturnFallbackForMissingKey()
		{
			$this->assertEqual($this->_context->get("foo", 42), 42);
		}
		
		public function test_get_shouldReturnExistingKeyValue()
		{
			$this->assertNull($this->_context->get("foo"));
			
			$_GET["foo"] = "bar";
			$this->assertEqual($this->_context->get("foo"), "bar");
			$_GET["foo"] = null;
			
			$this->assertNull($this->_context->get("foo"));
		}
		
		public function test_post_shouldReturnFallbackForMissingKey()
		{
			$this->assertEqual($this->_context->post("foo", 42), 42);
		}
		
		public function test_post_shouldReturnExistingKeyValue()
		{
			$this->assertNull($this->_context->post("foo"));
			
			$_POST["foo"] = "bar";
			$this->assertEqual($this->_context->post("foo"), "bar");
			$_POST["foo"] = null;
			
			$this->assertNull($this->_context->post("foo"));
		}
	}

?>
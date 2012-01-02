<?php

	class ContextBehavior extends UnitTestCase
	{
		private $_context;
		
		
		function setUp()
		{
			$this->_context = Context::instance();
		}
		
		function tearDown() { } 
		
		
		public function test_cookie_shouldReturnFallbackForMissingKey()
		{
			$this->assertEqual($this->_context->cookie("foo", 42), 42);
		}
		
		public function test_cookie_shouldReturnExistingKeyValue()
		{
			$this->assertNull($this->_context->cookie("foo"));
			
			$_COOKIE["foo"] = "bar";
			$this->assertEqual($this->_context->cookie("foo"), "bar");
			unset($_COOKIE["foo"]);
			
			$this->assertNull($this->_context->cookie("foo"));
		}
		
		public function test_env_shouldReturnFallbackForMissingKey()
		{
			$this->assertEqual($this->_context->env("foo", 42), 42);
		}
		
		public function test_env_shouldReturnExistingKeyValue()
		{
			$this->assertNull($this->_context->env("foo"));
			
			$_ENV["foo"] = "bar";
			$this->assertEqual($this->_context->env("foo"), "bar");
			unset($_ENV["foo"]);
			
			$this->assertNull($this->_context->env("foo"));
		}
		
		public function test_files_shouldReturnFallbackForMissingKey()
		{
			$this->assertEqual($this->_context->files("foo", 42), 42);
		}
		
		public function test_files_shouldReturnExistingKeyValue()
		{
			$this->assertNull($this->_context->files("foo"));
			
			$_FILES["foo"] = "bar";
			$this->assertEqual($this->_context->files("foo"), "bar");
			unset($_FILES["foo"]);
			
			$this->assertNull($this->_context->files("foo"));
		}
		
		public function test_get_shouldReturnFallbackForMissingKey()
		{
			$this->assertEqual($this->_context->get("foo", 42), 42);
		}
		
		public function test_get_shouldReturnExistingKeyValue()
		{
			$this->assertNull($this->_context->get("foo"));
			
			$_GET["foo"] = "bar";
			$this->assertEqual($this->_context->get("foo"), "bar");
			unset($_GET["foo"]);
			
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
			unset($_POST["foo"]);
			
			$this->assertNull($this->_context->post("foo"));
		}
		
		public function test_request_shouldReturnFallbackForMissingKey()
		{
			$this->assertEqual($this->_context->request("foo", 42), 42);
		}
		
		public function test_request_shouldReturnExistingKeyValue()
		{
			$this->assertNull($this->_context->request("foo"));
			
			$_REQUEST["foo"] = "bar";
			$this->assertEqual($this->_context->request("foo"), "bar");
			unset($_REQUEST["foo"]);
			
			$this->assertNull($this->_context->request("foo"));
		}
		
		public function test_server_shouldReturnFallbackForMissingKey()
		{
			$this->assertEqual($this->_context->server("foo", 42), 42);
		}
		
		public function test_server_shouldReturnExistingKeyValue()
		{
			$this->assertNull($this->_context->server("foo"));
			
			$_SERVER["foo"] = "bar";
			$this->assertEqual($this->_context->server("foo"), "bar");
			unset($_SERVER["foo"]);
			
			$this->assertNull($this->_context->server("foo"));
		}
		
		public function test_session_shouldReturnFallbackForMissingKey()
		{
			$this->assertEqual($this->_context->session("foo", 42), 42);
		}
		
		public function test_session_shouldReturnExistingKeyValue()
		{
			$this->assertNull($this->_context->session("foo"));
			
			$_SESSION["foo"] = "bar";
			$this->assertEqual($this->_context->session("foo"), "bar");
			unset($_SESSION["foo"]);
			
			$this->assertNull($this->_context->session("foo"));
		}
	}

?>
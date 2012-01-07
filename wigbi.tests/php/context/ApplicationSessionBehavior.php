<?php

	class ApplicationSessionBehavior extends UnitTestCase
	{
		private $_session;
		private $_sessionForAnotherApp;
		
		
		function setUp()
		{
			$this->_session = new ApplicationSession("foo");
			$this->_sessionForAnotherApp = new ApplicationSession("bar");
		}
		
		function tearDown()
		{
			$this->_session->clear("foo");
		}
		
		
		public function test_clear_shouldClearExistingKey()
		{
			$this->_session->set("foo", "bar");
			$this->_session->clear("foo");
			
			$result = $this->_session->get("foo", 42);
			
			$this->assertEqual($result, 42);
		}
		
		public function test_get_shouldReturnFallbackForNonExistingKey()
		{
			$result = $this->_session->get("foo", 42);
			
			$this->assertEqual($result, 42);
		}
		
		public function test_get_shouldReturnExistingKeyValue()
		{
			$this->_session->set("foo", "bar");
			
			$result = $this->_session->get("foo", 42);
			
			$this->assertEqual($result, "bar");
		}
		
		public function test_set_shouldHandleSimpleInstance()
		{
			$this->_session->set("foo", "bar");
			
			$data = $this->_session->get("foo", 42);
			
			$this->assertEqual($data, "bar");
		}
		
		public function test_set_shouldHandleComplexInstance()
		{
			$data = new CacheItem("foo", "bar");
			$this->_session->set("foo", $data);
			
			$data = $this->_session->get("foo", 42);
			
			$this->assertEqual($data->data(), "foo");
			$this->assertEqual($data->expires(), "bar");
		}
		
		public function test_set_dataShouldOnlyBeAvailableToSPecificApp()
		{
			$this->_session->set("foo", "bar");
			$this->_sessionForAnotherApp->set("bar", "foo");
			
			
			$this->assertEqual($this->_session->get("foo"), "bar");
			$this->assertEqual($this->_session->get("bar"), null);
			$this->assertEqual($this->_sessionForAnotherApp->get("foo"), null);
			$this->assertEqual($this->_sessionForAnotherApp->get("bar"), "foo");
		}
	}

?>
<?php

	class SessionBehavior extends UnitTestCase
	{
		private $_session;
		
		
		function setUp()
		{
			$this->_session = new Session();
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
			$session1 = new Session("foo");
			$session2 = new Session("bar");
			
			$session1->set("foo", "bar");
			$session2->set("bar", "foo");
			
			$this->assertEqual($session1->get("foo"), "bar");
			$this->assertEqual($session1->get("bar"), null);
			$this->assertEqual($session2->get("foo"), null);
			$this->assertEqual($session2->get("bar"), "foo");
		}
	}

?>
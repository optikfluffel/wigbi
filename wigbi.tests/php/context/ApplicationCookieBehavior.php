<?php

	class ApplicationCookieBehavior extends UnitTestCase
	{
		private $_cookie;
		private $_cookieForAnotherApp;
		
		
		function setUp()
		{
			$this->_cookie = new ApplicationSession("foo");
			$this->_cookieForAnotherApp = new ApplicationSession("bar");
		}
		
		function tearDown()
		{
			$this->_cookie->clear("foo");
		}
		
		
		public function test_clear_shouldClearExistingKey()
		{
			$this->_cookie->set("foo", "bar");
			$this->_cookie->clear("foo");
			
			$result = $this->_cookie->get("foo", 42);
			
			$this->assertEqual($result, 42);
		}
		
		public function test_get_shouldReturnFallbackForNonExistingKey()
		{
			$result = $this->_cookie->get("foo", 42);
			
			$this->assertEqual($result, 42);
		}
		
		public function test_get_shouldReturnExistingKeyValue()
		{
			$this->_cookie->set("foo", "bar");
			
			$result = $this->_cookie->get("foo", 42);
			
			$this->assertEqual($result, "bar");
		}
		
		public function test_set_shouldHandleSimpleInstance()
		{
			$this->_cookie->set("foo", "bar");
			
			$data = $this->_cookie->get("foo", 42);
			
			$this->assertEqual($data, "bar");
		}
		
		public function test_set_shouldHandleComplexInstance()
		{
			$data = new CacheItem("foo", "bar");
			$this->_cookie->set("foo", $data);
			
			$data = $this->_cookie->get("foo", 42);
			
			$this->assertEqual($data->data(), "foo");
			$this->assertEqual($data->expires(), "bar");
		}
		
		public function test_set_dataShouldOnlyBeAvailableToSPecificApp()
		{
			$this->_cookie->set("foo", "bar");
			$this->_cookieForAnotherApp->set("bar", "foo");
			
			
			$this->assertEqual($this->_cookie->get("foo"), "bar");
			$this->assertEqual($this->_cookie->get("bar"), null);
			$this->assertEqual($this->_cookieForAnotherApp->get("foo"), null);
			$this->assertEqual($this->_cookieForAnotherApp->get("bar"), "foo");
		}
	}

?>
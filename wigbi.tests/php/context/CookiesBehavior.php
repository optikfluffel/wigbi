<?php

	class CookiesBehavior extends UnitTestCase
	{
		private $_cookies;
		
		
		function setUp()
		{
			$this->_cookies = new Cookies();
		}
		
		
		/*
		 * TODO: Headers are sent, by...?
		 
		
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
			$cookie1 = new Cookie("foo");
			$cookie2 = new Cookie("bar");
			
			$cookie1->set("foo", "bar");
			$cookie2->set("bar", "foo");
			
			$this->assertEqual($cookie1->get("foo"), "bar");
			$this->assertEqual($cookie1->get("bar"), null);
			$this->assertEqual($cookie2->get("foo"), null);
			$this->assertEqual($cookie2->get("bar"), "foo");
		}*/
	}

?>
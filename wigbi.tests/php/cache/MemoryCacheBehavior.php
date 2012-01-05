<?php

	class MemoryCacheBehavior extends UnitTestCase
	{
		private $_cache;
		
		
		function setUp()
		{
			$this->_cache = new MemoryCache();
		}
		
		function tearDown() { }
		
		
		public function test_clear_shouldClearExistingKey()
		{
			$this->_cache->set("foo", "bar");
			$this->_cache->clear("foo");
			
			$result = $this->_cache->get("foo", 42);
			
			$this->assertEqual($result, 42);
		}
		
		public function test_get_shouldReturnFallbackForNonExistingKey()
		{
			$result = $this->_cache->get("foo", 42);
			
			$this->assertEqual($result, 42);
		}
		
		public function test_get_shouldReturnExistingKeyValue()
		{
			$this->_cache->set("foo", "bar");
			
			$result = $this->_cache->get("foo", 42);
			
			$this->assertEqual($result, "bar");
		}
		
		public function test_get_shouldDeleteExpiredDataAndReturnFallback()
		{
			$this->_cache->set("foo", "bar", -10);
			
			$data = $this->_cache->get("bar", 42);
			
			$this->assertEqual($data, 42);
		}
		
		public function test_set_shouldHandleComplexObject()
		{
			$data = new CacheItem("foo", "bar");
			$this->_cache->set("bar", $data);
			
			$data = $this->_cache->get("bar", 42);
			
			$this->assertEqual($data->data(), "foo");
			$this->assertEqual($data->expires(), "bar");
		}
	}

?>
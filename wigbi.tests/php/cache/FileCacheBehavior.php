<?php

	class FileCacheBehavior extends UnitTestCase
	{
		private $_cache;
		
		
		function setUp()
		{
			$this->_cache = new FileCache("foo");
		}
		
		function tearDown() { }
		
		
		public function test_constructor_shouldSetCacheFolder()
		{
			$this->assertEqual($this->_cache->cacheFolder(), "foo");
		}
		
		
		public function test_clear_shouldClearExistingKey()
		{
			//TODO: Requires abstract file handler
		}
		
		public function test_clear_shouldHandleNonExistingKeys()
		{
			//TODO: Requires abstract file handler
		}
		
		public function test_getFilePath_shouldReturnCorrectPath()
		{
			$this->assertEqual($this->_cache->getFilePath("bar"), "foo/cache_bar");
		}
	}

?>
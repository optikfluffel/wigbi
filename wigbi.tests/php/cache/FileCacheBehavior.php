<?php

	class FileCacheBehavior extends UnitTestCase
	{
		private $_cacheItem;
		
		
		function setUp()
		{
			Mock::generate('IFileHandler');
			$this->_fileHandler = new MockIFileHandler();
			
			$this->_cache = new FileCache("foo", $this->_fileHandler);
		}
		
		function tearDown() { }
		
		
		public function test_clear_shouldClearExistingKey()
		{
			//$connection->returns('query', 37);
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
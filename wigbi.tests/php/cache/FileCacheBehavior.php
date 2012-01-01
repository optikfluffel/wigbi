<?php

	class FileCacheBehavior extends UnitTestCase
	{
		private $_cache;
		private $_directoryHandler;
		private $_fileHandler;
		
		
		function setUp()
		{
			Mock::generate('IDirectoryHandler');
			$this->_directoryHandler = new MockIDirectoryHandler();
			Mock::generate('IFileHandler');
			$this->_fileHandler = new MockIFileHandler();
			
			$this->_cache = new FileCache("foo", $this->_directoryHandler, $this->_fileHandler);
		}
		
		function setUpCacheFile($minutes)
		{
			$this->_fileHandler->returns('exists', true);
			
			$time = $this->_cache->createTimeStamp($minutes);
			$data = serialize(new CacheItem("cached data", $time));
			$item = new CacheItem("cached data", $time);
			$this->_fileHandler->returns('read', $data);
		}
		
		function tearDown() { }
		
		
		public function test_clear_shouldClearExistingKey()
		{
			$this->_fileHandler->expectOnce("write", array("foo/cache_bar", "w", "*"));
			
			$this->_cache->clear("bar");
		}
		
		public function test_get_shouldReturnNullForNonExistingFile()
		{
			$this->_fileHandler->expectCallCount("read", 0);
			
			$data = $this->_cache->get("bar");
			
			$this->assertNull($data);
		}
		
		public function test_get_shouldAttemptToReadExistingFile()
		{
			$this->setUpCacheFile(10);
			$this->_fileHandler->expectOnce("read", array("foo/cache_bar"));
			
			$this->_cache->get("bar");
		}
		
		public function test_get_shouldDeleteExpiredFile()
		{
			$this->setUpCacheFile(-10);
			$this->_fileHandler->expectOnce("read", array("foo/cache_bar"));
			$this->_fileHandler->expectOnce("delete", array("foo/cache_bar"));
			
			$this->_cache->get("bar");
		}
		
		public function test_get_shouldReturnDeserializedCacheItem()
		{
			$this->setUpCacheFile(10);
			$time = $this->_cache->createTimeStamp(10);
			
			$result = $this->_cache->get("bar");
			
			$this->assertEqual($result->data(), "cached data");
			$this->assertEqual($result->expires(), $time);
		}
		
		public function test_getFilePath_shouldReturnCorrectPath()
		{
			$this->assertEqual($this->_cache->getFilePath("bar"), "foo/cache_bar");
		}
		
		public function test_set_shouldAttemptToCreateCacheFolderIfItDoesNotExist()
		{
			$this->_directoryHandler->expectOnce("create", array("foo"));
			
			$this->_cache->set("bar", 10);
		}
		
		public function test_set_shouldNotAttemptToCreateCacheFolderIfItDoesExist()
		{
			$this->_directoryHandler->returns('exists', True);
			$this->_directoryHandler->expectCallCount("create", 0);
			
			$this->_cache->set("bar", 10);
		}
		
		public function test_set_shouldWriteCacheDataToFile()
		{
			$this->_fileHandler->expectOnce("write", array("foo/cache_bar", "w", "*"));
			
			$this->_cache->set("bar", 10);
		}
	}

?>
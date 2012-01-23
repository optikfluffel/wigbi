<?php

	class FileCacheBehavior extends UnitTestCase
	{
		private $_cache;
		private $_fileSystem;
		
		
		function setUp()
		{
			Mock::generate('IFileSystem');
			$this->_fileSystem = new MockIFileSystem();
			
			$this->_cache = new FileCache("foo", $this->_fileSystem);
		}
		
		function setUpCacheFile($minutes)
		{
			$this->_fileSystem->returns('fileExists', true);
			
			$time = $this->_cache->createTimeStamp($minutes);
			$data = serialize(new CacheItem("cached data", $time));
			$this->_fileSystem->returns('readFile', $data);
		}
		
		function tearDown() { }
		
		
		public function test_clear_shouldClearExistingKey()
		{
			$this->_fileSystem->expectOnce("writeFile", array("foo/cache_bar", "w", "*"));
			
			$this->_cache->clear("bar");
		}
		
		public function test_get_shouldReturnFallbackForNonExistingFile()
		{
			$this->_fileSystem->expectCallCount("readFile", 0);
			
			$data = $this->_cache->get("bar", 42);
			
			$this->assertEqual($data, 42);
		}
		
		public function test_get_shouldAttemptToReadExistingFile()
		{
			$this->setUpCacheFile(10);
			$this->_fileSystem->expectOnce("readFile", array("foo/cache_bar"));
			
			$this->_cache->get("bar");
		}
		
		public function test_get_shouldDeleteExpiredDataAndReturnFallback()
		{
			$this->setUpCacheFile(-10);
			$this->_fileSystem->expectOnce("readFile", array("foo/cache_bar"));
			$this->_fileSystem->expectOnce("deleteFile", array("foo/cache_bar"));
			
			$data = $this->_cache->get("bar", 42);
			
			$this->assertEqual($data, 42);
		}
		
		public function test_get_shouldReturnExistingKeyValue()
		{
			$this->setUpCacheFile(10);
			$time = $this->_cache->createTimeStamp(10);
			
			$result = $this->_cache->get("bar");
			
			$this->assertEqual($result, "cached data");
		}
		
		public function test_getFilePath_shouldReturnCorrectPath()
		{
			$this->assertEqual($this->_cache->getFilePath("bar"), "foo/cache_bar");
		}
		
		public function test_set_shouldAttemptToCreateCacheFolderIfItDoesNotExist()
		{
			$this->_fileSystem->expectOnce("createDir", array("foo"));
			
			$this->_cache->set("bar", 10);
		}
		
		public function test_set_shouldNotAttemptToCreateCacheFolderIfItDoesExist()
		{
			$this->_fileSystem->returns('dirExists', True);
			$this->_fileSystem->expectCallCount("createDir", 0);
			
			$this->_cache->set("bar", 10);
		}
		
		public function test_set_shouldWriteCacheDataToFile()
		{
			$this->_fileSystem->expectOnce("writeFile", array("foo/cache_bar", "w", "*"));
			
			$this->_cache->set("bar", 10);
		}
	}

?>
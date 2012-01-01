<?php

	class CacheBaseBehavior extends UnitTestCase
	{
		private $_cache;
		
		
		function setUp()
		{
			$this->_cache = new MemoryCache();
		}
		
		function tearDown() { }
		
		
		public function test_createTimeStamp_shouldGenerateValidFormat()
		{
			$minutes = 10;
			$expected = date("YmdHis", mktime(date("H"), date("i") + $minutes, date("s"), date("m"), date("d"), date("Y")));
			
			$result = $this->_cache->createTimeStamp($minutes);
			
			$this->assertEqual($result, $expected);
		}
		
		public function test_createCacheData_shouldGenerateSerializedData()
		{
			$data = $this->_cache->createCacheData("foo", 10);
			
			$this->assertEqual(substr((string)$data, 0, 24), 'O:9:"CacheItem":2:{s:16:');
		}
		
		public function test_parseTimeStamp_shouldFailForInvalidFormat()
		{
			$minutes = 10;
			$expected = mktime(date("H"), date("i") + $minutes, date("s"), date("m"), date("d"), date("Y"));
			
			$result = $this->_cache->parseTimeStamp("foo");
			
			$this->assertFalse($result);
		}
		
		public function test_parseTimeStamp_shouldParseValidFormat()
		{
			$minutes = 10;
			$timeStamp = $this->_cache->createTimeStamp($minutes);
			$expected = mktime(date("H"), date("i") + $minutes, date("s"), date("m"), date("d"), date("Y"));
			
			$result = $this->_cache->parseTimeStamp($timeStamp);
			
			$this->assertEqual($result, $expected);
		}
		
		public function test_parseCacheData_shouldBeAbleToParseGeneratedData()
		{
			$data = $this->_cache->createCacheData("foo", 10);
			
			$result = $this->_cache->parseCacheData($data);
			
			$this->assertEqual($result->data(), "foo");
			$this->assertEqual($result->expires(), date("YmdHis", mktime(date("H"), date("i") + 10, date("s"), date("m"), date("d"), date("Y"))));
		}
		
		public function test_parseCacheData_shouldBeAbleToParseNonExpiredData()
		{
			$data = $this->_cache->createCacheData("foo", 10);
			
			$result = $this->_cache->parseCacheData($data);
			
			$this->assertEqual($result->expired(), false);
		}
		
		public function test_parseCacheData_shouldBeAbleToParseExpiredData()
		{
			$data = $this->_cache->createCacheData("foo", -10);
			
			$result = $this->_cache->parseCacheData($data);
			
			$this->assertEqual($result->expired(), false);
		}
	}

?>
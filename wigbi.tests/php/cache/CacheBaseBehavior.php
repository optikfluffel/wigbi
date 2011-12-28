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
	}

?>
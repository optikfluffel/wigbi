<?php

	class CacheItemBehavior extends UnitTestCase
	{
		private $_cacheItem;
		
		
		function setUp() { }
		
		function tearDown() { }
		
		
		public function test_ctor_shouldInitializeObjectProperly()
		{
			$item = new CacheItem("foo", strtotime("2012-01-02 22:00"));
			
			$this->assertEqual($item->data(), "foo");
			$this->assertEqual($item->expires(), strtotime("2012-01-02 22:00"));
		}
		
		
		public function test_expired_shouldReturnFalseForNonExpiredData()
		{
			$item = new CacheItem("foo", strtotime("2022-01-01 22:00"));
			
			$this->assertFalse($item->expired());
		}
		
		public function test_expired_shouldReturnTrueForExpiredData()
		{
			$item = new CacheItem("foo", strtotime("2012-01-01 22:00"));
			
			$this->assertTrue($item->expired());
		}

	}

?>
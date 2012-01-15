<?php

	class ClientPathIncluderBaseBehavior extends UnitTestCase
	{
		private $_includer;
		
		
		function setUp()
		{
			$this->_includer = new JavaScriptIncluder();
		}
		
		
		
		public function test_isApplicationRelative_shouldReturnFalseForProtocol()
		{
			$this->assertFalse($this->_includer->isApplicationRelative("http://www.foo.js"));
			$this->assertFalse($this->_includer->isApplicationRelative("https://www.foo.js"));
		}
		
		public function test_isApplicationRelative_shouldReturnFalseForAbsolutePath()
		{
			$this->assertFalse($this->_includer->isApplicationRelative("/foo.js"));
		}
		
		public function test_isApplicationRelative_shouldReturnTrueForRelativePath()
		{
			$this->assertTrue($this->_includer->isApplicationRelative("foo.js"));
		}
	}

?>
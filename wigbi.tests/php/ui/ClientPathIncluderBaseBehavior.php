<?php

	class ClientPathIncluderBaseBehavior extends UnitTestCase
	{
		private $_includer;
		
		
		function setUp()
		{
			$this->_includer = new JavaScriptIncluder();
		}
		
		
		
		public function test_pathIsApplicationRelative_shouldReturnFalseForProtocol()
		{
			$this->assertFalse($this->_includer->pathIsApplicationRelative("http://www.foo.js"));
			$this->assertFalse($this->_includer->pathIsApplicationRelative("https://www.foo.js"));
		}
		
		public function test_pathIsApplicationRelative_shouldReturnFalseForAbsolutePath()
		{
			$this->assertFalse($this->_includer->pathIsApplicationRelative("/foo.js"));
		}
		
		public function test_pathIsApplicationRelative_shouldReturnTrueForRelativePath()
		{
			$this->assertTrue($this->_includer->pathIsApplicationRelative("foo.js"));
		}
	}

?>
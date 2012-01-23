<?php

	class ClientPathIncluderBaseBehavior extends UnitTestCase
	{
		private $_includer;
		private $_fileSystem;
		
		
		function setUp()
		{
			Mock::generate('IFileSystem');
			$this->_fileSystem = new MockIFileSystem();
			
			$this->_includer = new JavaScriptIncluder($this->_fileSystem);
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
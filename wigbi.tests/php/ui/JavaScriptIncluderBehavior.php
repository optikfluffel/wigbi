<?php

	class JavaScriptIncluderBehavior extends UnitTestCase
	{
		private $_includer;
		private $_fileSystem;
		
		
		function setUp()
		{
			Mock::generate('IFileSystem');
			$this->_fileSystem = new MockIFileSystem();
			
			$this->_includer = new JavaScriptIncluder($this->_fileSystem);
		}
		
		
		public function test_includeFile_shouldAddSingleFile()
		{
			ob_start();
			$this->_includer->includeFile("foo.js");
			$result = ob_get_clean();
			
			$this->assertEqual($result, "<script type=\"text/javascript\" src=\"foo.js\"></script>");
		}
		
		public function test_includeFiles_shouldAddMultipleFileAsParameters()
		{
			ob_start();
			$this->_includer->includeFiles("foobar/", "foo.js", "bar.js");
			$result = ob_get_clean();
			
			$this->assertEqual($result, "<script type=\"text/javascript\" src=\"foobar/foo.js\"></script><script type=\"text/javascript\" src=\"foobar/bar.js\"></script>");
		}
	}

?>
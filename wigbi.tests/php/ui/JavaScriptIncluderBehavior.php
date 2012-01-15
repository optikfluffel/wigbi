<?php

	class JavaScriptIncluderBehavior extends UnitTestCase
	{
		private $_includer;
		
		
		function setUp()
		{
			$this->_includer = new JavaScriptIncluder();
		}
		
		
		
		public function test_includeFile_shouldNotAddClientRootToProtocolPath()
		{
			ob_start();
			$this->_includer->includeFile("http://www.foo.com/bar.js");
			$result = ob_get_clean();
			
			$this->assertEqual($result, "<script type=\"text/javascript\" src=\"http://www.foo.com/bar.js\"></script>");
		}
		
		public function test_includeFile_shouldNotAddClientRootToAbsolutePath()
		{
			ob_start();
			$this->_includer->includeFile("/bar.js");
			$result = ob_get_clean();
			
			$this->assertEqual($result, "<script type=\"text/javascript\" src=\"/bar.js\"></script>");
		}
		
		public function test_includeFile_shouldAddClientRootPathToRelativePath()
		{
			ob_start();
			$this->_includer->includeFile("bar.js");
			$result = ob_get_clean();
			
			$this->assertEqual($result, "<script type=\"text/javascript\" src=\"../bar.js\"></script>");
		}
	}

?>
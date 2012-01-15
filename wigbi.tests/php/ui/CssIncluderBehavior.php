<?php

	class CssIncluderBehavior extends UnitTestCase
	{
		private $_includer;
		
		
		function setUp()
		{
			$this->_includer = new CssIncluder();
		}
		
		
		
		public function test_includeFile_shouldNotAddClientRootToProtocolPath()
		{
			ob_start();
			$this->_includer->includeFile("http://www.foo.com/bar.css");
			$result = ob_get_clean();
			
			$this->assertEqual($result, "<link rel=\"stylesheet\" type=\"text/css\" href=\"http://www.foo.com/bar.css\" />");
		}
		
		public function test_includeFile_shouldNotAddClientRootToAbsolutePath()
		{
			ob_start();
			$this->_includer->includeFile("/bar.css");
			$result = ob_get_clean();
			
			$this->assertEqual($result, "<link rel=\"stylesheet\" type=\"text/css\" href=\"/bar.css\" />");
		}
		
		public function test_includeFile_shouldAddClientRootPathToRelativePath()
		{
			ob_start();
			$this->_includer->includeFile("bar.css");
			$result = ob_get_clean();
			
			$this->assertEqual($result, "<link rel=\"stylesheet\" type=\"text/css\" href=\"../bar.css\" />");
		}
	}

?>
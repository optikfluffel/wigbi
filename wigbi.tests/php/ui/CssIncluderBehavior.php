<?php

	class CssIncluderBehavior extends UnitTestCase
	{
		private $_includer;
		private $_fileSystem;
		
		
		function setUp()
		{
			$this->_includer = new CssIncluder($this->_fileSystem);
		}
		
		
		
		public function test_includeFile_shouldAddSingleFile()
		{
			ob_start();
			$this->_includer->includeFile("foo.css");
			$result = ob_get_clean();
			
			$this->assertEqual($result, "<link rel=\"stylesheet\" type=\"text/css\" href=\"foo.css\" />");
		}
		
		public function test_includeFiles_shouldAddMultipleFileAsParameters()
		{
			ob_start();
			$this->_includer->includeFiles("foobar/", "foo.css", "bar.css");
			$result = ob_get_clean();
			
			$this->assertEqual($result, "<link rel=\"stylesheet\" type=\"text/css\" href=\"foobar/foo.css\" /><link rel=\"stylesheet\" type=\"text/css\" href=\"foobar/bar.css\" />");
		}
	}

?>
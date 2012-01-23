<?php

	class CssIncluderBehavior extends UnitTestCase
	{
		private $_includer;
		private $_fileSystem;
		
		
		function setUp()
		{
			Mock::generate('IFileSystem');
			$this->_fileSystem = new MockIFileSystem();
			
			$this->_includer = new CssIncluder($this->_fileSystem);
		}
		
		
		
		public function test_includePath_shouldAddSingleFile()
		{
			ob_start();
			$this->_includer->includePath("bar.css");
			$result = ob_get_clean();
			
			$this->assertEqual($result, "<link rel=\"stylesheet\" type=\"text/css\" href=\"bar.css\" />");
		}
		
		public function test_includePath_shouldAddAllFilesWithinDirectory()
		{
			$this->_fileSystem->returns("dirExists", true);
			$this->_fileSystem->returns("glob", array("foo.css", "http://www.foo.bar/bar.css"));
			
			$this->_fileSystem->expect("glob", array("foobar/*.css"));
			
			ob_start();
			$this->_includer->includePath("foobar");
			$result = ob_get_clean();
			
			$this->assertEqual($result, "<link rel=\"stylesheet\" type=\"text/css\" href=\"foo.css\" /><link rel=\"stylesheet\" type=\"text/css\" href=\"http://www.foo.bar/bar.css\" />");
		}
	}

?>
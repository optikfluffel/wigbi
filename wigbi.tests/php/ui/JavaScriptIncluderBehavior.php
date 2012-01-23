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
		
		
		/*public function test_includePath_shouldNotAddClientRootToProtocolPath()
		{
			ob_start();
			$this->_includer->includePath("http://www.foo.com/bar.js");
			$result = ob_get_clean();
			
			$this->assertEqual($result, "<script type=\"text/javascript\" src=\"http://www.foo.com/bar.js\"></script>");
		}
		
		public function test_includePath_shouldNotAddClientRootToAbsolutePath()
		{
			ob_start();
			$this->_includer->includePath("/bar.js");
			$result = ob_get_clean();
			
			$this->assertEqual($result, "<script type=\"text/javascript\" src=\"/bar.js\"></script>");
		}
		
		public function test_includePath_shouldAddClientRootPathToRelativePath()
		{
			ob_start();
			$this->_includer->includePath("bar.js");
			$result = ob_get_clean();
			
			$this->assertEqual($result, "<script type=\"text/javascript\" src=\"../bar.js\"></script>");
		}*/
		
		public function test_includePath_shouldAddSingleFile()
		{
			ob_start();
			$this->_includer->includePath("bar.js");
			$result = ob_get_clean();
			
			$this->assertEqual($result, "<script type=\"text/javascript\" src=\"bar.js\"></script>");
		}
		
		public function test_includePath_shouldAddAllFilesWithinDirectory()
		{
			$this->_fileSystem->returns("dirExists", true);
			$this->_fileSystem->returns("glob", array("foo.js", "http://www.foo.bar/bar.js"));
			
			$this->_fileSystem->expect("glob", array("foobar/*.js"));
			
			ob_start();
			$this->_includer->includePath("foobar");
			$result = ob_get_clean();
			
			$this->assertEqual($result, "<script type=\"text/javascript\" src=\"foo.js\"></script><script type=\"text/javascript\" src=\"http://www.foo.bar/bar.js\"></script>");
		}
	}

?>
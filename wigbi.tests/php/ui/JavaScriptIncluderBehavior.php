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
		
		
		public function test_includePath_shouldAddSingleFile()
		{
			ob_start();
			$this->_includer->includePath("bar.js");
			$result = ob_get_clean();
			
			$this->assertEqual($result, "<script type=\"text/javascript\" src=\"bar.js\"></script>");
		}
	}

?>
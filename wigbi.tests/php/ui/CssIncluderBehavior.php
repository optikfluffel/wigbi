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
	}

?>
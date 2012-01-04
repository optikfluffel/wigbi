<?php

	class ViewBehavior extends UnitTestCase
	{
		private $_master;
		
		
		function setUp()
		{
			Mock::generate('IFileIncluder');
			$this->_fileIncluder = new MockIFileIncluder();
		}
		
		function tearDown() { } 
		
		
		public function test_fileIncluder_shouldUseFileIncluderByDefault()
		{
			$includer = View::fileIncluder();
			
			$this->assertEqual(get_class(View::fileIncluder()), "FileIncluder");
		}
		
		public function test_fileIncluder_shouldUseCustomClassAndResetOnNull()
		{
			$includer = View::fileIncluder($this->_fileIncluder);
			
			$this->assertEqual(get_class(View::fileIncluder()), "MockIFileIncluder");
			
			$includer = View::fileIncluder(null);
			
			$this->assertEqual(get_class(View::fileIncluder()), "FileIncluder");
		}
	}

?>
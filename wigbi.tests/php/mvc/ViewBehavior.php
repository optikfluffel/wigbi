<?php

	class ViewBehavior extends UnitTestCase
	{
		private $_master;
		
		
		function setUp()
		{
			Mock::generate('IFileIncluder');
			$this->_fileIncluder = new MockIFileIncluder();
			
			$includer = View::fileIncluder($this->_fileIncluder);
		}
		
		function tearDown() { } 
		
		
		public function test_add_shouldHandleNoModel()
		{
			$includer = View::add("foo", null);
			
			$this->assertNull(View::model());
		}
		
		public function test_add_shouldHandleModel()
		{
			$includer = View::add("foo", "bar");
			
			//How to test this?
		}
		
		public function test_add_shouldResetModelWhenLeavingAdd()
		{
			$includer = View::add("foo", "bar");
			
			$this->assertNull(View::model());
		}
		
		public function test_add_shouldRequireViewFile()
		{
			$this->_fileIncluder->expect("requireFile", array("foo"));
			
			$includer = View::add("foo", "bar");
		}
		
		public function test_fileIncluder_shouldUseFileIncluderByDefault()
		{
			$includer = View::fileIncluder(null);
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
		
		public function test_model_shouldReturnNullForNoData()
		{
			$this->assertNull(View::model());
		}
		
		public function test_viewData_shouldReturnNullForMissingKey()
		{
			$this->assertNull(View::viewData("foo"));
		}
		
		public function test_viewData_shouldReturnSetValue()
		{
			$this->assertEqual(View::viewData("foo", "bar"), "bar");
		}
		
		public function test_viewData_shouldReturnPreviousSetValue()
		{
			View::viewData("foo", "bar");
			
			$this->assertEqual(View::viewData("foo"), "bar");
		}
	}

?>
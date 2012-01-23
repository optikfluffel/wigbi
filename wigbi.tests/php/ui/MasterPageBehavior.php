<?php

	class MasterPageBehavior extends UnitTestCase
	{
		private $_master;
		
		
		function setUp()
		{
			Mock::generate('IPhpFileIncluder');
			$this->_fileIncluder = new MockIPhpFileIncluder();
		}
		
		function tearDown() { } 
		
		
		public function test_build_shouldAbortForNonSetfile()
		{
			ob_start();
			MasterPage::build();
			$result = ob_get_clean();
			
			$this->assertEqual($result, "");
		}
		
		public function test_build_shouldAbortForSetfile()
		{
			MasterPage::file("foo");
			MasterPage::fileIncluder($this->_fileIncluder);
			
			$this->_fileIncluder->expectOnce("includeFile", array("foo"));
			
			ob_start();
			MasterPage::build();
			$result = ob_get_clean();
			
			MasterPage::file(null);
			$includer = MasterPage::fileIncluder(null);
		}
		
		public function test_content_shouldOutput()
		{
			MasterPage::setContent("foo", "bar");
			
			ob_start();
			MasterPage::content("foo");
			$result = ob_get_clean();
			
			$this->assertEqual($result, "bar");
			
			MasterPage::setContent("foo", null);
		}
		
		public function test_fileIncluder_shouldUseFileIncluderByDefault()
		{
			$includer = MasterPage::fileIncluder();
			
			$this->assertEqual(get_class(MasterPage::fileIncluder()), "PhpFileIncluder");
		}
		
		public function test_fileIncluder_shouldUseCustomClassAndResetOnNull()
		{
			$includer = MasterPage::fileIncluder($this->_fileIncluder);
			
			$this->assertEqual(get_class(MasterPage::fileIncluder()), "MockIPhpFileIncluder");
			
			$includer = MasterPage::fileIncluder(null);
			
			$this->assertEqual(get_class(MasterPage::fileIncluder()), "PhpFileIncluder");
		}
		
		public function test_file_shouldGetSetValue()
		{
			$this->assertNull(MasterPage::file());
			
			MasterPage::file("foo");
			
			$this->assertEqual(MasterPage::file(), "foo");
		}
		
		public function test_openClose_shouldPopulateContentArea()
		{
			MasterPage::open("content");
			print "foo";
			MasterPage::close();
			
			ob_start();
			MasterPage::content("content");
			$result = ob_get_clean();
			
			$this->assertEqual($result, "foo");
		}
		
		public function test_setContent_shouldNotOutput()
		{
			ob_start();
			MasterPage::setContent("foo", "bar");
			$result = ob_get_clean();
			
			$this->assertEqual($result, "");
		}
	}

?>
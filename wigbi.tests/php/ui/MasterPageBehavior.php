<?php

	class MasterPageBehavior extends UnitTestCase
	{
		private $_master;
		
		
		function setUp()
		{
			Mock::generate('IFileIncluder');
			$this->_fileIncluder = new MockIFileIncluder();
			
			$this->_master = new MasterPage();
		}
		
		function tearDown() { } 
		
		
		public function test_build_shouldAbortForNonSetFilePath()
		{
			ob_start();
			MasterPage::build();
			$result = ob_get_clean();
			
			$this->assertEqual($result, "");
		}
		
		public function test_build_shouldAbortForSetFilePath()
		{
			MasterPage::filePath("foo");
			MasterPage::fileIncluder($this->_fileIncluder);
			
			$this->_fileIncluder->expectOnce("requireFile", array("foo"));
			
			ob_start();
			MasterPage::build();
			$result = ob_get_clean();
			
			MasterPage::filePath(null);
			$includer = MasterPage::fileIncluder(null);
		}
		
		public function test_content_shouldGetSetValue()
		{
			$this->assertNull(MasterPage::content("foo"));
			
			MasterPage::content("foo", "bar");
			
			$this->assertEqual(MasterPage::content("foo"), "bar");
		}
		
		public function test_fileIncluder_shouldUseFileIncluderByDefault()
		{
			$includer = MasterPage::fileIncluder();
			
			$this->assertEqual(get_class(MasterPage::fileIncluder()), "FileIncluder");
		}
		
		public function test_fileIncluder_shouldUseCustomClassAndResetOnNull()
		{
			$includer = MasterPage::fileIncluder($this->_fileIncluder);
			
			$this->assertEqual(get_class(MasterPage::fileIncluder()), "MockIFileIncluder");
			
			$includer = MasterPage::fileIncluder(null);
			
			$this->assertEqual(get_class(MasterPage::fileIncluder()), "FileIncluder");
		}
		
		public function test_filePath_shouldGetSetValue()
		{
			$this->assertNull(MasterPage::filePath());
			
			MasterPage::filePath("foo");
			
			$this->assertEqual(MasterPage::filePath(), "foo");
		}
		
		public function test_openClose_shouldPopulateContentArea()
		{
			MasterPage::open("content");
			print "foo";
			$result = MasterPage::close();
			
			$this->assertEqual($result, "foo");
		}
	}

?>
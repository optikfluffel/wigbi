<?php

	class MasterPageBehavior extends UnitTestCase
	{
		private $_master;
		
		
		function setUp()
		{
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
			//TODO
		}
		
		public function test_content_shouldGetSetValue()
		{
			$this->assertNull(MasterPage::content("foo"));
			
			MasterPage::content("foo", "bar");
			
			$this->assertEqual(MasterPage::content("foo"), "bar");
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
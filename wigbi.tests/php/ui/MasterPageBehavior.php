<?php

	class MasterPageBehavior extends UnitTestCase
	{
		private $_master;
		
		
		function setUp()
		{
			$this->_master = new MasterPage();
		}
		
		function tearDown() { } 
		
		
		public function test_filePath_shouldGetSetValue()
		{
			$this->assertNull(MasterPage::filePath());
			
			MasterPage::filePath("foo");
			
			$this->assertEqual(MasterPage::filePath(), "foo");
		}
	}

?>
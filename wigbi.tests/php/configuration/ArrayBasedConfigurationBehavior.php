<?php

	class ArrayBasedConfigurationBehavior extends UnitTestCase
	{
		private $_config;
		private $_data;
		
		
		function setUp()
		{
			$this->_data = array();
			$this->_data["foo"] = "bar"; 
			$this->_data["bar"] = "foo"; 
			
			$this->_config = new ArrayBasedConfiguration($this->_data);
		}
		
		function setUpSectionData()
		{
			$this->_data = array();
			$this->_data["section1"] = array();
			$this->_data["section2"] = array();
			$this->_data["section1"]["foo"] = "bar"; 
			$this->_data["section2"]["bar"] = "foo"; 
			
			$this->_config = new ArrayBasedConfiguration($this->_data);
		}
		
		function tearDown() { }
		
		
		public function test_data_shouldReturnParsedFileContent()
		{
			$data = $this->_config->data();
			
			$this->assertEqual($data, $this->_data);
		}
		
		public function test_get_shouldReturnNullForNonExistingData()
		{
			$this->assertNull($this->_config->get("foobar"));
			$this->assertNull($this->_config->get("foobar", "barfoo"));
		}
		
		public function test_get_shouldReturnNonSectionData()
		{
			$this->assertEqual($this->_config->get("foo"), "bar");
			$this->assertEqual($this->_config->get("bar"), "foo");
		}
		
		public function test_get_shouldReturnSectionData()
		{
			$this->setUpSectionData();
			
			$this->assertEqual($this->_config->get("foo", "section1"), "bar");
			$this->assertEqual($this->_config->get("bar", "section2"), "foo");
		}
			
	}

?>
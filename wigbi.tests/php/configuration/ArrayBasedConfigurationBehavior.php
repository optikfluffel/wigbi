<?php

	class ArrayBasedConfigurationBehavior extends UnitTestCase
	{
		private $_config;
		private $_data;
		
		
		function setUp()
		{
			$this->_data = array();
			$this->_data["key1"] = "value1"; 
			$this->_data["key2"] = "value2"; 
			
			$this->setupConfiguration();
		}
		
		function setUpConfiguration()
		{
			$this->_config = new ArrayBasedConfiguration($this->_data);
		}
		
		function setUpSectionData()
		{
			$this->_data["section1"] = array();
			$this->_data["section2"] = array();
			$this->_data["section1"]["key1"] = "value1"; 
			$this->_data["section2"]["key2"] = "value2";  
			
			$this->setupConfiguration();
		}
		
		function tearDown() { }
		
		
		public function test_data_shouldReturnParsedFileContent()
		{
			$data = $this->_config->data();
			
			$this->assertEqual($data, $this->_data);
		}
		
		public function test_get_shouldReturnNullForNonExistingNonSectionData()
		{
			$this->assertNull($this->_config->get("nonkey"));
		}
		
		public function test_get_shouldReturnNullForNonExistingSectionData()
		{
			$this->assertNull($this->_config->get("section1", "nonkey"));
		}
		
		public function test_get_shouldReturnNonSectionData()
		{
			$this->assertEqual($this->_config->get("key1"), "value1");
			$this->assertEqual($this->_config->get("key2"), "value2");
		}
		
		public function test_get_shouldReturnSectionData()
		{
			$this->setUpSectionData();
			
			$this->assertEqual($this->_config->get("section1", "key1"), "value1");
			$this->assertEqual($this->_config->get("section2", "key2"), "value2");
		}
	}

?>
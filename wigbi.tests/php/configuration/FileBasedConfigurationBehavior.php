<?php

	class FileBasedConfigurationBehavior extends UnitTestCase
	{
		private $_fileReader;
		private $_config;
		private $_data;
		
		
		function setUp()
		{
			$this->_data = array();
			$this->_data["foo"] = "bar"; 
			$this->_data["bar"] = "foo"; 
			
			Mock::generate('IConfigFileReader');
			$this->_fileReader = new MockIConfigFileReader();
			$this->_fileReader->returns('readFile', $this->_data);
			
			$this->_config = new FileBasedConfiguration("foo", $this->_fileReader);
		}
		
		function setUpSectionData()
		{
			$this->_data = array();
			$this->_data["section1"] = array();
			$this->_data["section2"] = array();
			$this->_data["section1"]["foo"] = "bar"; 
			$this->_data["section2"]["bar"] = "foo"; 
			
			Mock::generate('IConfigFileReader');
			$this->_fileReader = new MockIConfigFileReader();
			$this->_fileReader->returns('readFile', $this->_data);
			
			$this->_config = new FileBasedConfiguration("foo", $this->_fileReader);
		}
		
		function tearDown() { }
		
		
		public function test_ctor_shouldReadConfigFile()
		{
			$this->_fileReader->expectOnce("readFile", array("foo"));
		}
		
		
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
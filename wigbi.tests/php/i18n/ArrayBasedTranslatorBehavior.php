<?php

	class ArrayBasedTranslatorBehavior extends UnitTestCase
	{
		private $_translator;
		private $_data;
		
		
		function setUp()
		{
			$this->_data = array();
			$this->_data["key1"] = "value1";
			$this->_data["key2"] = "value2";
			$this->_data["hierarchy_key2"] = "value3"; 
			
			$this->setupConfiguration();
		}
		
		function setUpConfiguration()
		{
			$this->_translator = new ArrayBasedTranslator($this->_data);
		}
		
		function setUpSectionData()
		{
			$this->_data["section1"] = array();
			$this->_data["section2"] = array();
			$this->_data["section1"]["key1"] = "value1"; 
			$this->_data["section2"]["key2"] = "value2";  
			$this->_data["section2"]["hierarchy_key2"] = "value3";  
			
			$this->setupConfiguration();
		}
		
		function tearDown() { }
		
		
		public function test_data_shouldReturnParsedFileContent()
		{
			$data = $this->_translator->data();
			
			$this->assertEqual($data, $this->_data);
		}
		
		public function test_translate_shouldReturnBracketKeyForNonExistingNonSectionData()
		{
			$this->assertEqual($this->_translator->translate("nonkey"), "[nonkey]");
		}
		
		public function test_translate_shouldReturnNullForNonExistingSectionData()
		{
			$this->assertEqual($this->_translator->translate("section1", "nonkey"), "[nonkey]");
		}
		
		public function test_translate_shouldReturnNonHierarchicalNonSectionData()
		{
			$this->assertEqual($this->_translator->translate("key1"), "value1");
			$this->assertEqual($this->_translator->translate("key2"), "value2");
		}
		
		public function test_translate_shouldReturnHierarchicalNonSectionData()
		{
			$this->assertEqual($this->_translator->translate("nonexisting_hier_key2"), "value2");
			$this->assertEqual($this->_translator->translate("existing_hierarchy_key2"), "value3");
		}
		
		public function test_translate_shouldReturnNonHierarchicalSectionData()
		{
			$this->setUpSectionData();
			
			$this->assertEqual($this->_translator->translate("section1", "key1"), "value1");
			$this->assertEqual($this->_translator->translate("section2", "key2"), "value2");
		}
		
		public function test_translate_shouldReturnHierarchicalSectionData()
		{
			$this->setUpSectionData();
			
			$this->assertEqual($this->_translator->translate("section2", "nonexisting_hier_key2"), "value2");
			$this->assertEqual($this->_translator->translate("section2", "existing_hierarchy_key2"), "value3");
		}
	}

?>
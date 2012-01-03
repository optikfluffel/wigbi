<?php

	class FileBasedTranslatorBehavior extends UnitTestCase
	{
		private $_fileReader;
		private $_translator;
		private $_data;
		
		
		function setUp()
		{
			$this->_data = array();
			$this->_data["foo"] = "bar";
			$this->_data["specific_middle_general"] = "Specific";
			$this->_data["middle_general"] = "Middle";
			$this->_data["general"] = "General"; 
			$this->_data["bar"] = "General"; 
			
			Mock::generate('IConfigFileReader');
			$this->_fileReader = new MockIConfigFileReader();
			$this->_fileReader->returns('readFile', $this->_data);
			
			$this->_translator = new FileBasedTranslator("foo", $this->_fileReader);
		}
		
		function tearDown() { }
		
		
		public function test_ctor_shouldReadConfigFile()
		{
			$this->_fileReader->expectOnce("readFile", array("foo"));
		}
		
		
		
		public function test_translate_shouldReturnDefaultValueForNonExistingTranslation()
		{
			$this->assertEqual($this->_translator->translate("foobar"), "[foobar]");
		}
		
		public function test_translate_shouldTranslateNonHierarchicalKey()
		{
			$this->assertEqual($this->_translator->translate("foo"), "bar");
		}
		
		public function test_translate_shouldTranslateNonHierarchicalKeys()
		{
			$this->assertEqual($this->_translator->translate("specific_middle_general"), "Specific");
			$this->assertEqual($this->_translator->translate("middle_general"), "Middle");
			$this->assertEqual($this->_translator->translate("general"), "General");
		}
		
		public function test_translate_shouldFindGeneralTranslationTranslateNonHierarchicalKeys()
		{
			$this->assertEqual($this->_translator->translate("foo_bar_general"), "General");
		}
	}

?>
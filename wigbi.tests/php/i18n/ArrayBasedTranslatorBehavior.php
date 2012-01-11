<?php

	class ArrayBasedTranslatorBehavior extends UnitTestCase
	{
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
			
			$this->_translator = new ArrayBasedTranslator($this->_data);
		}
		
		function tearDown() { }
		
		
		
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
<?php

	class FileConfigurationBehavior extends UnitTestCase
	{
		private $_fileReader;
		private $_config;
		
		
		function setUp()
		{
			Mock::generate('IConfigFileReader');
			$this->_fileReader = new MockIConfigFileReader();
			
			$this->_config = new FileConfiguration("foo", $this->_fileReader);
		}
		
		function tearDown() { }
		
		
		public function test_ctor_shouldReadConfigFile()
		{
			$this->_fileReader->expectCallCount("readFile", 1);
		}
	}

?>
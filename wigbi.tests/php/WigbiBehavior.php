<?php

	class WigbiBehavior extends UnitTestCase
	{
		public function test_configFile_shouldBeRelativeToTestPage()
		{
			$this->assertEqual(Wigbi::configFile(), "../wigbi/config.ini");
		}
		
		public function test_configFileTemplate_shouldBeRelativeToTestPage()
		{
			$this->assertEqual(Wigbi::configFileTemplate(), "../wigbi/assets/config_template.ini");
		}
		
		public function test_dataPluginsFolder_shouldBeRelativeToTestPage()
		{
			$this->assertEqual(Wigbi::dataPluginFolder(), "../wigbi/plugins/data/");
		}
		
		public function test_serverRoot_shouldBeRelativeToTestPage()
		{
			$this->assertEqual(Wigbi::serverRoot(), "../");
		}
		
		public function test_serverWigbiRoot_shouldBeRelativeToTestPage()
		{
			$this->assertEqual(Wigbi::serverWigbiRoot(), "../wigbi/");
		}
		
		public function test_uiPluginsFolder_shouldBeRelativeToTestPage()
		{
			$this->assertEqual(Wigbi::uiPluginFolder(), "../wigbi/plugins/ui/");
		}
		
		public function test_version_shouldBeTwoZeroX()
		{
			$this->assertEqual(substr(Wigbi::version(), 0, 3), "2.0");
		}
		
	}

?>
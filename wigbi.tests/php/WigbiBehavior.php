<?php

	class WigbiBehavior extends UnitTestCase
	{
		public function test_globals_shouldBeCorrect()
		{
			$globals = Wigbi::globals();
			
			$this->assertEqual($globals["root"], "../");
			$this->assertEqual($globals["config_file"], "../wigbi/config.ini");
			$this->assertEqual($globals["php_folders"], array("tools", "cache", "context", "core", "configuration", "data", "i18n", "io", "log", "mvc", "ui", "validation", ""));
			$this->assertEqual($globals["data_plugins_folder"], "../wigbi/plugins/data/");
			$this->assertEqual($globals["ui_plugins_folder"], "../wigbi/plugins/ui/");
		}
		
		public function test_bootstrap_shouldSetupAllClasses()
		{
			global $wigbi_test_config;
			$this->assertEqual(Wigbi::configuration(), $wigbi_test_config);
		}
		
		public function test_serverRoot_shouldBeRelativeToTestPage()
		{
			$this->assertEqual(Wigbi::serverRoot(), "../");
		}
		
		public function test_serverRoot_shouldAppendOptionalPath()
		{
			$this->assertEqual(Wigbi::serverRoot("wigbi/"), "../wigbi/");
		}
		
		public function test_version_shouldBeTwoZeroX()
		{
			$this->assertEqual(substr(Wigbi::version(), 0, 3), "2.0");
		}
		
	}

?>
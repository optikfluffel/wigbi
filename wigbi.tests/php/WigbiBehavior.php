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
			$this->assertEqual(Wigbi::configuration(), new ArrayBasedConfiguration($wigbi_test_config));
		}
		
		public function test_bootstrap_shouldSetupConfiguration()
		{
			$this->assertEqual(Wigbi::configuration()->get("name", "application"), "application");
			$this->assertEqual(Wigbi::configuration()->get("webRoot", "application"), "/wigbi_dev/");
			
			$this->assertEqual(Wigbi::configuration()->get("folder", "cache"), "/cache/");
		}
		
		public function test_bootstrap_shouldSetupCache()
		{
			Wigbi::cache()->set("foo", "bar");
			
			$this->assertEqual(Wigbi::cache()->get("foo"), "bar");
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
		
		
		
		public function test_start_stop_shouldToggleIsStarted()
		{
			Wigbi::start();
			
			$this->assertTrue(Wigbi::isStarted());
			
			Wigbi::stop();
			
			$this->assertFalse(Wigbi::isStarted());
			
			Wigbi::start();
			
			$this->assertTrue(Wigbi::isStarted());
		}
		
	}

?>
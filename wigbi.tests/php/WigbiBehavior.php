<?php

	class WigbiBehavior extends UnitTestCase
	{
		private $_config;
		
		
		function setUp()
		{
			$this->_config = Wigbi::configuration();
		}
		
		function tearDown()
		{
			Wigbi::configuration($this->_config);
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
		}
		
		public function test_bootstrap_shouldSetupCache()
		{
			Wigbi::cache()->set("foo", "bar");
			
			$this->assertEqual(Wigbi::cache()->get("foo"), "bar");
		}
		
		public function test_bootstrap_shouldSetupTranslator()
		{
			$this->assertEqual(Wigbi::translator()->translate("translates_hierarchical_name", "application"), "application");
		}
		
		
		public function test_globals_shouldBeCorrect()
		{
			$globals = Wigbi::globals();
			
			$this->assertEqual($globals["root"], "../");
			$this->assertEqual($globals["config_file"], "../wigbi/config.ini");
			$this->assertEqual($globals["php_folders"], array("tools", "cache", "context", "core", "configuration", "data", "i18n", "io", "log", "mvc", "ui", "validation", ""));
			$this->assertEqual($globals["data_plugins_folder"], "../wigbi/plugins/data/");
			$this->assertEqual($globals["ui_plugins_folder"], "../wigbi/plugins/ui/");
		}
		
		public function test_version_shouldBeGreaterTwoMajor()
		{
			$this->assertEqual(substr(Wigbi::version(), 0, 2), "2.");
		}
		
		
		
		
		
		public function test_serverRoot_shouldBeRelativeToTestPage()
		{
			$this->assertEqual(Wigbi::serverRoot(), "../");
		}
		
		public function test_serverRoot_shouldAppendOptionalPath()
		{
			$this->assertEqual(Wigbi::serverRoot("wigbi/"), "../wigbi/");
		}
		
		public function test_start_shouldAbortForMissingApplicationName()
		{
			Wigbi::configuration(new ArrayBasedConfiguration(array()));
			
			$message = "";
			try{ Wigbi::start(); }
			catch(exception $e) { $message = $e->getMessage(); }
			
			$this->assertEqual($message, "The application.name key in the Wigbi config file must have a value, e.g. \"My Application\".");
		}
		
		public function test_start_shouldAbortForMissingWebRootPath()
		{
			$data = array("application" => array("name" => "foo"));
			Wigbi::configuration(new ArrayBasedConfiguration($data));
			
			$message = "";
			try{ Wigbi::start(); }
			catch(exception $e) { $message = $e->getMessage(); }
			
			$this->assertEqual($message, "The application.webRoot key in the Wigbi config file must have a value, e.g. \"/myApp/\" if the site is located in http://localhost/myApp/.");
		}
		
		public function test_start_shouldEnableStartedMode()
		{
			Wigbi::start();
			Wigbi::stop();
			Wigbi::start();
			
			$this->assertTrue(Wigbi::isStarted());
		}
		
		
		public function test_stop_shouldDisableStartedMode()
		{
			Wigbi::stop();
			Wigbi::start();
			Wigbi::start();
			Wigbi::stop();
			
			$this->assertFalse(Wigbi::isStarted());
		}
		
	}

?>
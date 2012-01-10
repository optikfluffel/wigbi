<?php

	class WigbiBehavior extends UnitTestCase
	{
		public function test_globals_shouldBeCorrect()
		{
			$globals = Wigbi::globals();
			
			global $wigbi_root;
			$this->assertEqual($wigbi_root, "../");
			$this->assertEqual($globals["root"], "../");
			
			global $wigbi_config_file;
			$this->assertEqual($wigbi_config_file, "../wigbi/config.ini");
			$this->assertEqual($globals["config_file"], "../wigbi/config.ini");
			
			global $wigbi_php_folders;
			$arr = array("tools", "cache", "context", "core", "configuration", "data", "i18n", "io", "log", "mvc", "ui", "validation", "");
			$this->assertEqual($wigbi_php_folders, $arr);
			$this->assertEqual($globals["php_folders"], $arr);
		}
		
		public function test_dataPluginsFolder_shouldBeRelativeToTestPage()
		{
			$this->assertEqual(Wigbi::dataPluginFolder(), "../wigbi/plugins/data/");
		}
		
		public function test_serverRoot_shouldBeRelativeToTestPage()
		{
			$this->assertEqual(Wigbi::serverRoot(), "../");
		}
		
		public function test_serverRoot_shouldAppendOptionalPath()
		{
			$this->assertEqual(Wigbi::serverRoot("wigbi/"), "../wigbi/");
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
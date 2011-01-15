<?php

class WigbiBehavior extends UnitTestCase
{
	private $ajaxData;
	private $configFile = "resources/config.ini";
	
	
	function WigbiBehavior()
	{
		$this->UnitTestCase("Wigbi");
		
		$this->ajaxData = array();
		$this->ajaxData["configFile"] = "tests/resources/config.ini";
		$this->ajaxData["webRoot"] = "bar";
		$this->ajaxData["className"] = "Wigbi";
		$this->ajaxData["object"] = null;
		$this->ajaxData["functionName"] = "ping";
		$this->ajaxData["functionParameters"] = array("apa");
	}

	function setUp() 
	{
		if (!Wigbi::isStarted())
			$this->resetConfigFile();
	}
	
	function tearDown()
	{
		Wigbi::generateHtml(true);
		$_POST["wigbi_asyncPostBack"] = 0;
		$_POST["wigbi_asyncPostBackData"] = null;
	}
	


	function createDataPlugin()
	{
		$sourceFile = "resources/TestDataPlugin.php";
		$targetFile = Wigbi::wigbiFolder() . "plugins/data/TestDataPlugin.php";
		
		if (file_exists($targetFile))
			unlink($targetFile);
		copy($sourceFile, $targetFile);
		
		$this->resetWigbi();
	}
	
	function createUiPlugin()
	{
		$sourceFile = "resources/TestUiPlugin.php";
		$targetFile = Wigbi::wigbiFolder() . "plugins/ui/TestUiPlugin.php";
		
		if (file_exists($targetFile))
			unlink($targetFile);
		copy($sourceFile, $targetFile);
		
		$sourceFile = "resources/TestUiPlugin.js";
		$targetFile = Wigbi::wigbiFolder() . "plugins/ui/TestUiPlugin.js";
		
		if (file_exists($targetFile))
			unlink($targetFile);
		copy($sourceFile, $targetFile);
		
		$this->resetWigbi();
	}
	
	function deleteDataPlugin()
	{
		unlink(Wigbi::wigbiFolder() . "plugins/data/TestDataPlugin.php");
		if (is_file(Wigbi::wigbiFolder() . "plugins/data/TestDataPlugin.js"))
			unlink(Wigbi::wigbiFolder() . "plugins/data/TestDataPlugin.js");
		
		$this->resetWigbi();
	}
	
	function deleteUiPlugin()
	{
		unlink(Wigbi::wigbiFolder() . "plugins/ui/TestUiPlugin.php");
		unlink(Wigbi::wigbiFolder() . "plugins/ui/TestUiPlugin.js");
		
		$this->resetWigbi();
	}
	
	function resetWigbi()
	{
		$this->stopWigbi();
		$this->startWigbi();
	}
	
	function resetConfigFile()
	{
		$this->setConfigFile("resources/config.ini");
	}
	
	function setConfigFile($path)
	{
		Wigbi::configFile($path);
		$this->resetWigbi();
	}

	function stopWigbi()
	{
		ob_start();
		Wigbi::stop();
		ob_get_clean();
	}

	function startWigbi()
	{
		ob_start();
		Wigbi::start();
		ob_get_clean();
	}
	
	

	function test_systemFoldersAndFilesShouldExist()
	{
		$path = Wigbi::wigbiFolder();
		
		$this->assertTrue(is_dir($path));
		$this->assertTrue(file_exists($path . ".htaccess"));
		$this->assertTrue(file_exists($path . "config_default.ini"));
		$this->assertTrue(file_exists($path . "gpl.txt"));
		$this->assertTrue(file_exists($path . "release-notes.txt"));
		$this->assertTrue(file_exists($path . "wigbi.php"));
		
		$this->assertTrue(is_dir($path . "css"));
		$this->assertTrue(file_exists($path . "css/general.css"));
		$this->assertTrue(file_exists($path . "css/ui.css"));
		
		$this->assertTrue(is_dir($path . "img"));

		$this->assertTrue(is_dir($path . "js"));
		$this->assertTrue(is_dir($path . "js/core"));
		$this->assertTrue(file_exists($path . "js/core/WigbiClass.js"));
		$this->assertTrue(file_exists($path . "js/core/WigbiDataPlugin.js"));
		$this->assertTrue(file_exists($path . "js/core/WigbiUIPlugin.js"));
		$this->assertTrue(file_exists($path . "js/CacheHandler.js"));
		$this->assertTrue(file_exists($path . "js/IniHandler.js"));
		$this->assertTrue(file_exists($path . "js/LanguageHandler.js"));
		$this->assertTrue(file_exists($path . "js/LogHandler.js"));
		$this->assertTrue(file_exists($path . "js/SearchFilter.js"));
		$this->assertTrue(file_exists($path . "js/SessionHandler.js"));
		$this->assertTrue(file_exists($path . "js/Wigbi.js"));
		$this->assertTrue(file_exists($path . "js/jquery-1.4.2.min.js"));
		$this->assertTrue(file_exists($path . "js/json.js"));
		
		$this->assertTrue(is_dir($path . "lang"));
		$this->assertTrue(file_exists($path . "lang/english.ini"));
		$this->assertTrue(file_exists($path . "lang/swedish.ini"));
		
		$this->assertTrue(is_dir($path . "pages"));
		$this->assertTrue(file_exists($path . "pages/bundle.php"));
		$this->assertTrue(file_exists($path . "pages/postBack.php"));
		
		$this->assertTrue(is_dir($path . "php"));
		$this->assertTrue(is_dir($path . "php/core"));
		$this->assertTrue(is_dir($path . "php/tools"));
		$this->assertTrue(is_dir($path . "php/tools/log"));
		$this->assertTrue(file_exists($path . "php/core/WigbiDataPlugin.php"));
		$this->assertTrue(file_exists($path . "php/core/WigbiDataPluginAjaxFunction.php"));
		$this->assertTrue(file_exists($path . "php/core/WigbiDataPluginJavaScriptGenerator.php"));
		$this->assertTrue(file_exists($path . "php/core/WigbiDataPluginList.php"));
		$this->assertTrue(file_exists($path . "php/core/WigbiUIPlugin.php"));
		$this->assertTrue(file_exists($path . "php/CacheHandler.php"));
		$this->assertTrue(file_exists($path . "php/Controller.php"));
		$this->assertTrue(file_exists($path . "php/DatabaseHandler.php"));
		$this->assertTrue(file_exists($path . "php/IniHandler.php"));
		$this->assertTrue(file_exists($path . "php/JavaScript.php"));
		$this->assertTrue(file_exists($path . "php/LanguageHandler.php"));
		$this->assertTrue(file_exists($path . "php/LogHandler.php"));
		$this->assertTrue(file_exists($path . "php/MasterPage.php"));
		$this->assertTrue(file_exists($path . "php/SearchFilter.php"));
		$this->assertTrue(file_exists($path . "php/SessionHandler.php"));
		$this->assertTrue(file_exists($path . "php/UrlHandler.php"));
		$this->assertTrue(file_exists($path . "php/ValidationHandler.php"));
		$this->assertTrue(file_exists($path . "php/View.php"));
		$this->assertTrue(file_exists($path . "php/Wigbi.php"));
		
		$this->assertTrue(is_dir($path . "plugins"));
		$this->assertTrue(is_dir($path . "plugins/data"));
		$this->assertTrue(is_dir($path . "plugins/ui"));
	}
	
	
	
	function test_cacheHandler_shouldReturnCorrectClass()
	{
		$this->assertEqual(get_class(Wigbi::cacheHandler()), "CacheHandler");
	}
	
	function test_configFile_shouldSetValue()
	{
		$file = Wigbi::configFile();
		
		$this->assertEqual(Wigbi::configFile(), $file);
		$this->assertEqual(Wigbi::configFile("myConfigFile.ini"), "myConfigFile.ini");
		$this->assertEqual(Wigbi::configFile($file), $file);
	}
	
	function test_configFile_default_shouldReturnCorrectValue()
	{
		$this->assertEqual(Wigbi::configFile_default(), Wigbi::wigbiFolder() . "config_default.ini");
	}
	
	function test_configuration_shouldReturnCorrectClass()
	{
		$this->assertEqual(get_class(Wigbi::configuration()), "IniHandler");
	}
	
	function test_configuration_shouldReturnStringForParameters()
	{
		$this->setConfigFile("resources/config_minimal.ini");
		
		$this->assertEqual(Wigbi::configuration("foo"), "bar");
		$this->assertEqual(Wigbi::configuration("name", "application"), "Wigbi Test Application");
		
		$this->resetConfigFile();
	}
	
	function test_cssPaths_shouldReturnDefaultValueIfWigbiIsStopped()
	{
		$this->stopWigbi();
		
		$this->assertEqual(Wigbi::cssPaths(), array("wigbi/css"));
		$this->assertEqual(Wigbi::cssPaths(), array("wigbi/css"));
	}
	
	function test_cssPaths_shouldReturnDefaultValueIfConfigValueIsBlank()
	{
		$this->assertEqual(Wigbi::cssPaths(), array("wigbi/css"));
		$this->assertEqual(Wigbi::cssPaths(), array("wigbi/css"));
	}

	function test_cssPaths_shouldApplyConfigValueIfAny()
	{
		$this->setConfigFile("resources/config_cssPaths.ini");
		
		$this->assertEqual(Wigbi::cssPaths(), array("wigbi/css", "bar", "foo"));
		$this->assertEqual(Wigbi::cssPaths(), array("wigbi/css", "bar", "foo"));
		
		$this->resetConfigFile();
	}
	
	function test_dataPluginClasses_shouldReturnAllClasses()
	{
		$this->createDataPlugin();
		
		$classes = Wigbi::dataPluginClasses();
		
		$this->assertEqual(sizeof($classes), 1);
		$this->assertEqual($classes[0], "TestDataPlugin");
		
		$this->deleteDataPlugin();
	}
	
	function test_dataPluginFolder_shouldReturnCorrectValue()
	{
		$this->assertEqual(Wigbi::dataPluginFolder(), Wigbi::wigbiFolder() . "plugins/data/");
	}
	
	function test_dbHandler_shouldReturnCorrectClass()
	{
		$this->assertEqual(get_class(Wigbi::dbHandler()), "DatabaseHandler");
	}
	
	function test_generateHtml_shouldGetSetValue()
	{
		$this->assertTrue(Wigbi::generateHtml());
		$this->assertFalse(Wigbi::generateHtml(false));
		$this->assertFalse(Wigbi::generateHtml());
		$this->assertTrue(Wigbi::generateHtml(true));
	}
	
	function test_isAjaxPostBack_shouldReturnFalseForNoData()
	{
		$this->assertFalse(Wigbi::isAjaxPostBack());
	}
	
	function test_isAjaxPostBack_shouldReturnTrueForData()
	{
		$_POST["wigbi_asyncPostBack"] = 1;
		
		$this->assertTrue(Wigbi::isAjaxPostBack());
		
		$_POST["wigbi_asyncPostBack"] = null;
		
		$this->assertFalse(Wigbi::isAjaxPostBack());
		
		array_pop($_POST);
	}
	
	function test_isStarted_shouldReturnFalseWhenStopped()
	{
		Wigbi::stop();
		
		$this->assertFalse(Wigbi::isStarted());
	}

	function test_isStarted_shouldReturnTrueWhenStarted()
	{
		$this->assertTrue(Wigbi::isStarted());
	}
	
	function test_jsPaths_shouldReturnDefaultValueIfWigbiIsStopped()
	{
		$this->stopWigbi();
		
		$this->assertEqual(Wigbi::jsPaths(), array("wigbi/js/core", "wigbi/js", "wigbi/plugins/data", "wigbi/plugins/ui"));
		$this->assertEqual(Wigbi::jsPaths(), array("wigbi/js/core", "wigbi/js", "wigbi/plugins/data", "wigbi/plugins/ui"));
	}
	
	function test_jsPaths_shouldReturnDefaultValueIfConfigValueIsBlank()
	{
		$this->assertEqual(Wigbi::jsPaths(), array("wigbi/js/core", "wigbi/js", "wigbi/plugins/data", "wigbi/plugins/ui"));
		$this->assertEqual(Wigbi::jsPaths(), array("wigbi/js/core", "wigbi/js", "wigbi/plugins/data", "wigbi/plugins/ui"));
	}

	function test_jsPaths_shouldApplyConfigValueIfAny()
	{
		$this->setConfigFile("resources/config_jsPaths.ini");
		
		$this->assertEqual(Wigbi::jsPaths(), array("wigbi/js/core", "wigbi/js", "wigbi/plugins/data", "wigbi/plugins/ui", "bar", "foo"));
		$this->assertEqual(Wigbi::jsPaths(), array("wigbi/js/core", "wigbi/js", "wigbi/plugins/data", "wigbi/plugins/ui", "bar", "foo"));
		
		$this->resetConfigFile();
	}
	
	function test_languageFile_shouldGetSetValue()
	{
		$this->assertEqual(Wigbi::languageFile(), "");
		$this->assertEqual(Wigbi::languageFile("foo"), "foo");
		$this->assertEqual(Wigbi::languageFile(), "foo");
		$this->assertEqual(Wigbi::languageFile(""), "");
	}
	
	function test_languageHandler_shouldReturnCorrectClass()
	{
		$this->assertEqual(get_class(Wigbi::languageHandler()), "LanguageHandler");
	}
	
	function test_logHandler_shouldReturnCorrectClass()
	{
		$this->assertEqual(get_class(Wigbi::logHandler()), "LogHandler");
	}
	
	function test_phpPaths_shouldReturnDefaultValueIfWigbiIsStopped()
	{
		$this->stopWigbi();
		
		$this->assertEqual(Wigbi::phpPaths(), array(Wigbi::serverRoot() . "wigbi/php/core/", Wigbi::serverRoot() . "wigbi/php/", Wigbi::serverRoot() . "wigbi/plugins/data/", Wigbi::serverRoot() . "wigbi/plugins/ui/"));
		$this->assertEqual(Wigbi::phpPaths(), array(Wigbi::serverRoot() . "wigbi/php/core/", Wigbi::serverRoot() . "wigbi/php/", Wigbi::serverRoot() . "wigbi/plugins/data/", Wigbi::serverRoot() . "wigbi/plugins/ui/"));
	}
	
	function test_phpPaths_shouldReturnDefaultValueIfConfigValueIsBlank()
	{
		$this->assertEqual(Wigbi::phpPaths(), array(Wigbi::serverRoot() . "wigbi/php/core/", Wigbi::serverRoot() . "wigbi/php/", Wigbi::serverRoot() . "wigbi/plugins/data/", Wigbi::serverRoot() . "wigbi/plugins/ui/"));
		$this->assertEqual(Wigbi::phpPaths(), array(Wigbi::serverRoot() . "wigbi/php/core/", Wigbi::serverRoot() . "wigbi/php/", Wigbi::serverRoot() . "wigbi/plugins/data/", Wigbi::serverRoot() . "wigbi/plugins/ui/"));
	}

	function test_phpPaths_shouldRequireAllFiles()
	{
		$this->assertFalse(class_exists("NestedPhpClass"));
		$this->assertFalse(class_exists("NestedPhpClass2"));
		$this->assertFalse(class_exists("PhpClass"));
		
		$this->setConfigFile("resources/config_phpPaths.ini");

		$this->assertTrue(class_exists("NestedPhpClass"));
		$this->assertTrue(class_exists("NestedPhpClass2"));
		$this->assertTrue(class_exists("PhpClass"));
		
		$this->resetConfigFile();
	}

	function test_phpPaths_shouldApplyConfigValueIfAny()
	{
		$this->setConfigFile("resources/config_phpPaths.ini");

		$this->assertEqual(Wigbi::phpPaths(), array(Wigbi::serverRoot() . "wigbi/php/core/", Wigbi::serverRoot() . "wigbi/php/", Wigbi::serverRoot() . "wigbi/plugins/data/", Wigbi::serverRoot() . "wigbi/plugins/ui/", Wigbi::serverRoot() . "tests/resources/phpClasses/", Wigbi::serverRoot() . "tests/resources/phpClass.php"));
		$this->assertEqual(Wigbi::phpPaths(), array(Wigbi::serverRoot() . "wigbi/php/core/", Wigbi::serverRoot() . "wigbi/php/", Wigbi::serverRoot() . "wigbi/plugins/data/", Wigbi::serverRoot() . "wigbi/plugins/ui/", Wigbi::serverRoot() . "tests/resources/phpClasses/", Wigbi::serverRoot() . "tests/resources/phpClass.php"));
		
		$this->resetConfigFile();
	}

	function test_scriptFileHeader_shouldReturnCorrectString()
	{
		$string = Wigbi::scriptFileHeader();
		
		$this->assertTrue(substr_count($string, "/"."* ***************************************") == 1);
		$this->assertTrue(substr_count($string, "Wigbi " . Wigbi::version() . "\r\n") == 1);
		$this->assertTrue(substr_count($string, "http://www.wigbi.com\r\n\r\n") == 1);
		$this->assertTrue(substr_count($string, "Copyright © " . date("Y") . " Daniel Saidi") == 1);
		$this->assertTrue(substr_count($string, "Licensed under the GPLv3 license.\r\n") == 1);
		$this->assertTrue(substr_count($string, "http://www.gnu.org/licenses/gpl-3.0.html\r\n") == 1);
		$this->assertTrue(substr_count($string, "*************************************** *"."/" . "\r\n\r\n") == 1);
	}

	function test_serverRoot_shouldReturnCorrectPath()
	{
		$this->assertEqual(Wigbi::serverRoot(), "../");
	}
	
	function test_sessionHandler_shouldReturnCorrectClass()
	{
		$this->assertEqual(get_class(Wigbi::sessionHandler()), "SessionHandler");
	}

	function test_uiPluginClasses_shouldReturnAllClasses()
	{
		$this->createUiPlugin();
		
		$classes = Wigbi::uiPluginClasses();
		
		$this->assertEqual(sizeof($classes), 1);
		$this->assertEqual($classes[0], "TestUiPlugin");
		
		$this->deleteUiPlugin();
	}
	
	function test_uiPluginFolder_shouldReturnCorrectValue()
	{
		$this->assertEqual(Wigbi::uiPluginFolder(), Wigbi::wigbiFolder() . "plugins/ui/");
	}
	
	function test_version_ShouldReturnCorrectValue()
	{
		$this->assertEqual(Wigbi::version(), "1.0.0");
	}

	function test_wigbiFolder_shouldReturnCorrectPath()
	{
		$this->assertEqual(Wigbi::wigbiFolder(), "../wigbi/");
	}

	function test_webRoot_shouldReturnCorrectValue()
	{
		$this->assertEqual(Wigbi::webRoot(), "../");
	}



	function test_ping_shouldReturnProvidedValue()
	{
		$this->assertEqual(Wigbi::ping("foo bar"), "foo bar");
		$this->assertEqual(Wigbi::ping(1), 1);
		$this->assertEqual(Wigbi::ping(1.5), 1.5);
		$this->assertEqual(Wigbi::ping(true), true);
		$this->assertEqual(Wigbi::ping(array("foo bar", 1, 1.5, true)), array("foo bar", 1, 1.5, true));
	}

	function test_ping_shouldThrowExceptionForInvalidComparison()
	{
		$this->expectException( new Exception("ERROR!") );
		
		Wigbi::ping("foo bar", true);
	}
	
	function test_start_shouldHandleAjaxConfiguration()
	{
		$_POST["wigbi_asyncPostBack"] = 1;
		$_POST["wigbi_asyncPostBackData"] = json_encode($this->ajaxData);

		$this->setConfigFile("resources/config_minimal.ini");
		
		$this->assertEqual(Wigbi::configFile(), Wigbi::serverRoot() . $this->ajaxData["configFile"]);
		
		$this->resetConfigFile();
	}
	
	function test_start_shouldStartConfigurationAndFailIfNeitherConfigFileExists()
	{
		//TODO: A bit risky to test this with the live system
	}
	
	function test_start_shouldStartConfigurationAndFailIfConfigFileDoesNotExistAndCannotBeCreated()
	{
		//TODO: A bit risky to test this with the live system
	}
	
	function test_start_shouldStartConfigurationAndCreateConfigFileIfNoneExists()
	{
		//TODO: A bit risky to test this with the live system
	}
	
	function test_start_shouldStartConfigurationAndFailForInvalidConfigurationFile()
	{
		$this->expectException(new Exception("The Wigbi configuration file resources/config_invalid.ini could not be parsed. Wigbi must be able to parse this file to proceed."));
		$this->setConfigFile("resources/config_invalid.ini");
	}
	
	function test_start_shouldStartConfigurationAndFailForMissingApplicationNameParameter()
	{
		$this->expectException(new Exception('The application.name parameter in the Wigbi configuration file must have a value, e.g. "My Application".'));
		$this->setConfigFile("resources/config_noName.ini");
	}

	function test_start_shouldStartConfigurationAndFailForMissingWebRootParameter()
	{
		$this->expectException(new Exception('The application.webRoot parameter in the Wigbi configuration file must have a value, e.g. /myApp/ if the application is located in http://localhost/myApp/.'));
		$this->setConfigFile("resources/config_noWebRoot.ini");
	}

	function test_start_shouldStartCacheHandlerWithoutConfigValue()
	{
		$this->setConfigFile("resources/config_minimal.ini");
		$this->assertEqual(Wigbi::cacheHandler()->cacheFolder(), Wigbi::serverRoot("../"));
		
		$this->resetConfigFile();
	}

	function test_start_shouldStartCacheHandlerWithConfigValue()
	{
		$this->assertEqual(Wigbi::cacheHandler()->cacheFolder(), Wigbi::serverRoot() . Wigbi::configuration("folder", "cacheHandler"));
	}
	
	function test_start_shouldStartInactiveDatabaseHandlerWithRtbDisabled()
	{
		$this->setConfigFile("resources/config_minimal.ini");
		
		$this->assertEqual(Wigbi::dbHandler()->host(), "");
		$this->assertEqual(Wigbi::dbHandler()->dbName(), "");
		$this->assertEqual(Wigbi::dbHandler()->userName(), "");
		$this->assertEqual(Wigbi::dbHandler()->password(), "");
		$this->assertFalse(Wigbi::dbHandler()->isConnected());
		
		$this->resetConfigFile();
	}
	
	function test_start_shouldStartDatabaseHandlerWithRtbDisabled()
	{
		$this->setConfigFile("resources/config_noRtb.ini");
		
		$this->assertEqual(Wigbi::dbHandler()->host(), "localhost");
		$this->assertEqual(Wigbi::dbHandler()->dbName(), "wigbi_unitTests");
		$this->assertEqual(Wigbi::dbHandler()->userName(), "root");
		$this->assertEqual(Wigbi::dbHandler()->password(), "root");
		$this->assertTrue(Wigbi::dbHandler()->isConnected());
		$this->assertTrue(Wigbi::dbHandler()->databaseExists(Wigbi::dbHandler()->dbName()));
		
		$this->resetConfigFile();
	}
	
	function test_start_shouldStartDatabaseHandlerButNotCreateDatabaseWithRtbDisabled()
	{
		Wigbi::dbHandler()->query("DROP DATABASE " . Wigbi::dbHandler()->dbName());
		
		$this->assertFalse(Wigbi::dbHandler()->databaseExists(Wigbi::dbHandler()->dbName()));
		$this->expectException(new Exception("Wigbi could not establish a connection to the database wigbi_unitTests. Make sure that it exists and that the mySQL information in the Wigbi configuration file is valid."));

		$this->setConfigFile("resources/config_noRtb.ini");
	}

	function test_start_shouldStartDatabaseHandlerAndFailWithInvalidCredentialsWithRtbEnabled()
	{
		Wigbi::dbHandler()->query("DROP DATABASE " . Wigbi::dbHandler()->dbName());
		
		$this->assertFalse(Wigbi::dbHandler()->databaseExists(Wigbi::dbHandler()->dbName()));
		$this->expectException(new Exception("Wigbi could not establish a connection for creation to the specified database provider at localhost. Make sure that the mySQL information in the Wigbi configuration file is valid."));
		$this->expectError(new PatternExpectation("/Access denied for user/i"));
		
		$this->setConfigFile("resources/config_invalidDbCredentials.ini");
	}
	
	function test_start_shouldStartDatabaseHandlerAndFailWithInvalidCredentialsWithRtbDisabled()
	{
		$this->expectException(new Exception("Wigbi could not establish a connection to the database wigbi_unitTests. Make sure that it exists and that the mySQL information in the Wigbi configuration file is valid."));
		$this->expectError(new PatternExpectation("/Access denied for user/i"));

		$this->setConfigFile("resources/config_invalidDbCredentialsNoRtb.ini");
	}
	
	function test_start_shouldStartDatabaseHandlerAndCreateDatabaseWithRtbEnabled()
	{
		Wigbi::dbHandler()->query("DROP DATABASE " . Wigbi::dbHandler()->dbName());
		
		$this->assertFalse(Wigbi::dbHandler()->databaseExists(Wigbi::dbHandler()->dbName()));
		
		$this->resetWigbi();
		
		$this->assertEqual(Wigbi::dbHandler()->host(), "localhost");
		$this->assertEqual(Wigbi::dbHandler()->dbName(), "wigbi_unitTests");
		$this->assertEqual(Wigbi::dbHandler()->userName(), "root");
		$this->assertEqual(Wigbi::dbHandler()->password(), "root");
		$this->assertTrue(Wigbi::dbHandler()->isConnected());
		$this->assertTrue(Wigbi::dbHandler()->databaseExists(Wigbi::dbHandler()->dbName()));
	}
	
	function test_start_shouldStartLanguageHandlerButFailForInvalidLanguageHandlerFile()
	{
		$this->expectException(new Exception("The default language file ../wigbi/content/lang/nonexisting.ini could not be parsed."));
		
		$this->setConfigFile("resources/config_invalidLanguageFile.ini");
	}
	
	function test_start_shouldStartLanguageHandlerWithoutConfigFileValue()
	{
		$this->setConfigFile("resources/config_minimal.ini");
		
		$this->assertEqual(Wigbi::languageHandler()->filePath(), "");
		
		$this->resetConfigFile();
	}
	
	function test_start_shouldStartLanguageHandlerWithConfigFileValue()
	{
		$this->assertEqual(Wigbi::languageHandler()->filePath(), Wigbi::wigbiFolder() . "lang/english.ini");
	}
	
	function test_start_shouldStartLanguageHandlerWithVariableValue()
	{
		$langFile = Wigbi::wigbiFolder() . "lang/swedish.ini";
		Wigbi::languageFile($langFile);
		$this->resetWigbi();
		
		$this->assertEqual(Wigbi::languageHandler()->filePath(), $langFile);
		
		Wigbi::languageFile("");
	}
	
	function test_start_shouldStartLogHandlerWithoutAnyHandlers()
	{
		$this->setConfigFile("resources/config_minimal.ini");
		
		$this->assertEqual(Wigbi::logHandler()->id(), "Wigbi Test Application");
		$this->assertEqual(sizeof(Wigbi::logHandler()->handlers()), 0);
		
		$this->resetConfigFile();
	}
	
	function test_start_shouldStartLogHandlerWithHandlers()
	{
		$this->assertEqual(Wigbi::logHandler()->id(), "Wigbi Unit Tests");
		$this->assertEqual(sizeof(Wigbi::logHandler()->handlers()), 2);
		
		$handlers = Wigbi::logHandler()->handlers();
		$handler = $handlers[0];
		
		$this->assertEqual($handler["priorities"], array(0,1,2,3,4,5,6,7));
		$this->assertFalse($handler["display"]);
		$this->assertEqual($handler["file"], "log/event.log");
		$this->assertFalse($handler["firebug"]);
		$this->assertEqual($handler["mailaddresses"], "");
		$this->assertFalse($handler["syslog"]);
		$this->assertFalse($handler["window"]);
		
		$handler = $handlers[1];
		
		$this->assertEqual($handler["priorities"], array(7));
		$this->assertTrue($handler["display"]);
		$this->assertEqual($handler["file"], "log/event.log");
		$this->assertTrue($handler["firebug"]);
		$this->assertEqual($handler["mailaddresses"], "daniel.saidi@gmail.com");
		$this->assertTrue($handler["syslog"]);
		$this->assertTrue($handler["window"]);
	}
	
	function test_start_shouldStartSessionHandlerWithApplicationName()
	{
		$this->assertEqual(Wigbi::sessionHandler()->applicationName(), "Wigbi Unit Tests");
	}
	
	function test_start_shouldNotStartDataPluginsWhenRtbIsDisabled()
	{
		$files = glob(Wigbi::dataPluginFolder() . "/*.js");
		
		$this->assertEqual(sizeof($files), 0);
		
		$this->setConfigFile("resources/config_noRtb.ini");
		$this->createDataPlugin();
		
		$files = glob(Wigbi::dataPluginFolder() . "/*.js");
		
		$this->assertEqual(sizeof($files), 0);
		
		$this->deleteDataPlugin();
		$this->resetConfigFile();
	}
	
	function test_start_shouldStartDataPluginsAndCreateTable()
	{
		$this->createDataPlugin();
		
		$this->assertTrue(Wigbi::dbHandler()->tableExists("TestDataPlugins"));
		
		$this->deleteDataPlugin();
	}
	
	function test_start_shouldStartDataPluginsAndCreateJavaScriptClassFile()
	{
		$this->createDataPlugin();
		
		$files = glob(Wigbi::dataPluginFolder() . "/*.js");
		
		$this->assertEqual(sizeof($files), 1);
		
		$this->deleteDataPlugin();
	}
	
	function test_start_shouldhandleAjaxPostBack()
	{
		$_POST["wigbi_asyncPostBack"] = 1;
		
		$data = array();
		$data["configFile"] = null;
		$data["webRoot"] = "bar";
		$data["className"] = "WigbiAsyncTestClass";
		$data["object"] = null;
		$data["functionName"] = "returnArray_static";
		$data["functionParameters"] = array("apa", 1, 2.5, true, array("apa", 1, 2.5, true));
		$_POST["wigbi_asyncPostBackData"] = json_encode($data);
		
		ob_start();
		Wigbi::start();
		json_decode(ob_get_clean());
		
		$this->assertEqual(Wigbi::webRoot(), "bar");
	}
	
	function test_start_handleAjaxPostBack_shouldReturnNullForIsNotPostback()
	{
		ob_start();
		MyWigbiWrapper::test_start_handleAjaxPostBack();
		$response = json_decode(ob_get_clean());
		$result = $response[0];
		$exception = $response[1];
		
		$this->assertEqual($result, "");
	}
	
	function test_start_handleAjaxPostBack_shouldUpdateWebRoot()
	{
		$_POST["wigbi_asyncPostBack"] = 1;
		
		$data = array();
		$data["configFile"] = null;
		$data["webRoot"] = "bar";
		$data["className"] = "WigbiAsyncTestClass";
		$data["object"] = null;
		$data["functionName"] = "returnArray_static";
		$data["functionParameters"] = array("apa", 1, 2.5, true, array("apa", 1, 2.5, true));
		$_POST["wigbi_asyncPostBackData"] = json_encode($data);
		
		$oldWebRoot = Wigbi::webRoot();
		ob_start();
		MyWigbiWrapper::test_start_handleAjaxPostBack();
		ob_get_clean();
		
		$this->assertEqual(Wigbi::webRoot(), "bar");
		
		$data["webRoot"] = $oldWebRoot;
		$_POST["wigbi_asyncPostBackData"] = json_encode($data);
		
		ob_start();
		MyWigbiWrapper::test_start_handleAjaxPostBack();
		$response = json_decode(ob_get_clean());
		
		$this->assertEqual(Wigbi::webRoot(), $oldWebRoot);
	}
	
	function test_start_handleAjaxPostBack_shouldIgnoreEmptyWebRoot()
	{
		$_POST["wigbi_asyncPostBack"] = 1;
		
		$data = array();
		$data["configFile"] = null;
		$data["webRoot"] = "";
		$data["className"] = "WigbiAsyncTestClass";
		$data["object"] = null;
		$data["functionName"] = "returnArray_static";
		$data["functionParameters"] = array("apa", 1, 2.5, true, array("apa", 1, 2.5, true));
		$_POST["wigbi_asyncPostBackData"] = json_encode($data);
		
		$oldWebRoot = Wigbi::webRoot();
		ob_start();
		MyWigbiWrapper::test_start_handleAjaxPostBack();
		ob_get_clean();
		
		$this->assertEqual(Wigbi::webRoot(), $oldWebRoot);
	}
	
	function test_start_handleAjaxPostBack_shouldHandleStaticMethodWithParameters()
	{
		$_POST["wigbi_asyncPostBack"] = 1;
		
		$data = array();
		$data["configFile"] = null;
		$data["webRoot"] = "";
		$data["className"] = "WigbiAsyncTestClass";
		$data["object"] = null;
		$data["functionName"] = "returnArray_static";
		$data["functionParameters"] = array("apa", 1, 2.5, true, array("apa", 1, 2.5, true));
		$_POST["wigbi_asyncPostBackData"] = json_encode($data);
		
		ob_start();
		MyWigbiWrapper::test_start_handleAjaxPostBack();
		$response = json_decode(ob_get_clean());		
		$result = $response[0];
		$exception = $response[1];
		
		$this->assertEqual($result[0], "apa");
		$this->assertEqual($result[1], 1);
		$this->assertEqual($result[2], 2.5);
		$this->assertEqual($result[3], true);
		$this->assertEqual($result[4], array("apa", 1, 2.5, true));
		$this->assertNull($exception);
	}
	
	function test_start_handleAjaxPostBack_shouldHandleStaticMethodWithoutParameters()
	{
		$_POST["wigbi_asyncPostBack"] = 1;
		
		$data = array();
		$data["configFile"] = null;
		$data["webRoot"] = "";
		$data["className"] = "WigbiAsyncTestClass";
		$data["object"] = null;
		$data["functionName"] = "returnString_static";
		$data["functionParameters"] = null;
		$_POST["wigbi_asyncPostBackData"] = json_encode($data);
		
		ob_start();
		MyWigbiWrapper::test_start_handleAjaxPostBack();
		$response = json_decode(ob_get_clean());		
		$result = $response[0];
		$exception = $response[1];
		
		$this->assertEqual($result, "foo bar");
		$this->assertEqual($exception, null);
	}
	
	function test_start_handleAjaxPostBack_shouldHandleNonStaticMethodWithParameters()
	{
		$_POST["wigbi_asyncPostBack"] = 1;
		
		$obj = new WigbiAsyncTestClass();
		$obj->name = "Object name";
		
		$data = array();
		$data["configFile"] = null;
		$data["webRoot"] = "";
		$data["className"] = "WigbiAsyncTestClass";
		$data["object"] = $obj;
		$data["functionName"] = "returnArray_nonStatic";
		$data["functionParameters"] = array("apa", 1, 2.5, true, array("apa", 1, 2.5, true));
		$_POST["wigbi_asyncPostBackData"] = json_encode($data);
		
		ob_start();
		MyWigbiWrapper::test_start_handleAjaxPostBack();
		$response = json_decode(ob_get_clean());		
		$result = $response[0];
		$exception = $response[1];
		
		$this->assertEqual($result[0], $obj->name);
		$this->assertEqual($result[1], "apa");
		$this->assertEqual($result[2], 1);
		$this->assertEqual($result[3], 2.5);
		$this->assertEqual($result[4], true);
		$this->assertEqual($result[5], array("apa", 1, 2.5, true));
		$this->assertEqual($exception, null);
	}
	
	function test_start_handleAjaxPostBack_shouldHandleNonStaticMethodWithoutParameters()
	{
		$_POST["wigbi_asyncPostBack"] = 1;
		
		$obj = new WigbiAsyncTestClass();
		$obj->name = "Object name";
		
		$data = array();
		$data["configFile"] = null;
		$data["webRoot"] = "";
		$data["className"] = "WigbiAsyncTestClass";
		$data["object"] = $obj;
		$data["functionName"] = "returnString_nonStatic";
		$data["functionParameters"] = null;
		$_POST["wigbi_asyncPostBackData"] = json_encode($data);
		
		ob_start();
		MyWigbiWrapper::test_start_handleAjaxPostBack();
		$response = json_decode(ob_get_clean());		
		$result = $response[0];
		$exception = $response[1];
		
		$this->assertEqual($result, $obj->name);
		$this->assertEqual($exception, null);
	}
	
	function test_start_shouldNotGenerateHtmlIfGenerateHtmlIsFalse()
	{
		Wigbi::generateHtml(false);
		
		ob_start();
		Wigbi::start();
		$result = ob_get_clean();
		
		$this->assertEqual($result, "");
	}
	
	function test_start_shouldNotGenerateHtmlIfAsyncPostBack()
	{
		$_POST["wigbi_asyncPostBack"] = 1;
		
		$data = array();
		$data["configFile"] = null;
		$data["webRoot"] = null;
		$data["className"] = "WigbiAsyncTestClass";
		$data["object"] = null;
		$data["functionName"] = "returnArray_static";
		$data["functionParameters"] = array("apa", 1, 2.5, true, array("apa", 1, 2.5, true));
		$_POST["wigbi_asyncPostBackData"] = json_encode($data);
		
		ob_start();
		Wigbi::start();
		$result = ob_get_clean(); 	
		
		$this->assertFalse(strpos($result, "<meta http-equiv=\"Content-Type\" content=\"text/css; charset=UTF-8\" />"));
	}
	
	function test_start_shouldGenerateHtmlByDefault()
	{
		ob_start();
		Wigbi::start();
		$result = ob_get_clean();

		$this->assertTrue(strpos(" " . $result, "<meta http-equiv=\"Content-Type\" content=\"text/css; charset=UTF-8\" />"));
		$this->assertTrue(strpos($result, "<link rel=\"stylesheet\" type=\"text/css\" href=\"" . Wigbi::webRoot() . "wigbi/bundle/css:wigbi/css\" />"));
		
		$this->assertTrue(strpos($result, "<script type=\"text/javascript\" src=\"" . Wigbi::webRoot() . "wigbi/bundle/js:wigbi/js/core,wigbi/js,wigbi/plugins/data,wigbi/plugins/ui\"></script>"));
		$this->assertTrue(strpos($result, "<script type=\"text/javascript\">eval("));
	}

	function test_start_shouldStartWigbi()
	{
		ob_start();
		Wigbi::stop();
		Wigbi::start();
		$result = ob_get_clean();
		
		$this->assertTrue(Wigbi::isStarted());
	}
	
	function test_start_handleAjaxConfiguration_shouldReturnNullForIsNotPostback()
	{
		$this->assertNull(MyWigbiWrapper::test_start_handleAjaxConfiguration());
	}
	
	function test_start_handleAjaxConfiguration_shouldSetConfigFile()
	{
		$oldConfigFile = Wigbi::configFile();
		$_POST["wigbi_asyncPostBack"] = 1;
		$data = array();
		$data["configFile"] = "foo";
		$_POST["wigbi_asyncPostBackData"] = json_encode($data);
		
		MyWigbiWrapper::test_start_handleAjaxConfiguration();
		
		$this->assertEqual(Wigbi::configFile(), "../foo");
		
		$this->stopWigbi();
	}
	
	function test_start_handleAjaxConfiguration_shouldIgnoreEmptyConfigFile()
	{
		$oldConfigFile = Wigbi::configFile();
		$_POST["wigbi_asyncPostBack"] = 1;
		$data = array();
		$data["configFile"] = "";
		$_POST["wigbi_asyncPostBackData"] = json_encode($data);
		
		MyWigbiWrapper::test_start_handleAjaxConfiguration();
		
		$this->assertEqual(Wigbi::configFile(), $oldConfigFile);
		
		$this->stopWigbi();
	}

	function test_start_handleAjaxParameter_shouldHandleSupportedTypes()
	{
		$this->assertEqual(MyWigbiWrapper::test_start_handleAjaxParameter("apa"), "\"apa\"");
		$this->assertEqual(MyWigbiWrapper::test_start_handleAjaxParameter("a\"pa"), "\"a\\\"pa\"");
		$this->assertEqual(MyWigbiWrapper::test_start_handleAjaxParameter(15), 15);
		$this->assertEqual(MyWigbiWrapper::test_start_handleAjaxParameter(15.0), 15.0);
		$this->assertEqual(MyWigbiWrapper::test_start_handleAjaxParameter(TRUE), 1);
		$this->assertEqual(MyWigbiWrapper::test_start_handleAjaxParameter(FALSE), 0);
		$this->assertEqual(MyWigbiWrapper::test_start_handleAjaxParameter(array("apa", 15, 15.1, TRUE, FALSE)), "array(\"apa\",15,15.1,1,0)");
	}
	
	function test_stop_shouldDeleteAllObjectsAndStopWigbi()
	{
		Wigbi::stop();
		
		$this->assertNull(Wigbi::cacheHandler());
		$this->assertNull(Wigbi::configuration());
		$this->assertNull(Wigbi::dbHandler());
		$this->assertNull(Wigbi::languageHandler());
		$this->assertNull(Wigbi::logHandler());
		$this->assertNull(Wigbi::sessionHandler());
		
		$this->assertEqual(Wigbi::dataPluginClasses(), array());
		$this->assertEqual(Wigbi::uiPluginClasses(), array());

		$this->assertFalse(Wigbi::isStarted());
	}
}	


//Use this wrapper to modify Wigbi behavior
class MyWigbiWrapper extends Wigbi
{
	public static function test_start_handleAjaxPostBack()
	{
		return Wigbi::start_handleAjaxPostBack();
	}
	
	public static function test_start_handleAjaxConfiguration()
	{
		return Wigbi::start_handleAjaxConfiguration();
	}
	
	public static function test_start_handleAjaxParameter($parameter)
	{
		return Wigbi::start_handleAjaxParameter($parameter);
	}
}

//Use this wrapper to test AJAX handling
class WigbiAsyncTestClass extends WigbiDataPlugin
{
	public $name = "";

	public function returnArray_nonStatic($string, $int, $float, $bool, $array)
	{
		return array($this->name, $string, $int, $float, $bool, $array);
	}
	
	public static function returnArray_static($string, $int, $float, $bool, $array)
	{
		return array($string, $int, $float, $bool, $array);
	}
	
	public function returnString_nonStatic()
	{
		return $this->name;
	}
	
	public static function returnString_static()
	{
		return "foo bar";
	}
}
?>
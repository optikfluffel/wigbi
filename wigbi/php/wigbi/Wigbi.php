<?php

/**
 * The Wigbi.PHP.Wigbi class file.
 * 
 * Wigbi is free software. You can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *  
 * Wigbi is distributed in the hope that it will be useful, but WITH
 * NO WARRANTY; without even the implied warranty of MERCHANTABILITY
 * or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public
 * License for more details.
 *  
 * You should have received a copy of the GNU General Public License
 * along with Wigbi. If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * The Wigbi.PHP.Wigbi class.
 * 
 * This is the most central class in the Wigbi framework. It is used
 * to start and stop Wigbi and provides central functions/properties.
 * Two important properties are serverRoot and webRoot, which points
 * out the root folder for the executing FILE and PAGE.
 * 
 * The class has default instances for all available handler classes.
 * It inits them when Wigbi is started, using the configuration file.
 * To make Wigbi use a different config file, set the configFile(..)
 * to the path you want to use before starting Wigbi.
 * 
 * 
 * INCLUDE, START AND STOP WIGBI ************
 * 
 * To include the entire Wigbi framework, include wigbi/wigbi.php at
 * the very beginning of the page. This will include all PHP classes
 * in the Wigbi framework and enable session handling.
 * 
 * To start Wigbi, execute the Wigbi::start function in the head tag.
 * To stop Wigbi, execute the Wigbi::stop function when Wigbi is not
 * needed anymore, e.g. at the end of the page.
 * 
 *
 * WIGBI RUNTIME BUILD (RTB) ***************
 * 
 * Runtime Build - RTB - is a Wigbi feature that automatically keeps
 * the system in constant sync. It syncs the database with all added
 * data plugins and bundles all data/ui plugin JavaScript classes in
 * a single file, which can be automatically obfuscated as well.  
 * 
 * Use the application.runtimeBuild configuration file key to enable
 * or disable RTB. During development, RTB is really handy, since it
 * ensures that all plugins are properly handled, without any manual
 * work. However, RTB should be disabled when the system is live, to
 * make Wigbi more lightweight. For live systems, only enable RTB to
 * sync the system when so is needed.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2010, Daniel Saidi
 * @link				http://www.wigbi.com
 * @package			Wigbi
 * @subpackage	PHP
 * @version			1.0.0
 * 
 * @static
 */
class Wigbi
{
	/**#@+
	 * @ignore
	 */
	private static $_version = "1.0.0";
	
	private static $_cacheHandler;
	private static $_configFile;
	private static $_configuration;
	private static $_cssPaths;
	private static $_dataPluginClasses;
	private static $_dbHandler;
	private static $_generateHtml = true;
	private static $_isStarted;
	private static $_jsPaths;
	private static $_languageFile;
	private static $_languageHandler;
	private static $_logHandler;
	private static $_serverRoot;
	private static $_sessionHandler;
	private static $_uiPluginClasses;
	private static $_webRoot;
	/**#@-*/
	
	
	/**
	 * Get/set the default Wigbi CacheHandler instance.
	 * 
	 * This object is initialized when Wigbi is started, using the
	 * cacheHandler section in the Wigbi config file.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @param		CacheHandler	$value	Optional set value.
	 * @return	CacheHandler					The default Wigbi CacheHandler object.
	 */
	public static function cacheHandler()
	{
		return Wigbi::$_cacheHandler;
	}
	
	/**
	 * Get/set the path to the Wigbi config file.
	 * 
	 * This property must be set before Wigbi is started. Otherwise,
	 * the default wigbi/config.ini file will be used.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @param		string	$value	Optional set value.
	 * @return	string					The path to the Wigbi config file.
	 */
	public static function configFile($value = "")
	{
		if(func_num_args() != 0)
			Wigbi::$_configFile = func_get_arg(0);
		else if (!isset(Wigbi::$_configFile))
			Wigbi::$_configFile = Wigbi::wigbiFolder() . "config.ini";
		return Wigbi::$_configFile;
	}
	
	/**
	 * Get the path to the Wigbi config template file.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @return	string	The path to the Wigbi config template file.
	 */
	public static function configFile_default()
	{
		return Wigbi::wigbiFolder() . "config_default.ini";
	}
	
	/**
	 * Get the Wigbi configuration object.
	 * 
	 * This object is initialized when Wigbi is started and uses the
	 * configFile() property to parse a Wigbi configuration INI file.
	 * 
	 * This property can either return the IniHandler object (do not
	 * use any parameters) as well a single configuration key.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @param		string	$parameter	Optional parameter to retrieve; default blank.
	 * @param		string	$section		Optional parameter section; default blank.
	 * @return	mixed								The config IniHandler if no parameters, or a config parameter if parameters.
	 */
	public static function configuration($parameter = "", $section = "")
	{
		switch (func_num_args())
		{
			case 0:
				return Wigbi::$_configuration;
				
			case 1:
				$parameter = func_get_arg(0);
				return Wigbi::$_configuration->get($parameter);
				
			case 2:
				$parameter = func_get_arg(0);
				$section = func_get_arg(1);
				return Wigbi::$_configuration->get($parameter, $section);
		}
	}
	
	/**
	 * Get/set a list of CSS folder/file paths to apply during when Wigbi is started.
	 * 
	 * By default, Wigbi will use the application.cssPaths configuration
	 * key from the configuration file. To override this value, set this
	 * property to the paths you want to use, before starting Wigbi.
	 * 
	 * 
	 * @access	public
	 * @static
	 * 
	 * @param		array	$value	Optional set value.
	 * @return	array					A list of CSS folder/file paths to apply when Wigbi is started.
	 */
	public function cssPaths($value = null)
	{
		if (func_num_args() != 0)
			Wigbi::$_cssPaths = func_get_arg(0);

		if (Wigbi::$_cssPaths == null && Wigbi::configuration() != null)
		{
			$pathString = trim(Wigbi::configuration("cssPaths", "application"));
			if (!$pathString)
				return null;
			
			Wigbi::$_cssPaths = array();
			$paths = explode(",", $pathString);
			foreach ($paths as $path)
				array_push(Wigbi::$_cssPaths, trim($path));
		}
			
		return Wigbi::$_cssPaths;
	}
	
	/**
	 * Get the names of all data plugins that are added to the application.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @return	array		A list of data plugin class names.
	 */
	public static function dataPluginClasses()
	{
		//Return cached value, if any
		if (Wigbi::$_dataPluginClasses)
			return Wigbi::$_dataPluginClasses;

		//Add all existing data plugin class names
		$result = array();		
		foreach (glob(Wigbi::dataPluginFolder() . "*.php") as $classFile)
			array_push($result, str_replace(".php", "", basename($classFile)));

		//Save and return result
		Wigbi::$_dataPluginClasses = $result; 
		return $result;
	}
	
	/**
	 * Get the path to the data plugin folder.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @return	string	The application relative path to the data plugin folder.
	 */
	public static function dataPluginFolder()
	{
		return Wigbi::wigbiFolder() . "plugins/data/";
	}
	
	/**
	 * Get the data plugin JavaScript file that is auto-generated by Wigbi.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @return	string	The data plugin JavaScript file that is auto-generated by Wigbi.
	 */
	public static function dataPluginJavaScriptFile()
	{
		return Wigbi::wigbiFolder() . "js/wigbi_dataPlugins.js";
	}
	
	/**
	 * Get the default Wigbi DatabaseHandler object.
	 * 
	 * This object is initialized when Wigbi is started and uses the
	 * mySQL section parameters from the configuration file.
	 * 
	 * If you do not want Wigbi to use a database, leave the section
	 * blank. Do note, however, that data plugins require a database.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @return	DatabaseHandler	The default Wigbi DatabaseHandler object.
	 */
	public static function dbHandler()
	{
		return Wigbi::$_dbHandler;
	}
	
	/**
	 * Get/set whether or not Wigbi is to generate any HTML when started.
	 * 
	 * This property is only used by Wigbi, to avoid HTML with AJAX. 
	 * 
	 * @access	public
	 * @static
	 * 
	 * @param		bool	$value	Optional set value.
	 * @return	bool					Whether or not Wigbi is to generate any HTML when started.
	 */
	public function generateHtml($value = true)
	{
		if(func_num_args() != 0)
			Wigbi::$_generateHtml = func_get_arg(0);
		return Wigbi::$_generateHtml;
	}
	
	/**
	 * Get whether or not the current page state is asynchronous.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @return	bool	Whether or not the current page state is asynchronous.
	 */
	public static function isAjaxPostback()
	{
		if (array_key_exists("wigbi_asyncPostBack", $_POST))
			return $_POST["wigbi_asyncPostBack"] ? true : false;
		return false;
	}
	
	/**
	 * Get whether or not Wigbi is started.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @return	bool	Whether or not Wigbi is started.
	 */
	public static function isStarted()
	{
		return Wigbi::$_isStarted;
	}
	
	/**
	 * Get/set a list of JavaScript folder/file paths to apply during when Wigbi is started.
	 * 
	 * By default, Wigbi will use the application.jsPaths configuration
	 * key from the configuration file. To override this value, set the
	 * property to the paths you want to use, before starting Wigbi.
	 * 
	 * 
	 * @access	public
	 * @static
	 * 
	 * @param		array	$value	Optional set value.
	 * @return	array					A list of JavaScript folder/file paths to apply when Wigbi is started.
	 */
	public function jsPaths($value = null)
	{
		if (func_num_args() != 0)
			Wigbi::$_jsPaths = func_get_arg(0);

		if (Wigbi::$_jsPaths == null && Wigbi::configuration() != null)
		{
			$pathString = trim(Wigbi::configuration("jsPaths", "application"));
			if (!$pathString)
				return null;
			
			Wigbi::$_jsPaths = array();
			$paths = explode(",", $pathString);
			foreach ($paths as $path)
				array_push(Wigbi::$_jsPaths, trim($path));
		}
			
		return Wigbi::$_jsPaths;
	}
	
	/**
	 * Get/set a custom language file to use during startup.
	 * 
	 * Use this property to provide Wigbi with a custom language ini
	 * file that will be used instead of the language file specified
	 * in the Wigbi configuration file.
	 * 
	 * Remember to set this property before starting Wigbi, since it
	 * is applied during startup.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @param		string	$value	Optional set value.
	 * @return	string					A custom language file to use during startup.
	 */
	public function languageFile($value = true)
	{
		if(func_num_args() != 0)
			Wigbi::$_languageFile = func_get_arg(0);
		return Wigbi::$_languageFile;
	}
	
	/**
	 * Get the default Wigbi LanguageHandler object.
	 * 
	 * This object is initialized when Wigbi is started and uses the
	 * languageHandler section in the Wigbi configuration file.
	 * 
	 * To make the handler use a different file than the one that is
	 * set in the config file, use the languageFile(...) property.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @return	LanguageHandler	The default Wigbi LanguageHandler object.
	 */
	public static function languageHandler()
	{
		return Wigbi::$_languageHandler;
	}
	
	/**
	 * Get the default Wigbi LogHandler object.
	 * 
	 * This object is initialized when Wigbi is started and uses the
	 * logHandler section in the Wigbi configuration file.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @return	LogHandler	The default Wigbi LogHandler object.
	 */
	public static function logHandler()
	{
		return Wigbi::$_logHandler;
	}
	
	/**
	 * Get the application relative path to the PHP folders that are handled by Wigbi.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @return	array	The application relative path to the PHP folders that are handled by Wigbi.
	 */
	public static function phpFolders()
	{
		$baseFolder = Wigbi::wigbiFolder() . "php/";
		
		return array($baseFolder . "wigbi/core/", $baseFolder . "wigbi/", Wigbi::dataPluginFolder(), Wigbi::uiPluginFolder(), $baseFolder);
	}
	
	/**
	 * The header that is added to automatically created Wigbi JavaScript files.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @return	string	The header that is added to automatically created Wigbi JavaScript files.
	 */
	public static function scriptFileHeader()
	{
		$result  = "/* ***************************************\r\n";
		$result .= "Wigbi " . Wigbi::version() . "\r\n";
		$result .= "http://www.wigbi.com\r\n\r\n";
		
		$result .= "Copyright © " . date("Y") . " Daniel Saidi\r\n";
		$result .= "Licensed under the GPLv3 license.\r\n";
		$result .= "http://www.gnu.org/licenses/gpl-3.0.html\r\n";
		$result .= "*************************************** */\r\n\r\n";
		
		return $result; 
	}
	
	/**
	 * Get the application root folder path for the SERVER.
	 * 
	 * The application root folder is where the wigbi folder exists.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @return	string	The application root folder path for the SERVER.
	 */
	public static function serverRoot()
	{
		if (isset(Wigbi::$_serverRoot))
			return Wigbi::$_serverRoot;
		while (!is_dir((Wigbi::$_serverRoot . "wigbi")))
			Wigbi::$_serverRoot .= "../";			
		return Wigbi::$_serverRoot;
	}
	
	/**
	 * Get the default Wigbi SessionHandler object.
	 * 
	 * This object is initialized when Wigbi is started and uses the
	 * application name from the Wigbi configuration file.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @return	SessionHandler	The default Wigbi SessionHandler object.
	 */
	public static function sessionHandler()
	{
		return Wigbi::$_sessionHandler;
	}
	
	/**
	 * Get the names of all UI plugins that are added to the application.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @return	array		A list of UI plugin class names.
	 */
	public static function uiPluginClasses()
	{
		//Return cached value, if any
		if (Wigbi::$_uiPluginClasses)
			return Wigbi::$_uiPluginClasses;

		//Init variables
		$result = array();
		
		//Loop through class folder
		foreach (glob(Wigbi::uiPluginFolder() . "*.php") as $classFile)
			array_push($result, str_replace(".php", "", basename($classFile)));

		//Save and return result
		Wigbi::$_uiPluginClasses = $result; 
		return $result;
	}
	
	/**
	 * Get the application relative path to the UI plugin folder.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @return	string	The application relative path to the UI plugin folder.
	 */
	public static function uiPluginFolder()
	{
		return Wigbi::wigbiFolder() . "plugins/ui/";
	}
	
	/**
	 * Get the UI plugin JavaScript file that is auto-generated by Wigbi.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @return	string	The UI plugin JavaScript file that is auto-generated by Wigbi.
	 */
	public static function uiPluginJavaScriptFile()
	{
		return Wigbi::wigbiFolder() . "js/wigbi_uiPlugins.js";
	}
	
	/**
	 * Get the version of the currently used Wigbi framework.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @return	string	The version of the currently used Wigbi framework.
	 */
	public static function version()
	{
		return Wigbi::$_version;
	}
	
	/**
	 * Get the path to the application root folder for the PAGE.
	 * 
	 * The application root folder is where the wigbi folder exists.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @return	string	The path to the application root folder for the PAGE.
	 */
	public static function webRoot()
	{
		//Return any pre-set values
		if (Wigbi::$_webRoot)
			return Wigbi::$_webRoot;

		//Retieve configuration value - return server root if none is set
        $webRoot = Wigbi::configuration("webRoot", "application");
		if (!$webRoot)
			return "";
			
		//Add a / to the end of the path, if needed
        if ($webRoot[strlen($webRoot) - 1] != '/')
            $webRoot = $webRoot . "/";

		//Get the "raw" url with the root path removed
		$url = $_SERVER["REQUEST_URI"];
		$url = ($webRoot == "/") ? substr($url, 1) : str_replace($webRoot, "", $url);
		
		//Add a ../ for each 
        $result = "";
        for ($i = 0; $i < strlen($url); $i++)
        {
            if ($url[$i] == '.' || $url[$i] == '?' || $url[$i] == '&' || $url[$i] == '#')
                break;
            if ($url[$i] == '/')
                $result .= "../";
        }

		//Return the resulting path
		Wigbi::$_webRoot = $result;
        return $result;		
	}
	
	/**
	 * Get the path to the Wigbi folder.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @return	string	The path to the Wigbi folder.
	 */
	public static function wigbiFolder()
	{
		return Wigbi::serverRoot() . "wigbi/";
	}
	
	
	
	/**
	 * This function returns anything that is provided to it.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @return	mixed	The value to return.
	 */
	public static function ping($object, $throwException = false)
	{
		if ($throwException)
			throw new Exception('ERROR!');
		return $object;
	}
	
	/**
	 * Start Wigbi.
	 * 
	 * @access	public
	 * @static
	 */
	public static function start()
	{
		//Handle async postback configuration
		Wigbi::start_handleAjaxConfiguration();
		
		//Include the entire php library, except already included wigbi.php
		foreach (Wigbi::phpFolders() as $folder)
			foreach (glob($folder . "/*.php") as $fileName)
				if (!strpos($fileName, "/wigbi.php"))
					require_once($fileName);
				
		//Initialize configuration
		Wigbi::start_configuration();
		
		//Start the various handlers, then init plugins
		Wigbi::start_cacheHandler();
		Wigbi::start_databaseHandler();
		Wigbi::start_languageHandler();
		Wigbi::start_logHandler();
		Wigbi::start_sessionHandler();
		
		//Init plugins
		Wigbi::start_dataPlugins();
		Wigbi::start_uiPlugins();
		
		//Handle async postback
		Wigbi::start_handleAjaxPostBack();
		
		//Generate page output
		Wigbi::start_generateHtml();
		
		//Set Wigbi to started
		Wigbi::$_isStarted = true;
	}
	
	/**
	 * Start the Wigbi CacheHandler instance.
	 */
	private static function start_cacheHandler()
	{
		Wigbi::$_cacheHandler = new CacheHandler(Wigbi::serverRoot() . Wigbi::configuration("folder", "cacheHandler"));
	}
	
	/**
	 * Start the Wigbi configuration IniHandler instance.
	 */
	private static function start_configuration()
	{
		//Reset web root
		Wigbi::$_webRoot = null;
		
		//Abort if neither file exists
		if (!file_exists(Wigbi::configFile()) && !file_exists(Wigbi::configFile_default()))
			throw new Exception("Neither " . Wigbi::configFile() . " nor " . Wigbi::configFile_default() . " exist. Wigbi requires any such (valid) configuration file to start.");
			
		//Create the config file if it does not exist
		if (!file_exists(Wigbi::configFile()))
			if (!copy(Wigbi::configFile_default(), Wigbi::configFile()))
				throw new Exception(Wigbi::configFile_default() . " could not be copied to " . Wigbi::configFile() . ". Copy the file manually or make sure that Wigbi is allowed to create the file.");
		
		//Try to parse the configuration file
		Wigbi::$_configuration = new IniHandler();
		if (!Wigbi::$_configuration->parseFile(Wigbi::configFile()))
			throw new Exception("The Wigbi configuration file " . Wigbi::configFile() . " could not be parsed. Wigbi must be able to parse this file to proceed.");
		
		//Abort if mandatory parameters are missing
		if (!Wigbi::configuration("name", "application"))
			throw new Exception('The application.name parameter in the Wigbi configuration file must have a value, e.g. "My Application".');
		if (!Wigbi::configuration("webRoot", "application"))
			throw new Exception('The application.webRoot parameter in the Wigbi configuration file must have a value, e.g. /myApp/ if the application is located in http://localhost/myApp/.');
	}
	
	/**
	 * Start the Wigbi DatabaseHandler instance.
	 */
	private static function start_databaseHandler()
	{
		//Get mySQL database parameters 
		$mySQL_host = Wigbi::configuration("host", "mySQL");
		$mySQL_dbName = Wigbi::configuration("dbName", "mySQL");
		$mySQL_uid = Wigbi::configuration("uid", "mySQL");
		$mySQL_password = Wigbi::configuration("password", "mySQL");
		
		//If RTB is enabled, Wigbi will try to create the database
		if (Wigbi::configuration("enabled", "runtimeBuild"))
		{
			//Connect to the database server, if any, abort if failed
			Wigbi::$_dbHandler = new DatabaseHandler($mySQL_host, null, $mySQL_uid, $mySQL_password);
			if ($mySQL_host && !Wigbi::$_dbHandler->connect())
				throw new Exception("Wigbi could not establish a connection for creation to the specified database provider at " . $mySQL_host . ". Make sure that the mySQL information in the Wigbi configuration file is valid.");
			
			//Check if the database should be needed
			if (!Wigbi::$_dbHandler->databaseExists($mySQL_dbName))
				Wigbi::$_dbHandler->query('CREATE DATABASE ' . $mySQL_dbName);
				
			//Finally, prepare for reconnect
			Wigbi::$_dbHandler->disconnect();
		} 
		
		//Connect to the database using the Wigbi database, if any, abort if failed
		Wigbi::$_dbHandler = new DatabaseHandler($mySQL_host, $mySQL_dbName, $mySQL_uid, $mySQL_password);
		if ($mySQL_host && !Wigbi::$_dbHandler->connect())
			throw new Exception("Wigbi could not establish a connection to the database " . $mySQL_dbName . ". Make sure that it exists and that the mySQL information in the Wigbi configuration file is valid.");
	}
	
	/**
	 * Start the Wigbi data plugin layer.
	 */
	private static function start_dataPlugins()
	{
		//Abort if RTB is not enabled
		if (!Wigbi::configuration("enabled", "runtimeBuild"))
			return;
			
		//Disable the auto-reset behavior of the base class
		WigbiDataPlugin::autoReset(false);
		
		//Prepare the database for each class
		foreach (Wigbi::dataPluginClasses() as $class)
		{
			eval('$tmpObj = new ' . $class . '();');
			$tmpObj->setupDatabase();
		}
		
			
		//Delete the seed JavaScript file if it exists
		$jsFile = Wigbi::dataPluginJavaScriptFile();
		if (file_exists($jsFile))
			unlink($jsFile);
		
		//Build the JavaScript source code string
		$content = "";
		$separator = "\r\n\r\n";
		foreach (Wigbi::dataPluginClasses() as $class)
		{
			eval('$tmpObj = new ' . $class . '();');
			$content .= WigbiDataPluginJavaScriptGenerator::getJavaScript($tmpObj) . $separator;
		}
		
		//Obfuscate the source code, if obfuscation is enabled
		if (Wigbi::configuration("obfuscate", "runtimeBuild"))
		{
			$seedPacker = new JavaScriptPacker($content);
			$content = $seedPacker->pack();
		}
		
		//Add script file header to file content
		$content = Wigbi::scriptFileHeader() . $content;
		
		//Write the source code string to file		
		$file = fopen($jsFile, "w");
		if (!$file)
			throw new Exception("Wigbi can not generate or write to the data plugin JavaScript file - " . $jsFile . ". Wigbi can not start!");
		fwrite($file, $content);
		fclose($file);
		
		//Enable the auto-reset behavior of the base class
		WigbiDataPlugin::autoReset(true);
	}
	
	/**
	 * Generate start operation page output, with encoding as well as CSS/JS files. 
	 */
	private static function start_generateHtml()
	{
		//Abort if async postback or if HTML is not to be rendered
		if (!Wigbi::generateHtml() || Wigbi::isAjaxPostback())
			return;
		
		//Add encoding tag and validation css
		print "<meta http-equiv=\"Content-Type\" content=\"text/css; charset=UTF-8\" />";
		
		//Create CSS tag
		$cssPath	 = Wigbi::webRoot() . "wigbi/bundle/css:wigbi/css";
		$cssPaths = Wigbi::cssPaths() == null ? null : join(",", Wigbi::cssPaths());
		$cssPath	.= $cssPaths ? "," . $cssPaths : "";
		print "<link rel=\"stylesheet\" type=\"text/css\" href=\"" . $cssPath . "\" />";
		 
		//Create js tag
		$jsPath	 = Wigbi::webRoot() . "wigbi/bundle/js:wigbi/js/wigbi/core,wigbi/js/wigbi,wigbi/js";
		$jsPaths = Wigbi::jsPaths() == null ? null : join(",", Wigbi::jsPaths());
		$jsPath	.= $jsPaths ? "," . $jsPaths : "";
		print "<script type=\"text/javascript\" src=\"" . $jsPath . "\"></script>";
		
		//Build the page's js code
		$jsCode  = "Wigbi._webRoot = '" . Wigbi::webRoot() . "';";
		$jsCode .= "Wigbi._dataPluginClasses = " . ((sizeof(Wigbi::dataPluginClasses()) == 0) ? "[];" : "['" . implode("','", Wigbi::dataPluginClasses()) . "'];");
		$jsCode .= "Wigbi._uiPluginClasses = " . ((sizeof(Wigbi::uiPluginClasses()) == 0) ? "[];" : "['" . implode("','", Wigbi::uiPluginClasses()) . "'];");
		$jsCode .= "Wigbi._cacheHandler = new CacheHandler('" . Wigbi::webRoot() . str_replace("../", "", Wigbi::configuration("folder", "cacheHandler")) . "');";
		$jsCode .= "Wigbi._languageHandler = new LanguageHandler(" . json_encode(Wigbi::languageHandler()->data()) . ");";
		$jsCode .= "Wigbi._logHandler = new LogHandler('" . Wigbi::logHandler()->id() . "');";
		$jsCode .= "Wigbi._logHandler._handlers = JSON.parse('" . json_encode(Wigbi::logHandler()->handlers()) . "');";
		$jsCode .= "Wigbi._sessionHandler = new SessionHandler('" . Wigbi::configuration("name", "application") . "');";
		$packer = new JavaScriptPacker($jsCode);
		print "<script type=\"text/javascript\">" . $packer->pack() . "</script>";
	}

	/**
	 * Handle an asynchronous configuration that has been sent by Wigbi.
	 * 
	 * This function is automatically used when Wigbi is started. It
	 * is used to change the configuration file for an ajax request.
	 *  
	 * 
	 * @access	protected
	 * @static
	 * 
	 * @return	mixed	The function result; null if the operation failed.
	 */
	protected static function start_handleAjaxConfiguration()
	{	
		//Abort if not async postback
		if (!Wigbi::isAjaxPostback())
			return null;
			
		//Extract posted data
		$data = json_decode($_POST["wigbi_asyncPostBackData"]);
			
		//Override the web root and config file properties
		Wigbi::$_configFile =  $data->configFile ? Wigbi::serverRoot() . $data->configFile : Wigbi::$_configFile;
	}
	
	/**
	 * Handle an asynchronous parameter that has been sent by Wigbi.
	 * 
	 * @access	protected
	 * @static
	 * 
	 * @param	mixed	$parameter	The parameter to handle.
	 */
	protected static function start_handleAjaxParameter($parameter)
	{	
		switch (gettype($parameter))
		{
			case "string":
				return '"' . str_replace("\"", "\\\"", $parameter) . '"';
			case "integer":
			case "double":
				return $parameter;
			case "boolean":
				return $parameter ? 1 : 0;
			case "array":
				$result = "";
				foreach ($parameter as $item)
				{
					if ($result)
						$result .= ",";
					$result .= Wigbi::start_handleAjaxParameter($item);
				}
				return "array(" . $result . ")";
			default:
				return null;
		}
	}
	
	/**
	 * Handle an asynchronous call that has been sent by Wigbi.
	 * 
	 * This method is automatically called when Wigbi is started. It
	 * is not meant to be used manually.
	 * 
	 * The method does not return anything. Instead, it prints out a
	 * JSON string, which will be fetched by any async requests.
	 * 
	 * @access	protected
	 * @static
	 */
	protected static function start_handleAjaxPostBack()
	{
		//Abort if not async postback
		if (!Wigbi::isAjaxPostback())
			return;
		
		//Init result and exception
		$result = null;
		$exception = null;
		
		//Try/catch the entire operation, to handle exception result
		try
		{
			//Extract posted data and get environment data
			$data = json_decode($_POST["wigbi_asyncPostBackData"]);
			$configFile = $data->configFile;
			$webRoot = $data->webRoot;
			
			//Get method related data
			$className = $data->className;
			$object = $data->object;
			$functionName = $data->functionName;
			$functionParameters = $data->functionParameters ? $data->functionParameters : array();
			$functionParameters_handled = array();
			
			//Modify web root, if needed
			Wigbi::$_webRoot = $webRoot ? $webRoot : Wigbi::$_webRoot;
			
			//Create parameter string
			foreach ($functionParameters as $parameter)
				array_push($functionParameters_handled, Wigbi::start_handleAjaxParameter($parameter));
			$parameterString = "(" . implode(",", $functionParameters_handled) . ")";
			
			//Execute non-static method if object given
			if ($object)
			{	
				//Create object instance
				eval('$newObject = new ' . $className . '();');
				
				//Parse object into new object
				foreach ($object as $property=>$value)
					$newObject->$property = $value;
				
				//Reload object if data plugin
				if (in_array($className, Wigbi::dataPluginClasses()))
				{
					if ($object->_id)
						$newObject->load($object->_id);
					$newObject->parseObject($object);	
				}
				
				//Execute the function
				eval('$result=$newObject->'. $functionName . $parameterString . ';');
			}
			
			//Execute static method if no object given
			else
			{
				eval('$result=' . $className .  '::' . $functionName . $parameterString . ';');
			}	
		}
		catch (Exception $e)
		{
			$exception = $e->getMessage();
		}

		//Return result
		print json_encode(array($result, $exception));
	}
	
	/**
	 * Start the Wigbi LanguageHandler instance.
	 */
	private static function start_languageHandler()
	{
		//Use custom language file, or configuration file if none is set
		$langFile = Wigbi::languageFile() ? Wigbi::languageFile() : Wigbi::configuration("file", "languageHandler");
		
		//Initialize the default LanguageHandler instance
		Wigbi::$_languageHandler = new LanguageHandler();
		if ($langFile && !Wigbi::$_languageHandler->parseFile(Wigbi::serverRoot() . $langFile))
			throw new Exception("The default language file " . Wigbi::serverRoot() . $langFile . " could not be parsed.");
	}
	
	/**
	 * Start the Wigbi LogHandler instance.
	 */
	private static function start_logHandler()
	{
		//Initialize the default LogHandler instance
		Wigbi::$_logHandler = new LogHandler(Wigbi::configuration("name", "application"));
		
		//Parse configuration parameters
		if (Wigbi::configuration("handlers", "logHandler"))
		{
			foreach (explode(",", Wigbi::configuration("handlers", "logHandler")) as $handler)
			{
				$priorities = Wigbi::configuration($handler . ".priorities", "logHandler");
				$priorities = $priorities ? explode(",", $priorities) : array();
				$display = Wigbi::configuration($handler . ".display", "logHandler");
				$file = Wigbi::configuration($handler . ".file", "logHandler");
				$firebug = Wigbi::configuration($handler . ".firebug", "logHandler");
				$mailaddresses = Wigbi::configuration($handler . ".mailaddresses", "logHandler");
				$syslog = Wigbi::configuration($handler . ".syslog", "logHandler");
				$window = Wigbi::configuration($handler . ".window", "logHandler");
				
				Wigbi::$_logHandler->addHandler($priorities, $display, $file, $firebug, $mailaddresses, $syslog, $window);
			}
		}
	}
	
	/**
	 * Start the Wigbi SessionHandler instance.
	 */
	private static function start_sessionHandler()
	{
		//Initialize the default SessionHandler instance
		Wigbi::$_sessionHandler = new SessionHandler(Wigbi::configuration("name", "application"));
	}
	
	/**
	 * Start the Wigbi UI plugin layer.
	 */
	private static function start_uiPlugins()
	{
		//Abort if RTB is not enabled
		if (!Wigbi::configuration("enabled", "runtimeBuild"))
			return;
			
		//Delete the seed JavaScript file if it exists
		$jsFile = Wigbi::uiPluginJavaScriptFile();
		if (file_exists($jsFile))
			unlink($jsFile);
		
		//Init JavaScript file content
		$content = "";
		$separator = "\r\n\r\n";
		
		//Build the JavaScript source code string
		foreach (Wigbi::uiPluginClasses() as $class)
		{
			$uiPluginFile = Wigbi::uiPluginFolder() . $class . ".js"; 
			if (file_exists($uiPluginFile))
				$content .= file_get_contents($uiPluginFile) . $separator;
		}
		
		//Obfuscate the source code, if obfuscation is enabled
		if (Wigbi::configuration("obfuscate", "runtimeBuild"))
		{
			$seedPacker = new JavaScriptPacker($content);
			$content = $seedPacker->pack();
		}
		
		//Add script file header to file content
		$content = Wigbi::scriptFileHeader() . $content;
		
		//Write the source code string to file		
		$file = fopen($jsFile, "w");
		if (!$file)
			throw new Exception("Wigbi can not generate or write to the UI plugin JavaScript file - " . $jsFile . ". Wigbi can not start!");
		fwrite($file, $content);
		fclose($file);
	}
	
	/**
	 * Stop Wigbi.
	 * 
	 * This will stop Wigbi and make sure that all objects that were
	 * created when Wigbi was started are properly deleted. All open
	 * database connections will be closed as well.
	 * 
	 * @access	public
	 * @static
	 */
	public static function stop()
	{
		//Disconnect dbHandler if needed
		if (Wigbi::dbHandler() != null && Wigbi::dbHandler()->isConnected())
			Wigbi::dbHandler()->disconnect();	
		
		//Set handler objects to null
		Wigbi::$_cacheHandler = null;
		Wigbi::$_configuration = null;
		Wigbi::$_dbHandler = null;
		Wigbi::$_languageHandler = null;
		Wigbi::$_logHandler = null;
		Wigbi::$_sessionHandler = null;
		
		//Set some variables to null
		Wigbi::$_dataPluginClasses = null;
		Wigbi::$_uiPluginClasses = null;
		
		//Set Wigbi to not started
		Wigbi::$_isStarted = false;
	}
}

?>
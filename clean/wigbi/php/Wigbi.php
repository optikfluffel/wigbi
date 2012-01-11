<?php

class Wigbi
{
	private static $_cssPaths;
	private static $_dbHandler;
	private static $_generateHtml = true;
	private static $_isStarted;
	private static $_jsPaths;
	private static $_languageFile;
	private static $_languageHandler;
	private static $_logHandler;
	private static $_phpPaths;
	//private static $_serverRoot;
	private static $_sessionHandler;
	private static $_webRoot;
	/**#@-*/
	

	
	/**
	 * Get the CSS paths that are handled by Wigbi.
	 * 
	 * Except the system folders the application.cssPaths configuration
	 * value from the configuration file is also added to this array.
	 * 
	 * Note that the paths are application relative, since they will be
	 * bundled with the Wigbi CSS bundler.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @return	array		The CSS paths that are handled by Wigbi.
	 */
	public function cssPaths()
	{
		if (Wigbi::$_cssPaths != null)
			return Wigbi::$_cssPaths;
		
		Wigbi::$_cssPaths = array("wigbi/css");
		
		if (Wigbi::configuration() == null)
				return Wigbi::$_cssPaths;
				
		$configPaths = trim(Wigbi::configuration("cssPaths", "application"));
		if (!$configPaths)
				return Wigbi::$_cssPaths;
				
		$configPaths = explode(",", $configPaths);
		foreach ($configPaths as $path)
			array_push(Wigbi::$_cssPaths, trim($path));
			
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
		$result = array();		
		foreach (glob(Wigbi::dataPluginFolder() . "*.php") as $classFile)
			array_push($result, str_replace(".php", "", basename($classFile)));
		return $result;
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
		if (array_key_exists("HTTP_X_REQUESTED_WITH", $_SERVER))
			return $_SERVER['HTTP_X_REQUESTED_WITH'] =='XMLHttpRequest';
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
	 * Get the JavaScript paths that are handled by Wigbi.
	 * 
	 * Except the system folders, the application.jsPaths configuration
	 * value from the configuration file is also added to this array.
	 * 
	 * Note that the paths are application relative, since they will be
	 * bundled with the Wigbi JavaScript bundler.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @return	array		The JavaScript paths that are handled by Wigbi.
	 */
	public function jsPaths()
	{
		if (Wigbi::$_jsPaths != null)
			return Wigbi::$_jsPaths;
		
		Wigbi::$_jsPaths = array("wigbi/js/core", "wigbi/js", "wigbi/plugins/data", "wigbi/plugins/ui");
		
		if (Wigbi::configuration() == null)
				return Wigbi::$_jsPaths;
				
		$configPaths = trim(Wigbi::configuration("jsPaths", "application"));
		if (!$configPaths)
				return Wigbi::$_jsPaths;
				
		$configPaths = explode(",", $configPaths);
		foreach ($configPaths as $path)
			array_push(Wigbi::$_jsPaths, trim($path));
			
		return Wigbi::$_jsPaths;
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
	 * Get the PHP paths that are handled by Wigbi.
	 * 
	 * Except the system folders the application.phpPaths configuration
	 * value from the configuration file is also added to this array.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @return	array		The PHP paths that are handled by Wigbi.
	 */
	public function phpPaths()
	{
		if (Wigbi::$_phpPaths != null)
			return Wigbi::$_phpPaths;
		
		Wigbi::$_phpPaths = array(Wigbi::wigbiFolder() . "php/core/", Wigbi::wigbiFolder() . "php/", Wigbi::wigbiFolder() . "plugins/data/", Wigbi::wigbiFolder() . "plugins/ui/");
		
		if (Wigbi::configuration() == null)
				return Wigbi::$_phpPaths;
				
		$configPaths = trim(Wigbi::configuration("phpPaths", "application"));
		if (!$configPaths)
				return Wigbi::$_phpPaths;
				
		$configPaths = explode(",", $configPaths);
		foreach ($configPaths as $path)
			array_push(Wigbi::$_phpPaths, Wigbi::serverRoot() . trim($path));
			
		return Wigbi::$_phpPaths;
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
		$result = array();
		foreach (glob(Wigbi::uiPluginFolder() . "*.php") as $classFile)
			array_push($result, str_replace(".php", "", basename($classFile)));
		return $result;
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
	 * Start Wigbi.
	 * 
	 * @access	public
	 * @static
	 */
	public static function start()
	{
		//Handle async postback configuration
		Wigbi::start_handleAjaxConfiguration();
				
		//Initialize configuration and PHP layer
		Wigbi::start_configuration();
		Wigbi::start_php();
		
		//Start the various handlers, then init plugins
		Wigbi::start_cacheHandler();
		Wigbi::start_databaseHandler();
		Wigbi::start_languageHandler();
		Wigbi::start_logHandler();
		Wigbi::start_sessionHandler();
		
		//Init plugins
		Wigbi::start_dataPlugins();
		
		//Handle async postback
		Wigbi::start_handleAjaxPostBack();
		
		//Generate page output
		Wigbi::start_generateHtml();
		
		//Set Wigbi to started
		//Wigbi::$_isStarted = true;
	}
	
	/**
	 * Start the Wigbi CacheHandler instance.
	 */
	private static function start_cacheHandler()
	{
		Wigbi::$_cacheHandler = new CacheHandler(Wigbi::serverRoot() . Wigbi::configuration("folder", "cacheHandler"));
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
		
		//If RTB is enabled and data plugins are added, Wigbi will try to create the database
		if ($mySQL_host && Wigbi::configuration("enabled", "runtimeBuild"))
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
		
		//Connect to the database using the Wigbi database, if any
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
		
		//Generate a JavaScript class file for each PHP class
		foreach (glob(Wigbi::dataPluginFolder() . "*.php") as $fileName)
		{
			$jsFile = str_replace(".php", ".js", $fileName);
			if (file_exists($jsFile))
				unlink($jsFile);
				
			eval('$tmpObj = new ' . str_replace(".php", "", basename($fileName)) . '();');
			$content = Wigbi::scriptFileHeader() . WigbiDataPluginJavaScriptGenerator::getJavaScript($tmpObj);
			
			$file = fopen($jsFile, "w");
			if (!$file)
				throw new Exception("Wigbi can not generate or write to the data plugin JavaScript file - " . $jsFile . ". Wigbi can not start!");
			fwrite($file, $content);
			fclose($file);
		}

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
		$cssPaths	 = Wigbi::webRoot() . "wigbi/bundle/css:" . join(",", Wigbi::cssPaths());
		print "<link rel=\"stylesheet\" type=\"text/css\" href=\"" . $cssPaths . "\" />";
		 
		//Create js tag
		$jsPaths = Wigbi::webRoot() . "wigbi/bundle/js:" . join(",", Wigbi::jsPaths());
		print "<script type=\"text/javascript\" src=\"" . $jsPaths . "\"></script>";
		
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
		print "<script type=\"text/javascript\">//<![CDATA[\n(function(){" . $packer->pack() . "}())\n//]]></script>";
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

/*
			array_key_exists(@className, )
			//Abort if class is not handled
			if ()
			Wigbi::dataPluginClasses()
*/

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
		$langFile = Wigbi::languageFile();
		if (!$langFile && Wigbi::configuration("file", "languageHandler"))
			$langFile = Wigbi::serverRoot() . Wigbi::configuration("file", "languageHandler"); 
		
		//Initialize the default LanguageHandler instance
		Wigbi::$_languageHandler = new LanguageHandler();
		if ($langFile && !Wigbi::$_languageHandler->parseFile($langFile))
			throw new Exception("The default language file " . $langFile . " could not be parsed.");
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
	 * Start the Wigbi PHP layer.
	 */
	private static function start_php()
	{
		//Include the entire php library, except already included wigbi.php
		foreach (Wigbi::phpPaths() as $path)
		{
			if (is_dir($path))
				foreach (glob($path . "/*.php") as $fileName)
					require_once($fileName);
			
			if (is_file($path))
					require_once($path);
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
		if (Wigbi::dbHandler() != null && Wigbi::dbHandler()->isConnected())
			Wigbi::dbHandler()->disconnect();	
		
		Wigbi::$_cacheHandler = null;
		Wigbi::$_configuration = null;
		Wigbi::$_cssPaths = null;
		Wigbi::$_dbHandler = null;
		Wigbi::$_jsPaths = null;
		Wigbi::$_languageHandler = null;
		Wigbi::$_logHandler = null;
		Wigbi::$_phpPaths = null;
		Wigbi::$_sessionHandler = null;
		
		Wigbi::$_isStarted = false;
	}
}

?>
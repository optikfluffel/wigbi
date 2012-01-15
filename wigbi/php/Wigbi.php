<?php

/**
 * The Wigbi class file.
 * 
 * Wigbi is released under the MIT license. More info can be found
 * at http://www.opensource.org/licenses/mit-license.php
 */

/**
 * The Wigbi class.
 * 
 * This static class is the main class in the Wigbi framework. The
 * class is used to start and stop Wigbi and also contains methods
 * and properties that are central to the Wigbi framework.
 * 
 * Global variables that are defined by Wigbi can be accessed with
 * the static globals method. These variables are only meant to be
 * used by Wigbi and are defined in wigbi/wigbi.globals.php.
 * 
 * Wigbi provides static instances for working with cache, logging
 * etc. These are defined in wigbi/wigbi.bootstrap.php, and can be
 * replaced with other implementations if needed.
 * 
 * 
 * INCLUDE, START AND STOP WIGBI ************
 * 
 * To use Wigbi, first include wigbi/wigbi.php at the beginning of
 * the page. This will include all PHP classes and setup Wigbi, so
 * that it can be started.
 * 
 * To start Wigbi, call Wigbi::start() in the HEAD tag of the page.
 * This will start Wigbi, open data connections etc. and will also
 * output all content that has to be added to the HEAD tag.
 * 
 * To stop Wigbi, just call Wigbi::stop() when Wigbi is not needed
 * anymore. This will shut down data connections etc.
 * 
 *
 * WIGBI RUNTIME BUILD (RTB) ***************
 * 
 * Wigbi Runtime Build (RTB) is a feature that automatically keeps
 * the system in sync. It syncs the database with all data plugins,
 * regenerates plugin JavaScript files etc.  
 * 
 * To enable RTB, set the application.runtimeBuild variable in the
 * Wigbi config file to 1.
 * 
 * RTB can be enabled during development to keep Wigbi in constant,
 * but should be disabled live, since it is a heavy operation. For
 * live systems, only enable RTB to sync any changes.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2012, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP
 * @version			2.0.0
 */
class Wigbi
{
	private static $_version = "2.0.0";
	private static $_isStarted = false;
	
	private static $_cache;
	private static $_configuration;
	private static $_cookies;
	private static $_fileIncluder;
	private static $_logger;
	private static $_session;
	private static $_translator;
	
	
	
	// Properties ********************
	
	/**
	 * All Wigbi global variables, in an associative array.
	 * 
	 * @return	array
	 */
	public static function globals()
	{
		global $wigbi_globals;
		return $wigbi_globals;
	}
	
	/**
	 * @return	bool
	 */
	public static function isStarted()
	{
		return Wigbi::$_isStarted;
	}
	
	/**
	 * @return	string
	 */
	public static function version()
	{
		return Wigbi::$_version;
	}
	
	
	
	// Bootstrap implementations *****
	
	/**
	 * @param	ICache			$cache		Optional set value.
	 * @return	ICache
	 */
	public static function cache($cache = null)
	{
		if (func_num_args() > 0)
			Wigbi::$_cache = func_get_arg(0);
		return Wigbi::$_cache;
	}
	
	/**
	 * @param	IConfiguration	$config		Optional set value.
	 * @return	IConfiguration
	 */
	public static function configuration($config = null)
	{
		if (func_num_args() > 0)
			Wigbi::$_configuration = func_get_arg(0);
		return Wigbi::$_configuration;
	}
	
	/**
	 * @param	ICookies		$cookies	Optional set value.
	 * @return	ICookies
	 */
	public static function cookies($cookies = null)
	{
		if (func_num_args() > 0)
			Wigbi::$_cookies = func_get_arg(0);
		return Wigbi::$_cookies;
	}
	
	/**
	 * @param	IFileIncluder	$fileIncluder	Optional set value.
	 * @return	IFileIncluder
	 */
	public static function fileIncluder($fileIncluder = null)
	{
		if (func_num_args() > 0)
			Wigbi::$_fileIncluder = func_get_arg(0);
		return Wigbi::$_fileIncluder;
	}
	
	/**
	 * @param	ILogger		$logger		Optional set value.
	 * @return	ILogger
	 */
	public static function logger($logger = null)
	{
		if (func_num_args() > 0)
			Wigbi::$_logger = func_get_arg(0);
		return Wigbi::$_logger;
	}
	
	/**
	 * @param	ISession		$session	Optional set value.
	 * @return	ISession
	 */
	public static function session($session = null)
	{
		if (func_num_args() > 0)
			Wigbi::$_session = func_get_arg(0);
		return Wigbi::$_session;
	}
	
	/**
	 * @param	ITranslator		$translator		Optional set value.
	 * @return	ITranslator
	 */
	public static function translator($translator = null)
	{
		if (func_num_args() > 0)
			Wigbi::$_translator = func_get_arg(0);
		return Wigbi::$_translator;
	}
	
	
	
	// Wigbi functionality ***********
	
	/**
	 * Get the application root path for the client.
	 * 
	 * If the path argument is set, it will be appended at the end
	 * of the application root path.
	 * 
	 * @return	string
	 * @param	string	$path	Optional path to add to the client root.
	 */
	public static function clientRoot($path = null)
	{
		//Get the config value
		$root = Wigbi::configuration()->get("application", "clientRoot");

		//Get the absolute url with the root path removed
		$url = Url::current()->path();
		$url = ($root == "/") ? substr($url, 1) : str_replace($root, "", $url);
		
		//Add a ../ for each 
        $result = "";
        for ($i = 0; $i < strlen($url); $i++)
            if ($url[$i] == '/')
                $result .= "../";

		//Return the resulting path and append any provided path
        return $result . $path;
	}
	
	
	/**
	 * Get the application root path for the server.
	 * 
	 * If the path argument is set, it will be appended at the end
	 * of the application root path.
	 * 
	 * @return	string
	 * @param	string	$path	Optional path to add to the server root.
	 */
	public static function serverRoot($path = null)
	{
		global $wigbi_globals;
		return $wigbi_globals["root"] . $path;
	}
	
	/**
	 * Start Wigbi.
	 * 
	 * This method must be executed in the HEAD tag if Wigbi is to
	 * be used on a web site, where HTML is returned to the client.
	 */
	public static function start()
	{
		//Abort if Wigbi is started with invalid configuration
		if (!Wigbi::configuration()->get("application", "name"))
			throw new Exception('The application.name key in the Wigbi config file must have a value, e.g. "My Application".');
		if (!Wigbi::configuration()->get("application", "clientRoot"))
			throw new Exception('The application.clientRoot key in the Wigbi config file must have a value, e.g. "/myApp/" if the site is located in http://localhost/myApp/.');
		
		Wigbi::$_isStarted = true;
	}
	
	/**
	 * Stop Wigbi.
	 * 
	 * This method can be executed when Wigbi is no longer needed.
	 * It does not output anything.
	 */
	public static function stop()
	{
		Wigbi::$_isStarted = false;
	}
}

?>
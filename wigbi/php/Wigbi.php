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
 * To start Wigbi, call Wigbi::start() in the head tag of the page.
 * This will start Wigbi, open data connections etc. To stop Wigbi,
 * just call Wigbi::stop() when Wigbi is not needed anymore.
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
 * 
 * @static
 */
class Wigbi
{
	private static $_version = "2.0.0";
	
	private static $_configuration;
	
	
	/**
	 * Get/set the Wigbi configuration.
	 * 
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
	 * Get all Wigbi global variables in an associative array.
	 * 
	 * @return	array
	 */
	public static function globals()
	{
		global $wigbi_globals;
		return $wigbi_globals;
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
	 * Get the version of the currently used Wigbi release.
	 * 
	 * @return	string
	 */
	public static function version()
	{
		return Wigbi::$_version;
	}
	
	
	
}

?>
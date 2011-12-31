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
 * 
 * INCLUDE, START AND STOP WIGBI ************
 * 
 * To use Wigbi, first include wigbi/wigbi.php at the beginning of
 * the page. This will include all PHP classes and setup Wigbi, so
 * that it can be started.
 * 
 * To start Wigbi, call Wigbi::start() in the head tag of the page.
 * This will init Wigbi classes, open database connections etc. To
 * stop Wigbi, call Wigbi::stop() when Wigbi is not needed anymore,
 * e.g. at the end of the page.
 * 
 *
 * WIGBI RUNTIME BUILD (RTB) ***************
 * 
 * Wigbi Runtime Build (RTB) is a feature that automatically keeps
 * the system in sync. It syncs the database with all data plugins,
 * regenerates plugin JavaScript files etc.  
 * 
 * To enable RTB, set application.runtimeBuild in the Wigbi config
 * file to 1. RTB can be enabled during development, but should be
 * disabled live, since it is a rather heavy operation. For a live
 * system, only enable RTB when changes have to be synced.
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
	
	private static $_serverRoot;
	
	
	
	/**
	 * Get the path to the Wigbi configuration file.
	 * 
	 * @return	string
	 */
	public static function configFile()
	{
		return Wigbi::serverWigbiRoot() . "config.ini";
	}
	
	/**
	 * Get the path to the Wigbi configuration template.
	 * 
	 * @return	string
	 */
	public static function configFileTemplate()
	{
		return Wigbi::serverWigbiRoot() . "assets/config_template.ini";
	}
	
	/**
	 * Get the path to the Wigbi data plugin folder.
	 * 
	 * @return	string
	 */
	public static function dataPluginFolder()
	{
		return Wigbi::serverWigbiRoot() . "plugins/data/";
	}
	
	/**
	 * Get the application root path for the server.
	 * 
	 * @return	string
	 */
	public static function serverRoot()
	{
		if (isset(Wigbi::$_serverRoot))
			return Wigbi::$_serverRoot;
		
		$root = "";
		while(!is_dir($root . "wigbi/"))
			$root = "../" . $root;
		Wigbi::$_serverRoot = $root;
						
		return Wigbi::$_serverRoot;
	}
	
	/**
	 * Get the wigbi root path for the server.
	 * 
	 * @return	string
	 */
	public static function serverWigbiRoot()
	{
		return Wigbi::serverRoot() . "wigbi/";
	}
	
	/**
	 * Get the path to the Wigbi UI plugin folder.
	 * 
	 * @return	string
	 */
	public static function uiPluginFolder()
	{
		return Wigbi::serverWigbiRoot() . "plugins/ui/";
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
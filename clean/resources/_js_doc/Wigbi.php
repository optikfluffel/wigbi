<?php
/**
 * The Wigbi.JS.Wigbi class file.
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
 * The Wigbi.JS.Wigbi class.
 * 
 * This is the most central class in the Wigbi framework. It is used
 * to start and stop Wigbi applications and provides central utility
 * functions and properties.
 * 
 * One important difference between the PHP and the JavaScript class
 * is that the JS class has no start funtion. It is initialized when
 * Wigbi is started in PHP. Also, the JS class features a handy ajax
 * function that can be use to execute PHP functions with JavaScript. 
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2010, Daniel Saidi
 * @link				http://www.wigbi.com
 * @package			Wigbi
 * @subpackage	JS
 * @version			1.0.0
 * 
 * @static
 */
class Wigbi_
{	
	/**
	 * Get the relative path to the Wigbi async postback page.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @return	string	Get the relative path to the Wigbi async postback page.
	 */
	public static function asyncPostBackPage() { return ""; }
	
	/**
	 * Get the default Wigbi CacheHandler instance.
	 * 
	 * This object is initialized when Wigbi is started and uses the
	 * cacheHandler section in the Wigbi config file.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @return	CacheHandler	The default Wigbi CacheHandler object.
	 */
	public static function cacheHandler() { return null; }

	/**
	 * Get the names of all data plugins that has been added to the application.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @return	array	The names of all data plugins that has been added to the application
	 */
	public static function dataPluginClasses() { return array(); }
	
	/**
	 * Get the default Wigbi LanguageHandler object.
	 * 
	 * This object is initialized when Wigbi is started and uses the
	 * languageHandler section in the Wigbi configuration file.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @return	LanguageHandler	The default Wigbi LanguageHandler object.
	 */
	public static function languageHandler() { return null; }
	
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
	public static function logHandler() { return null; }
	
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
	public static function sessionHandler() { return null; }
	
	/**
	 * Get the names of all data plugins that has been added to the application.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @return	array	The names of all data plugins that has been added to the application.
	 */
	public static function uiPluginClasses() { return array(); }
	
	/**
	 * Get the path to the application root folder for the PAGE.
	 * 
	 * The application root folder is where the wigbi folder exists.
	 * 
	 * Use this property if a path is handled by the CLIENT. It will
	 * make the path context independent, which makes it work within
	 * virtual paths as well, unlike absolute and relative paths.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @return	string	The path to the application root folder for the PAGE.
	 */
	public static function webRoot() { return ""; }
	
	
	
	/**
	 * Add an UI plugin instance to the Wigbi UI plugin collection.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @param	WigbiUIPlugin	$uiPlugin	The UI plugin to add.
	 */
	public static function addUIPlugin($uiPlugin) { }
	
	/**
	 * This function returns anything that is provided to it.
	 * 
	 * This function can be used to test the Wigbi AJAX pipeline, so
	 * that it returns all supported data types correctly.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @param	string		$className			The name of the class that executed the AJAX call.
	 * @param	mixed		$object				The object, if any, that executes the AJAX call (none if static method).
	 * @param	string		$functionName		The name of the function to execute.
	 * @param	array		$functionParameters	An ordered list of function parameters.
	 * @param	function	$callBack			Raised when the AJAX call returns a response.
	 */
	public static function ajax($className, $object, $functionName, $functionParameters, $callBack) { }
	
	/**
	 * Retreive an added UI plugin instance from the Wigbi UI plugin collection.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @param	string			$id			The IF of the UI plugin.
	 * @return	WigbiUIPlugin	$uiPlugin	The UI plugin instance.
	 */
	public static function getUIPlugin($id) { }
}
?>
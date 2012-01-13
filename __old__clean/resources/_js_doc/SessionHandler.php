<?php
/**
 * Wigbi.JS.SessionHandler class file.
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
 * The Wigbi.JS.SessionHandler class.
 * 
 * This class can be used to save and retrieve session data. It fully
 * supports all serializible data and can thus handle complex objects
 * as well as simple strings, integers etc.
 * 
 * Since this class is based on asynchronous methods, data is handled
 * by both JavaScript and PHP. Thus, complex objects should be cached
 * only after being serialized first.
 * 
 * See the documentation for the corresponding PHP class for further
 * information about how to work with session data.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2010, Daniel Saidi
 * @link				http://www.wigbi.com
 * @package			Wigbi
 * @subpackage	JS
 * @version			1.0.0
 */
class SessionHandler_ extends WigbiClass_
{
	/**
	 * Create an instance of the class.
	 * 
	 * @access	public
	 * 
	 * @param	string	$applicationName	The name of the application to which the data belongs; default empty.
	 */
	public function __construct($applicationName = "")
	{
		$this->applicationName($applicationName);
	}
	
	
	
	/**
	 * Get/set the name of the application to which the data belongs.
	 * 
	 * @access	public
	 * 
	 * @param	string	$value	Optional set value.
	 * @return	string			The name of the application to which the data belongs.
	 */
	public function applicationName($value = "") { return ""; }
	
	
	
	/**
	 * [ASYNC] Clear the value of a certain session variable.
	 * 
	 * Callback method signature: onClear() 
	 * 
	 * @access	public
	 * 
	 * @param	string		$key		The name of the session variable to clear.
	 * @param	function	$onClear	Raised when the AJAX call returns a response.
	 */
    public function clear($key, $onClear) { }
	
	/**
	 * [ASYNC] Get the value of a certain session variable.
	 * 
	 * Callback method signature: onGet(object data) 
	 * 
	 * @access	public
	 * 
	 * @param	string		$key	The name of the session variable to retrieve.
	 * @param	function	$onGet	Raised when the AJAX call returns a response.
	 */
	public function get($key, $onGet) { return null; }
	
	/**
	 * [ASYNC] Set the value of a certain session variable.
	 *  
	 * Callback method signature: onSet() 
	 * 
	 * @access	public
	 * 
	 * @param	string		$key		The name of the session variable to set.
	 * @param	function	$onSet		Raised when the AJAX call returns a response.
	 */
	public function set($key, $onSet) { }
}
?>
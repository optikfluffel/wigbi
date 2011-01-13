<?php

/**
 * Wigbi.PHP.SessionHandler class file.
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
 * The Wigbi.PHP.SessionHandler class.
 * 
 * This class can be used to save and retrieve session data. It fully
 * supports all serializible data and can thus handle complex objects
 * as well as simple strings, integers etc.
 *
 * If wanted, the class ensures that session data strictly belongs to
 * a certain application instead of to all applications on the server.
 * Set the applicationName property to enable this behavior.
 * 
 * Wigbi automatically adds session_start to the very first page line,
 * so the class can be used without having to enable session handling
 * manually. Remember to enable it if the class is used without Wigbi.  
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2010, Daniel Saidi
 * @link				http://www.wigbi.com
 * @package			Wigbi
 * @subpackage	PHP
 * @version			1.0.0
 */
class SessionHandler
{
	/**#@+
	 * @ignore
	 */
	public $_applicationName = "";
	/**#@-*/

	
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
	 * @param		string	$value	Optional set value.
	 * @return	string					The name of the application to which the data belongs.
	 */
	public function applicationName($value = "")
	{
		if(func_num_args() != 0)
			$this->_applicationName = func_get_arg(0);
		return $this->_applicationName;
	}
	
	
	
	/**
	 * Clear the value of a certain session variable.
	 * 
	 * @access	public
	 * 
	 * @param	string	$key	The name of the session variable to clear.
	 */
	public function clear($key)
	{
		$this->set($key, null);
	}
	
	/**
	 * Get the value of a certain session variable.
	 * 
	 * @access	public
	 * 
	 * @param		string	$key	The name of the session variable to retrieve.
	 * @return	mixed					The variable value, if any.
	 */
	public function get($key)
	{
		//Add application specific key prefix, if any
		if ($this->applicationName())
			$key = $this->applicationName() . "_" . $key;
		
		//Return the session data, if any
		return array_key_exists($key, $_SESSION) ? unserialize($_SESSION[$key]) : null;
	}
	
	/**
	 * Set the value of a certain session variable.
	 * 
	 * @access	public
	 * 
	 * @param	string	$key		The name of the session variable to set.
	 * @param	mixed		$value	The variable value to set.
	 */
	public function set($key, $value)
	{
		//Add application specific key prefix, if any
		if ($this->applicationName())
			$key = $this->applicationName() . "_" . $key;
			
		//Set the session data
		$_SESSION[$key] = serialize($value);
	}
}

?>
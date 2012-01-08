<?php

/**
 * The Wigbi ApplicationCookie class file.
 * 
 * Wigbi is released under the MIT license. More info can be found
 * at http://www.opensource.org/licenses/mit-license.php
 */

/**
 * The Wigbi ApplicationCookie class.
 * 
 * This class can be used to handle cookie-based data. It persists
 * data directly to the cookie, without any serialization.
 * 
 * All this class does is to add the application name as prefix to
 * the cookie key, to ensure that this data is separated for a set
 * of applications running on the same server.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2012, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP.Web
 * @version			2.0.0
 */
class ApplicationCookie extends Cookie
{
	/**
	 * @param	string	$applicationName	The name of the application.
	 */
	public function __construct($applicationName)
	{
		$this->_applicationName = $applicationName;
	}
	
	
	/**
	 * Clear a certain cookie key.
	 * 
	 * @param	string	$key	The key to clear.
	 */
	function clear($key)
	{
		parent::clear($this->_applicationName . $key);
	}
	
	/**
	 * Retrieve a certain cookie key.
	 * 
	 * @param	string	$key		The key to retrieve.
	 * @param	mixed	$fallback	The value to return if the key does not exist.
	 * @return	mixed
	 */
	function get($key, $fallback = null)
	{
		return parent::get($this->_applicationName . $key, $fallback);
	}
	
	/**
	 * Set they value of a certain cookie key.
	 */
	function set($key, $value)
	{
		parent::set($this->_applicationName . $key, $value);
	}
}

?>
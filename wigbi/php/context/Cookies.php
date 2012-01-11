<?php

/**
 * The Wigbi Cookies class file.
 * 
 * Wigbi is released under the MIT license. More info can be found
 * at http://www.opensource.org/licenses/mit-license.php
 */

/**
 * The Wigbi Cookies class.
 * 
 * This class can be used to handle cookie-based data. It persists
 * data directly to the cookie, without any serialization.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2012, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP.Context
 * @version			2.0.0
 */
class Cookies implements ICookies
{
	private $_prefix;
	
	
	/**
	 * @param	string	$prefix		The prefix to add to each key name.
	 */
	public function __construct($prefix = "")
	{
		$this->_prefix = $prefix;
	}
	
	
	/**
	 * Clear a certain cookie key.
	 * 
	 * @param	string	$key	The key to clear.
	 */
	public function clear($key)
	{
		unset($_COOKIE[$this->getKey($key)]);
	}
	
	/**
	 * Retrieve a certain cookie key.
	 * 
	 * @param	string	$key		The key to retrieve.
	 * @param	mixed	$fallback	The value to return if the key does not exist.
	 * @return	mixed
	 */
	public function get($key, $fallback = null)
	{
		$key = $this->getKey($key);
		return isset($_COOKIE[$key]) ? $_COOKIE[$key] : $fallback;
	}
	
	/**
	 * Get the key to use to access the 
	 */
	private function getKey($key)
	{
		return $this->_prefix . $key;
	}
	
	/**
	 * Set they value of a certain cookie key.
	 */
	public function set($key, $value, $expire = 0, $path = "/", $domain = "", $secure = false, $httponly = false)
	{
		$_COOKIE[$this->getKey($key)] = $value;
		setcookie ($this->_prefix . $key, $value, $expire, $path, $domain, $secure, $httponly);
	}
}

?>
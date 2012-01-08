<?php

/**
 * The Wigbi Session class file.
 * 
 * Wigbi is released under the MIT license. More info can be found
 * at http://www.opensource.org/licenses/mit-license.php
 */

/**
 * The Wigbi Session class.
 * 
 * This class can be used to handle session-based data. It handles
 * all kinds of serializable data, but should be used with care. A
 * session-based system is less secure and more difficult to scale.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2012, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP.Web
 * @version			2.0.0
 */
class Session implements IContext
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
	 * Clear a certain session key.
	 * 
	 * @param	string	$key	The key to clear.
	 */
	public function clear($key)
	{
		unset($_SESSION[$this->getKey($key)]);
	}
	
	/**
	 * Retrieve a certain session key.
	 * 
	 * @param	string	$key		The key to retrieve.
	 * @param	mixed	$fallback	The value to return if the key does not exist.
	 * @return	mixed
	 */
	public function get($key, $fallback = null)
	{
		return isset($_SESSION[$this->getKey($key)]) ? unserialize($_SESSION[$this->getKey($key)]) : $fallback;
	}
	
	/**
	 * Get the key to use to access the 
	 */
	private function getKey($key)
	{
		return $this->_prefix . $key;
	}
	
	/**
	 * Set they value of a certain session key.
	 */
	public function set($key, $value)
	{
		$_SESSION[$this->getKey($key)] = serialize($value);
	}
}

?>
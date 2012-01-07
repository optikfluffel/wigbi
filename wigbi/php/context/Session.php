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
	/**
	 * Clear a certain session key.
	 * 
	 * @param	string	$key	The session key.
	 */
	function clear($key)
	{
		unset($_SESSION[$key]);
	}
	
	/**
	 * Retrieve a certain session key.
	 * 
	 * @param	string	$key		The session key name.
	 * @param	mixed	$fallback	The value to return if no session value exists.
	 * @return	mixed
	 */
	function get($key, $fallback = null)
	{
		return isset($_SESSION[$key]) ? unserialize($_SESSION[$key]) : $fallback;
	}
	
	/**
	 * Set they value of a certain session key.
	 */
	function set($key, $value)
	{
		$_SESSION[$key] = serialize($value);
	}
}

?>
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
 * @subpackage		PHP.Web
 * @version			2.0.0
 */
class Cookie implements ICookie
{
	/**
	 * Clear a certain cookie key.
	 * 
	 * @param	string	$key	The key to clear.
	 */
	function clear($key)
	{
		unset($_COOKIE[$key]);
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
		return isset($_COOKIE[$key]) ? $_COOKIE[$key] : $fallback;
	}
	
	/**
	 * Set they value of a certain cookie key.
	 */
	function set($key, $value, $expire = 0, $path = "/", $domain = "", $secure = false, $httponly = false)
	{
		$_COOKIE[$key] = $value;
		setcookie ($key, $value, $expire, $path, $domain, $secure, $httponly);
	}
}

?>
<?php

/**
 * The Wigbi ICookie interface file.
 * 
 * Wigbi is released under the MIT license. More info can be found
 * at http://www.opensource.org/licenses/mit-license.php
 */

/**
 * The Wigbi ICookie interface.
 * 
 * This interface can be implemented by any class that can be used
 * to retrieve and set cookie-based data by key.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2012, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP.Web
 * @version			2.0.0
 */
interface ICookie
{
	/**
	 * Clear a certain cookie key.
	 * 
	 * @param	string	$key	The key to clear.
	 */
	function clear($key);
	
	/**
	 * Retrieve a certain cookie key.
	 * 
	 * @param	string	$key		The key to retrieve.
	 * @param	mixed	$fallback	The value to return if the key does not exist.
	 * @return	mixed
	 */
	function get($key, $fallback = null);
	
	/**
	 * Set they value of a certain cookie key.
	 */
	function set($key, $value, $expire = 0, $path = "/", $domain = "", $secure = false, $httponly = false);
}

?>
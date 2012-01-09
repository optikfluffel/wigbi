<?php

/**
 * The Wigbi ISession interface file.
 * 
 * Wigbi is released under the MIT license. More info can be found
 * at http://www.opensource.org/licenses/mit-license.php
 */

/**
 * The Wigbi ISession interface.
 * 
 * This interface can be implemented by any class that can be used
 * to retrieve and set session-based data by key.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2012, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP.Context
 * @version			2.0.0
 */
interface ISession
{
	/**
	 * Clear a certain session key.
	 * 
	 * @param	string	$key	The key to clear.
	 */
	function clear($key);
	
	/**
	 * Retrieve a certain session key.
	 * 
	 * @param	string	$key		The key to retrieve.
	 * @param	mixed	$fallback	The value to return if the key does not exist.
	 * @return	mixed
	 */
	function get($key, $fallback = null);
	
	/**
	 * Set they value of a certain session key.
	 */
	function set($key, $value);
}

?>
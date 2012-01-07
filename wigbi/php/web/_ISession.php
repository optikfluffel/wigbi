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
 * to handle session data.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2012, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP.Web
 * @version			2.0.0
 */
interface ISession
{
	/**
	 * Clear a certain session key.
	 * 
	 * @param	string	$key	The session key.
	 */
	function clear($key);
	
	/**
	 * Retrieve a certain session key.
	 * 
	 * @param	string	$key		The session key name.
	 * @param	mixed	$fallback	The value to return if no session value exists.
	 * @return	mixed
	 */
	function get($key, $fallback = null);
	
	/**
	 * Set they value of a certain session key.
	 */
	function set($key, $value);
}

?>
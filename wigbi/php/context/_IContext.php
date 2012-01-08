<?php

/**
 * The Wigbi IContext interface file.
 * 
 * Wigbi is released under the MIT license. More info can be found
 * at http://www.opensource.org/licenses/mit-license.php
 */

/**
 * The Wigbi IContext interface.
 * 
 * This interface can be implemented by any class that can be used
 * to handle cached various context related read-only arrays, such
 * as $_ENV, $_GET, $_POST and $_REQUEST.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2012, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP.Context
 * @version			2.0.0
 */
interface IContext
{
	/**
	 * Get the value of a certain key in the $_ENV array.
	 * 
	 * @param	string	$key		The key to retrieve.
	 * @param	mixed	$fallback	The value to return if the key does not exist.
	 * @return	mixed
	 */
	function env($key, $fallback = null);
	
	/**
	 * Get the value of a certain key in the $_FILES array.
	 * 
	 * @param	string	$key		The key to retrieve.
	 * @param	mixed	$fallback	The value to return if the key does not exist.
	 * @return	mixed
	 */
	function files($key, $fallback = null);
	
	/**
	 * Get the value of a certain key in the $_GET array.
	 * 
	 * @param	string	$key		The key to retrieve.
	 * @param	mixed	$fallback	The value to return if the key does not exist.
	 * @return	mixed
	 */
	function get($key, $fallback = null);
	
	/**
	 * Get the value of a certain key in the $_POST array.
	 * 
	 * @param	string	$key		The key to retrieve.
	 * @param	mixed	$fallback	The value to return if the key does not exist.
	 * @return	mixed
	 */
	function post($key, $fallback = null);
	
	/**
	 * Get the value of a certain key in the $_REQUEST array.
	 * 
	 * @param	string	$key		The key to retrieve.
	 * @param	mixed	$fallback	The value to return if the key does not exist.
	 * @return	mixed
	 */
	function request($key, $fallback = null);
	
	/**
	 * Get the value of a certain key in the $_SERVER array.
	 * 
	 * @param	string	$key		The key to retrieve.
	 * @param	mixed	$fallback	The value to return if the key does not exist.
	 * @return	mixed
	 */
	function server($key, $fallback = null);
}

?>
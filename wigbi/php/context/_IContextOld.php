<?php

/**
 * The Wigbi IContext class file.
 * 
 * Wigbi is released under the MIT license. More info can be found
 * at http://www.opensource.org/licenses/mit-license.php
 */

/**
 * The Wigbi IContext class.
 * 
 * This interface can be implemented by any class that can be used
 * to handle cached various context related arrays, such as $_GET,
 * $_POST, $_COOKIES etc.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2012, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP
 * @version			2.0.0
 */
interface IContextOld
{
	/**
	 * Get the value of a certain key in the $_COOKIE array.
	 * 
	 * @param	string	$key		The key to retrieve.
	 * @param	mixed	$fallback	The value to return if the key does not exist.
	 * @return	mixed
	 */
	function cookie($key, $fallback = null);
	
	/**
	 * Get the value of a certain key in the $_ENV array.
	 * 
	 * @param	string	$key		The key to retrieve.
	 * @param	mixed	$fallback	The value to return if the key does not exist.
	 * @return	mixed
	 */
	function env($key, $fallback = null);
	
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
	
}

?>
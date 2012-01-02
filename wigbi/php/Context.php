<?php

/**
 * The Wigbi Context class file.
 * 
 * Wigbi is released under the MIT license. More info can be found
 * at http://www.opensource.org/licenses/mit-license.php
 */

/**
 * The Wigbi Context class.
 * 
 * This class can be used to handle various context related arrays,
 * like $_GET, $_POST, $_COOKIES etc.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2012, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP
 * @version			2.0.0
 */
class Context implements IContext
{
	private static $_instance;
	
	
	/**
	 * Get the value of a certain key in the $_GET array.
	 * 
	 * @param	string	$key		The key to retrieve.
	 * @param	mixed	$fallback	The value to return if the key does not exist.
	 * @return	mixed
	 */
	public function get($key, $fallback = null)
	{
		return array_key_exists($key, $_GET) ? $_GET[$key] : $fallback;
	}
	
	/**
	 * Get the default instance of the class.
	 * 
	 * @return	Context
	 */
	public static function instance()
	{
		if (Context::$_instance == null)
			Context::$_instance = new Context();
		return Context::$_instance;
	}
	
	/**
	 * Get the value of a certain key in the $_POST array.
	 * 
	 * @param	string	$key		The key to retrieve.
	 * @param	mixed	$fallback	The value to return if the key does not exist.
	 * @return	mixed
	 */
	public function post($key, $fallback = null)
	{
		return array_key_exists($key, $_POST) ? $_POST[$key] : $fallback;
	}
}

?>